<?php

require_once APPROOT . '/repositories/CartRepository.php';
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

    // In CartController.php

    public function home()
    {
        // This will redirect to the viewCart method if someone navigates to just /CartController
        redirect('CartController/viewCart');
    }


    public function viewCart()
    {


        $cart_items = [];
        $cartSessionKey = isLoggedIn() ? 'cart' : 'guest_cart';

        if (isLoggedIn()) {
            $cartRepo = new CartRepository($this->db);
            $userId = $_SESSION['user_id'];
            $cartFromDb = $cartRepo->getCartItemsByUserId($userId); // fetch from DB


            $_SESSION[$cartSessionKey] = [];
            foreach ($cartFromDb as $item) {
                $cart_items[] = [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'product_img' => $item['product_img'],
                    'quantity' => $item['quantity'],
                ];
                $_SESSION[$cartSessionKey][$item['product_id']] = [
                    'quantity' => $item['quantity']
                ];
            }
        } else {
            // Guest cart
            $guestCart = $_SESSION[$cartSessionKey] ?? [];
            if (!empty($guestCart)) {
                $productModel = $this->model('Product');
                foreach ($guestCart as $productId => $item) {
                    $productDetails = $productModel->getProductById($productId);
                    if ($productDetails) {
                        $cart_items[] = [
                            'product_id'   => $productId,
                            'product_name' => $productDetails->product_name,
                            'price'        => $productDetails->price,
                            'product_img'  => $productDetails->product_img ?? null,
                            'quantity'     => $item['quantity'],
                        ];
                    }
                }
            }
        }
        $data['cart_items'] = $cart_items;

        $this->view('user/cart/index', $data);
    }




    public function addToCart()
    {

        // Ensure the request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('pages/index');
            return;
        }

        $product_id = $_POST['product_id'] ?? 0;
        $quantity_to_add = $_POST['quantity'] ?? 0;

        // Validate product ID and quantity
        if ($product_id <= 0 || $quantity_to_add <= 0) {
            setMessage('error', 'Invalid product or quantity.');
            redirect('pages/index');
            return;
        }

        $product = $this->db->getById('products', $product_id);


        if (!$product) {
            setMessage('error', 'Product not found.');
            redirect('pages/index');
            return;
        }

        // Handle logged-in user cart logic
        if (isLoggedIn()) {
            $cartRepo = new CartRepository($this->db);
            $userCart = $cartRepo->getUserCart($_SESSION['user_id']);

            $currentQty = 0;

            foreach ($userCart as $item) {
                if ($item['product_id'] == $product_id) {
                    $currentQty = $item['quantity'];
                    break;
                }
            }

            $totalQty = $currentQty + $quantity_to_add;


            if ($totalQty > $product['quantity']) {
                $left = max(0, $product['quantity'] - $currentQty);
                setMessage('error', 'Not enough stock available. Only ' . $left . ' left.');
                redirect('CartController/viewCart');
                return;
            }

            if ($currentQty > 0) {
                $cartRepo->updateCartItem($_SESSION['user_id'], $product_id, $totalQty);
            } else {
                $cartRepo->addCartItem($_SESSION['user_id'], $product_id, $quantity_to_add, $product['price']);
            }

            setMessage('success', 'Product added to cart successfully!');
            redirect('CartController/viewCart');
            return;
        }
        // Handle guest user session cart logic
        else {
            // Initialize guest cart if it doesn't exist
            if (!isset($_SESSION['guest_cart'])) {
                $_SESSION['guest_cart'] = [];
            }

            if (isset($_SESSION['guest_cart'][$product_id])) {
                $_SESSION['guest_cart'][$product_id]['quantity'] += $quantity_to_add;
            } else {
                $_SESSION['guest_cart'][$product_id] = [
                    'product_id' => $product_id,
                    'product_name' => $product['product_name'],
                    'price' => $product['price'],
                    'quantity' => $quantity_to_add,
                    'product_img' => $product['product_img']
                ];
            }

            $_SESSION['redirect_to'] = 'CartController/viewCart';

            setMessage('success', 'Item added to cart. Please log in to checkout.');
            redirect('Auth/login');
            return;
        }
    }


    public function updateCart()
    {

        header('Content-Type: application/json');



        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['quantity']) || !is_array($_POST['quantity'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request.']);
            return;
        }


        $cartSessionKey = isLoggedIn() ? 'cart' : 'guest_cart';
        $cartRepo = isLoggedIn() ? new CartRepository($this->db) : null;

        foreach ($_POST['quantity'] as $productId => $newQuantity) {
            $productId   = (int) filter_var($productId, FILTER_SANITIZE_NUMBER_INT);
            $newQuantity = max(0, (int) filter_var($newQuantity, FILTER_SANITIZE_NUMBER_INT));

            if (!isset($_SESSION[$cartSessionKey][$productId])) continue;

            if ($newQuantity === 0) {
                unset($_SESSION[$cartSessionKey][$productId]);
                if ($cartRepo) $cartRepo->removeCartItem($_SESSION['user_id'], $productId);
                continue;
            }

            $product = $this->db->getById('products', $productId);
            if (!$product) {
                unset($_SESSION[$cartSessionKey][$productId]);
                continue;
            }

            $availableStock = (int) $product['quantity'];
            if ($newQuantity > $availableStock) $newQuantity = $availableStock;

            $_SESSION[$cartSessionKey][$productId]['quantity'] = $newQuantity;
            if ($cartRepo) $cartRepo->updateCartItem($_SESSION['user_id'], $productId, $newQuantity);
        }


        // Recalculate totals
        $cartItems = [];
        $subtotal = 0;
        $delivery_fee = 5.00;
        $tax_rate = 0.05;

        foreach ($_SESSION[$cartSessionKey] as $productId => $item) {
            $product = $this->db->getById('products', $productId);
            if ($product) {
                $price = $product['price'];
                $quantity = $item['quantity'];
                $subtotal += $price * $quantity;
                $cartItems[] = [
                    'product_id' => $productId,
                    'product_name' => $product['product_name'],
                    'price' => $price,
                    'quantity' => $quantity,
                ];
            }
        }

        $tax_amount = $subtotal * $tax_rate;
        $grand_total = $subtotal + $tax_amount + $delivery_fee;

        echo json_encode([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cartItems,
            'subtotal' => $subtotal,
            'tax_amount' => $tax_amount,
            'delivery_fee' => $delivery_fee,
            'grand_total' => $grand_total
        ]);

        session_write_close();
    }






    public function removeFromCart()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setMessage('error', 'Invalid request.');
            redirect('CartController/viewCart');
            return;
        }

        $product_id = (int) $_POST['product_id']; // Using a simple cast is sufficient here

        if (isLoggedIn()) {
            $cartRepo = new CartRepository($this->db);
            $userId = $_SESSION['user_id'];

            // Directly interact with the database, as it's the source of truth for logged-in users
            $result = $cartRepo->removeCartItem($userId, $product_id);

            if ($result) {
                // Unset the item from the session to keep it clean, if it exists
                if (isset($_SESSION['cart'][$product_id])) {
                    $productName = $_SESSION['cart'][$product_id]['product_name'] ?? 'Product';
                    unset($_SESSION['cart'][$product_id]);
                    setMessage('success', "$productName has been removed from your cart.");
                } else {
                    setMessage('success', "Item has been removed from your cart.");
                }
            } else {
                setMessage('error', 'Failed to remove item from your cart. Please try again.');
            }
        } else { // This block is for guest users, who rely solely on the session
            $cartSessionKey = 'guest_cart';
            if (isset($_SESSION[$cartSessionKey][$product_id])) {
                $productName = $_SESSION[$cartSessionKey][$product_id]['product_name'] ?? 'Product';
                unset($_SESSION[$cartSessionKey][$product_id]);
                setMessage('success', "$productName has been removed from your cart.");
            } else {
                setMessage('error', 'That item was not found in your cart.');
            }
        }

        redirect('CartController/viewCart');
    }

    public function removeAll()
    {

        if (isLoggedIn()) {

            $cartRepo = new CartRepository($this->db);
            $userId = $_SESSION['user_id'];

            // The session is not the primary storage, the database is.
            $result = $cartRepo->clearCart($userId);


            if ($result) {
                // Also unset the session to keep it clean, although not the source of truth
                unset($_SESSION['cart']);
                setMessage('success', 'All items have been removed from your cart.');
            } else {
                setMessage('error', 'Failed to clear your cart. Please try again.');
            }
        } else { // This block is for guest users

            $cartSessionKey = 'guest_cart';
            if (isset($_SESSION[$cartSessionKey])) {
                unset($_SESSION[$cartSessionKey]);
                setMessage('success', 'All items have been removed from your cart.');
            } else {
                setMessage('info', 'Your cart is already empty.');
            }
        }

        redirect('CartController/viewCart');
    }

    public function checkout()
    {
        $cartItems = [];
        $subtotal = 0;

        // Determine session key
        $cartSessionKey = isLoggedIn() ? 'cart' : 'guest_cart';

        if (isLoggedIn()) {
            // Logged-in users: fetch cart directly from DB
            $cartRepo = new CartRepository($this->db);
            $cartItemsFromDb = $cartRepo->getUserCart($_SESSION['user_id']);
            // Sync session cart to reflect DB state immediately
            $_SESSION[$cartSessionKey] = [];
            foreach ($cartItemsFromDb as $item) {
                $cartItems[] = [
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'product_name' => $item['product_name'],
                    'price'        => $item['price'],
                    'product_img'  => $item['product_img'] ?? null
                ];

                // Update session for use in viewCart() and updateCart()
                $_SESSION[$cartSessionKey][$item['product_id']] = [
                    'quantity' => $item['quantity']
                ];
            }
        } else {
            // Guest users: fetch latest cart from session and attach product details
            $guestCart = $_SESSION[$cartSessionKey] ?? [];
            if (!empty($guestCart)) {
                $productModel = $this->model('Product');
                foreach ($guestCart as $productId => $item) {
                    $productDetails = $productModel->getProductById($productId);
                    if ($productDetails) {
                        $cartItems[] = [
                            'product_id' => $productId,
                            'quantity' => $item['quantity'],
                            'product_name' => $productDetails->product_name,
                            'price' => $productDetails->price,
                            'product_img' => $productDetails->product_img ?? null
                        ];
                    }
                }
            }
        }

        // If cart is empty, redirect
        if (empty($cartItems)) {
            setMessage('error', 'Your cart is empty. Please add some products before checking out.');
            redirect('pages/index');
            return;
        }

        // Get user phone number if logged in
        $user_phone_number = '';
        if (isLoggedIn()) {
            $this->db->query("SELECT phone_number FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $_SESSION['user_id']);
            $user_details = $this->db->single();
            if ($user_details) {
                $user_phone_number = $user_details->phone_number;
            }
        }

        // Payment options
        $this->db->query("SELECT id, payment_name FROM payments");
        $payments = $this->db->resultSet();

        // Calculate totals
        $delivery_fee = 5.00;
        $tax_rate = 0.05;

        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax_amount = $subtotal * $tax_rate;
        $grand_total = $subtotal + $tax_amount + $delivery_fee;

        $data = [
            'cart' => $cartItems,
            'payments' => $payments,
            'user_phone_number' => $user_phone_number,
            'subtotal' => $subtotal,
            'delivery_fee' => $delivery_fee,
            'tax_amount' => $tax_amount,
            'grand_total' => $grand_total
        ];

        $this->view('user/cart/checkout', $data);
    }





    public function placeOrder()
    {
        $cartSessionKey = isLoggedIn() ? 'cart' : 'guest_cart';


        // --- Validate request ---
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION[$cartSessionKey])) {
            setMessage('error', 'Invalid request or empty cart.');
            redirect('CartController/viewCart');
            exit; // It's a good practice to exit after a redirect
        }


        $cart    = $_SESSION[$cartSessionKey];
        $user_id = $_SESSION['user_id'] ?? null;


        // --- Collect and sanitize form input ---
        $name              = trim($_POST['name'] ?? '');
        $email             = trim($_POST['email'] ?? '');
        $phone_number      = trim($_POST['phone_number'] ?? '');
        $delivery_address  = trim($_POST['delivery_address'] ?? '');
        $payment_method_id = $_POST['payment_method_id'] ?? 1;

        if (!$name || !$email || !$phone_number || !$delivery_address) {
            setMessage('error', 'Please fill out all required fields.');
            redirect('CartController/checkout');
            exit;
        }

        // --- Fees and calculations ---
        $delivery_fee = 5.00;
        $tax_rate     = 0.05;
        $subtotal     = 0;

        // --- Validate stock and calculate subtotal ---
        foreach ($cart as $product_id => $item) {
            $this->db->query("SELECT product_name, price, quantity FROM products WHERE id = :id");
            $this->db->bind(':id', $product_id);
            $product = $this->db->single();


            if (!$product) {
                setMessage('error', "Product ID {$product_id} not found.");
                redirect('CartController/viewCart');
                exit;
            }

            if ($item['quantity'] > $product->quantity) {
                setMessage('error', "Not enough stock for {$product->product_name}. Please update your cart.");
                redirect('CartController/viewCart');
                exit;
            }
            $subtotal += $product->price * $item['quantity'];
        }

        $tax_amount  = $subtotal * $tax_rate;
        $grand_total = $subtotal + $tax_amount + $delivery_fee;


        // --- Begin transaction ---
        $this->db->beginTransaction();

        try {
            // Insert order
            $this->db->query("
            INSERT INTO orders
            (user_id,  payment_method_id, total_amt, delivery_address, delivery_fee, tax_amount, grand_total, status)
            VALUES
            (:user_id,  :payment_method_id, :total_amt, :delivery_address, :delivery_fee, :tax_amount, :grand_total, 'pending')
        ");
            $this->db->bind(':user_id', $user_id);


            $this->db->bind(':payment_method_id', $payment_method_id);
            $this->db->bind(':total_amt', $subtotal);
            $this->db->bind(':delivery_address', $delivery_address);
            $this->db->bind(':delivery_fee', $delivery_fee);
            $this->db->bind(':tax_amount', $tax_amount);
            $this->db->bind(':grand_total', $grand_total);
            $this->db->execute();

            $order_id = $this->db->lastInsertId();


            // Insert order items & update stock
            foreach ($cart as $product_id => $item) {
                $this->db->query("SELECT price FROM products WHERE id = :id");
                $this->db->bind(':id', $product_id);
                $product = $this->db->single();

                // Insert order item
                $this->db->query("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (:order_id, :product_id, :quantity, :price)
            ");
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':product_id', $product_id);
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':price', $product->price);
                $this->db->execute();

                // Update stock
                $this->db->query("UPDATE products SET quantity = quantity - :quantity WHERE id = :id");
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':id', $product_id);
                $this->db->execute();
            }

            // Create invoice
            $invoice_number = 'INV-' . date('YmdHis') . '-' . $order_id;
            $created_at     = date('Y-m-d H:i:s');

            $this->db->query("
            INSERT INTO invoices (invoice_number, order_id, status, created_at)
            VALUES (:invoice_number, :order_id, 'pending', :created_at)
        ");
            $this->db->bind(':invoice_number', $invoice_number);
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':created_at', $created_at);
            $this->db->execute();

            $this->db->commit();

            // Clear cart after successful order
            unset($_SESSION[$cartSessionKey]);
            // Clear DB cart for logged-in users
            if (isLoggedIn()) {
                $cartRepo = new CartRepository($this->db);
                $cartRepo->clearCart($_SESSION['user_id']); // you need to implement this method
            }

            setMessage('success', "Order placed successfully! Your order ID is #{$order_id}");
            redirect("CartController/orderConfirmation/{$order_id}");
            exit; // Important: Exit the script after the redirect.

        } catch (Exception $e) {
            var_dump($e->getMessage());
            die('DB insert failed');
        }
    }





    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    //         $delivery_address = trim($_POST['delivery_address']);
    //         $payment_method_id = $_POST['payment_method_id'];

    //         // Determine which cart to use based on user's login status
    //         $currentCart = [];
    //         if (isLoggedIn()) {
    //             $currentCart = $_SESSION['cart'] ?? [];
    //         } else {
    //             $currentCart = $_SESSION['guest_cart'] ?? [];
    //         }

    //         if (empty($currentCart)) {
    //             setMessage('error', 'Your cart is empty.');
    //             redirect('CartController/viewCart');
    //             return;
    //         }

    //         $delivery_fee = 5.00;
    //         $tax_rate = 0.05;
    //         $subtotal = 0;

    //         $this->db->beginTransaction();

    //         try {
    //             // First loop to validate stock and calculate subtotal
    //             foreach ($currentCart as $item) {
    //                 // Fetch full product details including price and stock
    //                 $this->db->query("SELECT id, quantity, price, product_name FROM products WHERE id = :id");
    //                 $this->db->bind(':id', $item['product_id']);
    //                 $product_details = $this->db->single();

    //                 if (!$product_details || $item['quantity'] > $product_details->quantity) {
    //                     $this->db->rollback();
    //                     setMessage('error', 'Not enough stock for ' . ($product_details->product_name ?? 'a product') . '. Please update your cart.');
    //                     redirect('CartController/viewCart');
    //                     return;
    //                 }

    //                 $subtotal += $product_details->price * $item['quantity'];
    //             }

    //             $tax_amount = $subtotal * $tax_rate;
    //             $grand_total = $subtotal + $tax_amount + $delivery_fee;

    //             // 1. Insert into orders table
    //             $this->db->query("INSERT INTO orders (user_id, payment_method_id, total_amt, delivery_address, delivery_fee, tax_amount, grand_total, status) VALUES (:user_id, :payment_method_id, :total_amt, :delivery_address, :delivery_fee, :tax_amount, :grand_total, 'pending')");
    //             $this->db->bind(':user_id', $user_id);
    //             $this->db->bind(':payment_method_id', $payment_method_id);
    //             $this->db->bind(':total_amt', $subtotal);
    //             $this->db->bind(':delivery_address', $delivery_address);
    //             $this->db->bind(':delivery_fee', $delivery_fee);
    //             $this->db->bind(':tax_amount', $tax_amount);
    //             $this->db->bind(':grand_total', $grand_total);
    //             $this->db->execute();
    //             $order_id = $this->db->lastInsertId();

    //             // 2. Insert into order_items and update product stock
    //             foreach ($currentCart as $item) {
    //                 // Fetch full product details again for price
    //                 $this->db->query("SELECT id, price FROM products WHERE id = :id");
    //                 $this->db->bind(':id', $item['product_id']);
    //                 $product_details = $this->db->single();

    //                 // Insert into order_items
    //                 $this->db->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
    //                 $this->db->bind(':order_id', $order_id);
    //                 $this->db->bind(':product_id', $item['product_id']);
    //                 $this->db->bind(':quantity', $item['quantity']);
    //                 $this->db->bind(':price', $product_details->price);
    //                 $this->db->execute();

    //                 // Decrement stock
    //                 $this->db->query("UPDATE products SET quantity = quantity - :quantity WHERE id = :id");
    //                 $this->db->bind(':quantity', $item['quantity']);
    //                 $this->db->bind(':id', $item['product_id']);
    //                 $this->db->execute();
    //             }

    //             // Invoice Creation
    //             $invoice_number = 'INV-' . date('YmdHis') . '-' . $order_id;
    //             $created_at = date('Y-m-d H:i:s');
    //             $this->db->query("INSERT INTO invoices (invoice_number, order_id, status, created_at) VALUES (:invoice_number, :order_id, 'pending', :created_at)");
    //             $this->db->bind(':invoice_number', $invoice_number);
    //             $this->db->bind(':order_id', $order_id);
    //             $this->db->bind(':created_at', $created_at);
    //             $this->db->execute();

    //             $this->db->commit();

    //             // Unset the correct session variable
    //             if (isLoggedIn()) {
    //                  unset($_SESSION['cart']);
    //             } else {
    //                  unset($_SESSION['guest_cart']);
    //             }

    //             setMessage('success', 'Order placed successfully! Your order ID is #' . $order_id);
    //             redirect('CartController/orderConfirmation/' . $order_id);

    //         } catch (Exception $e) {
    //             $this->db->rollback();
    //             setMessage('error', 'An error occurred while placing your order. Please try again. ' . $e->getMessage());
    //             redirect('CartController/checkout');
    //         }
    //     } else {
    //         setMessage('error', 'Invalid request.');
    //         redirect('pages/index');
    //     }
    // }

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


    // public function updateCart()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity']) && is_array($_POST['quantity'])) {
    //         if (!isset($_SESSION['cart'])) {
    //             $_SESSION['cart'] = [];
    //         }

    //         foreach ($_POST['quantity'] as $productId => $newQuantity) {
    //             $productId = filter_var($productId, FILTER_SANITIZE_NUMBER_INT);
    //             $newQuantity = filter_var($newQuantity, FILTER_SANITIZE_NUMBER_INT);

    //             // Get current stock from the database
    //             $this->db->query("SELECT quantity FROM products WHERE id = :id");
    //             $this->db->bind(':id', $productId);
    //             $product = $this->db->single();

    //             if ($product && isset($_SESSION['cart'][$productId])) {
    //                 if ($newQuantity > 0) {
    //                     if ($newQuantity <= $product->quantity) {
    //                         $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
    //                     } else {
    //                         // Automatically adjust quantity to the max available stock and warn the user
    //                         $_SESSION['cart'][$productId]['quantity'] = $product->quantity;
    //                         setMessage('warning', 'The quantity for ' . $_SESSION['cart'][$productId]['name'] . ' has been reduced to the available stock of ' . $product->quantity . '.');
    //                     }
    //                 } else {
    //                     // If quantity is 0 or less, remove the item entirely
    //                     unset($_SESSION['cart'][$productId]);
    //                     setMessage('info', $_SESSION['cart'][$productId]['name'] . ' has been removed from your cart.');
    //                 }
    //             }
    //         }
    //         setMessage('success', 'Cart updated successfully!');
    //         redirect('CartController/viewCart');
    //     } else {
    //         setMessage('error', 'Invalid request.');
    //         redirect('CartController/viewCart');
    //     }
    // }






}
