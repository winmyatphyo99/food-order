<?php

class CartController extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function index()
    {
        // Redirect to the main cart viewing method
        $this->viewCart();
    }
    public function viewCart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $data = [
            'cart' => $cart
        ];
        $this->view('user/cart/index', $data);
    }

    public function addToCart()
{

    if (!isLoggedIn()) {
        // If not logged in, set a message and redirect to the login page.
        // You can also add a session variable to store the intended page URL
        // so the user can be redirected back to the menu after logging in.
        $_SESSION['redirect_to'] = URLROOT . '/CartController/addToCart'; // or the current product page
        
        setMessage('error', 'Please log in to add items to your cart.');
        redirect('Auth/login');
        return;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_id = $_POST['product_id'];
        $quantity_to_add = $_POST['quantity'];

        $this->db->query("SELECT * FROM products WHERE id = :id");
        $this->db->bind(':id', $product_id);
        $product = $this->db->single();

        if ($product) {
            // Check for valid quantity first
            if ($quantity_to_add <= 0) {
                setMessage('error', 'Quantity must be greater than zero.');
                redirect('CartController/viewCart');
                return;
            }

            $current_cart_quantity = 0;
            if (isset($_SESSION['cart'][$product_id])) {
                $current_cart_quantity = $_SESSION['cart'][$product_id]['quantity'];
            }

            $total_requested_quantity = $current_cart_quantity + $quantity_to_add;

            if ($total_requested_quantity > $product->quantity) {
                setMessage('error', 'Not enough stock available. Only ' . ($product->quantity - $current_cart_quantity) . ' left.');
                redirect('CartController/viewCart');
                return;
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity_to_add;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'price' => $product->price,
                    'image' => $product->product_img,
                    'quantity' => $quantity_to_add
                ];
            }

            setMessage('success', 'Product added to cart successfully!');
            redirect('CartController/viewCart');

        } else {
            setMessage('error', 'Product not found.');
            redirect('CartController/viewCart');
        }
    } else {
        // If the request method is not POST, redirect to the cart view
        redirect('CartController/viewCart');
    }
}
    public function removeFromCart()
    {
        // The rest of the code is the same as your removeOne() method
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
            $product_id = (int) $product_id;

            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] -= 1;

                if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
            }

            redirect('CartController/viewCart');
        }
    }
    public function checkout()
    {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $user_phone_number = '';
            if (isset($_SESSION['user_id'])) {
                $this->db->query("SELECT phone_number FROM users WHERE id = :user_id");
                $this->db->bind(':user_id', $_SESSION['user_id']);
                $user_details = $this->db->single();
                if ($user_details) {
                    $user_phone_number = $user_details->phone_number;
                }
            }

            $this->db->query("SELECT id, payment_name FROM payments");
            $payments = $this->db->resultSet();

            $delivery_fee = 5.00;
            $tax_rate = 0.05;

            $subtotal = 0;
            foreach ($_SESSION['cart'] as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $tax_amount = $subtotal * $tax_rate;
            $grand_total = $subtotal + $tax_amount + $delivery_fee;

            $data = [
                'cart' => $_SESSION['cart'],
                'payments' => $payments,
                'user_phone_number' => $user_phone_number,
                'subtotal' => $subtotal,
                'delivery_fee' => $delivery_fee,
                'tax_amount' => $tax_amount,
                'grand_total' => $grand_total
            ];

            $this->view('user/cart/checkout', $data);
        } else {
            setMessage('error', 'Your cart is empty. Please add some products before checking out.');
            redirect('pages/index');
        }
    }


    public function placeOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $delivery_address = trim($_POST['delivery_address']);
            $payment_method_id = $_POST['payment_method_id'];

            $delivery_fee = 5.00;
            $tax_rate = 0.05;

            $subtotal = 0;
            foreach ($_SESSION['cart'] as $item) {
                // Final stock re-validation to prevent race conditions
                $this->db->query("SELECT quantity FROM products WHERE id = :id");
                $this->db->bind(':id', $item['id']);
                $product_stock = $this->db->single()->quantity;

                if ($item['quantity'] > $product_stock) {
                    setMessage('error', 'Not enough stock for ' . $item['name'] . '. Please update your cart.');
                    redirect('CartController/viewCart');
                    return;
                }

                $subtotal += $item['price'] * $item['quantity'];
            }

            $tax_amount = $subtotal * $tax_rate;
            $grand_total = $subtotal + $tax_amount + $delivery_fee;

            $this->db->beginTransaction();

            try {
                // 1. Insert into orders table
                $this->db->query("INSERT INTO orders (user_id, payment_method_id, total_amt, delivery_address, delivery_fee, tax_amount, grand_total, status) VALUES (:user_id, :payment_method_id, :total_amt, :delivery_address, :delivery_fee, :tax_amount, :grand_total, 'pending')");

                $this->db->bind(':user_id', $user_id);
                $this->db->bind(':payment_method_id', $payment_method_id);
                $this->db->bind(':total_amt', $subtotal);
                $this->db->bind(':delivery_address', $delivery_address);
                $this->db->bind(':delivery_fee', $delivery_fee);
                $this->db->bind(':tax_amount', $tax_amount);
                $this->db->bind(':grand_total', $grand_total);

                $this->db->execute();
                $order_id = $this->db->lastInsertId();

                // 2. Insert into order_items and update product stock
                foreach ($_SESSION['cart'] as $item) {
                    // Insert into order_items
                    $this->db->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                    $this->db->bind(':order_id', $order_id);
                    $this->db->bind(':product_id', $item['id']);
                    $this->db->bind(':quantity', $item['quantity']);
                    $this->db->bind(':price', $item['price']);
                    $this->db->execute();

                    // Decrement stock
                    $this->db->query("UPDATE products SET quantity = quantity - :quantity WHERE id = :id");
                    $this->db->bind(':quantity', $item['quantity']);
                    $this->db->bind(':id', $item['id']);
                    $this->db->execute();
                }

                // Invoice Creation
                $invoice_number = 'INV-' . date('YmdHis') . '-' . $order_id;
                $created_at = date('Y-m-d H:i:s');
                $this->db->query("INSERT INTO invoices (invoice_number, order_id, status, created_at) 
                VALUES (:invoice_number, :order_id, 'pending', :created_at)");
                $this->db->bind(':invoice_number', $invoice_number);
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':created_at', $created_at);
                $this->db->execute();

                // All database operations succeeded, commit the transaction
                $this->db->commit();

                unset($_SESSION['cart']);

                setMessage('success', 'Order placed successfully! Your order ID is #' . $order_id);
                redirect('CartController/orderConfirmation/' . $order_id);
            } catch (Exception $e) {
                // An error occurred, rollback all database changes
                $this->db->rollback();
                setMessage('error', 'An error occurred while placing your order. Please try again. ' . $e->getMessage());
                redirect('CartController/checkout');
            }
        } else {
            setMessage('error', 'Invalid request or empty cart.');
            redirect('CartController/viewCart');
        }
    }

    public function orderConfirmation($order_id)
    {
        $this->db->query("SELECT * FROM order_details WHERE order_id = :order_id");
        $this->db->bind(':order_id', $order_id);
        $order_data = $this->db->single();

        $this->db->query("SELECT * FROM order_items_view WHERE order_id = :order_id");
        $this->db->bind(':order_id', $order_id);
        $order_items = $this->db->resultSet();

        if ($order_data && $order_items) {
            $data = [
                'order_details' => $order_data,
                'order_items' => $order_items
            ];
            $this->view('user/cart/orderConfirmation', $data);
        } else {
            setMessage('error', 'Order not found.');
            redirect('pages/index');
        }
    }


    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity']) && is_array($_POST['quantity'])) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            foreach ($_POST['quantity'] as $productId => $newQuantity) {
                $productId = filter_var($productId, FILTER_SANITIZE_NUMBER_INT);
                $newQuantity = filter_var($newQuantity, FILTER_SANITIZE_NUMBER_INT);

                // Get current stock from the database
                $this->db->query("SELECT quantity FROM products WHERE id = :id");
                $this->db->bind(':id', $productId);
                $product = $this->db->single();

                if ($product && isset($_SESSION['cart'][$productId])) {
                    if ($newQuantity > 0) {
                        if ($newQuantity <= $product->quantity) {
                            $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
                        } else {
                            // Automatically adjust quantity to the max available stock and warn the user
                            $_SESSION['cart'][$productId]['quantity'] = $product->quantity;
                            setMessage('warning', 'The quantity for ' . $_SESSION['cart'][$productId]['name'] . ' has been reduced to the available stock of ' . $product->quantity . '.');
                        }
                    } else {
                        // If quantity is 0 or less, remove the item entirely
                        unset($_SESSION['cart'][$productId]);
                        setMessage('info', $_SESSION['cart'][$productId]['name'] . ' has been removed from your cart.');
                    }
                }
            }
            setMessage('success', 'Cart updated successfully!');
            redirect('CartController/viewCart');
        } else {
            setMessage('error', 'Invalid request.');
            redirect('CartController/viewCart');
        }
    }

    public function removeAll()
    {
        // Check if the cart session variable exists
        if (isset($_SESSION['cart'])) {
            // Unset the entire cart session
            unset($_SESSION['cart']);
            setMessage('success', 'All items have been removed from your cart.');
        } else {
            setMessage('info', 'Your cart is already empty.');
        }

        // Redirect back to the cart view
        redirect('CartController/viewCart');
    }
   
public function addToSession()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

      
        $this->db->query("SELECT * FROM products WHERE id = :id");
        $this->db->bind(':id', $product_id);
        $product = $this->db->single();

        if ($product) {
            if (!isset($_SESSION['temp_cart'])) {
                $_SESSION['temp_cart'] = [];
            }
            
            $_SESSION['temp_cart'][$product_id] = [
                'item' => $product,
                'quantity' => $quantity
            ];
            setMessage('success', 'Please login first!');
        }
    }
    // Redirect the user back to the page they came from
     redirect('pages/login'); 
}
}
