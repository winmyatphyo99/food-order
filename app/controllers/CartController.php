<?php

class CartController extends Controller
{
        private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

//     public function index()
// {
//     redirect('CartController/viewCart');
// }




    public function viewCart(){
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $data = [
            'cart' => $cart
        ];
        $this->view('user/cart/index', $data);
    }

    
    public function addToCart()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            
            $this->db->query("SELECT * FROM products WHERE id = :id");
            $this->db->bind(':id', $product_id);
            $product = $this->db->single();

            // echo '<pre>';
            // var_dump($product);exit();

            if ($product) {
                
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                
                if (isset($_SESSION['cart'][$product_id])) {
                    
                    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                } else {
                    
                    $_SESSION['cart'][$product_id] = [
                        // Use object syntax -> to get properties from the $product object
                        'id' => $product->id,
                        'name' => $product->product_name,
                        'price' => $product->price,
                        'image' => $product->product_img,
                        'quantity' => $quantity
                    ];
                }

                setMessage('success', 'Product added to cart successfully!');
                redirect('CartController/viewCart'); 

            } else {
                
                setMessage('error', 'Product not found.');
                redirect('pages/home');
            }
        } else {
            
            redirect('pages/home');
        }
    }

   // app/controllers/CartController.php

public function removeFromCart()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_id = $_POST['product_id'];

        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            setMessage('success', 'Product removed from cart successfully.');
        } else {
            setMessage('error', 'Product not found in cart.');
        }
    }

    redirect('CartController/viewCart');
}


public function checkout()
{
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Fetch user's phone number if they are logged in
        $user_phone_number = '';
        if(isset($_SESSION['user_id'])){
            $this->db->query("SELECT phone_number FROM users WHERE id = :user_id");
            $this->db->bind(':user_id', $_SESSION['user_id']);
            $user_details = $this->db->single();
            if($user_details){
                $user_phone_number = $user_details->phone_number;
            }
        }
        
        // Fetch payment methods from the payments table
        $this->db->query("SELECT id, payment_name FROM payments");
        $payments = $this->db->resultSet();
        
        // Set delivery fee and tax rate
        $delivery_fee = 5.00; // Example delivery fee
        $tax_rate = 0.05; // 5% tax rate

        // Calculate subtotal
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Calculate tax amount and grand total
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
        // Retrieve form data
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $delivery_address = trim($_POST['delivery_address']);
        $payment_method_id = $_POST['payment_method_id'];
        

        // Define tax and delivery rates
        $delivery_fee = 5.00; // Sample delivery fee
        $tax_rate = 0.05; // 5% tax rate

        // Calculate subtotal
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Calculate tax amount and grand total
        $tax_amount = $subtotal * $tax_rate;
        $grand_total = $subtotal + $tax_amount + $delivery_fee;

        // 1. Insert into orders table with all necessary columns
        $this->db->query("INSERT INTO orders (user_id, payment_method_id, total_amt, delivery_address, delivery_fee, tax_amount, grand_total, status) VALUES (:user_id, :payment_method_id, :total_amt, :delivery_address, :delivery_fee, :tax_amount, :grand_total, 'pending')");
        
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':payment_method_id', $payment_method_id);
        $this->db->bind(':total_amt', $subtotal);
        $this->db->bind(':delivery_address', $delivery_address);
        $this->db->bind(':delivery_fee', $delivery_fee);
        $this->db->bind(':tax_amount', $tax_amount);
        $this->db->bind(':grand_total', $grand_total);
        
        if ($this->db->execute()) {
            $order_id = $this->db->lastInsertId();

            // 2. Insert into order_items table
            foreach ($_SESSION['cart'] as $item) {
                $this->db->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':product_id', $item['id']);
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':price', $item['price']);
                $this->db->execute();
            }

            

            //Invoice Creation
            $invoice_number = 'INV-' . date('YmdHis') . '-' . $order_id;
            $created_at = date('Y-m-d H:i:s');
            $this->db->query("INSERT INTO invoices (invoice_number, order_id, status, created_at) 
            VALUES (:invoice_number, :order_id, 'pending', :created_at)");
            $this->db->bind(':invoice_number', $invoice_number);
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':created_at', $created_at);
            $this->db->execute();//Exexute the invoice insert query

            // 4. Clear the cart session
            unset($_SESSION['cart']);

            setMessage('success', 'Order placed successfully! Your order ID is #' . $order_id);
            redirect('CartController/orderConfirmation/' . $order_id);
        } else {
            setMessage('error', 'Failed to place order. Please try again.');
            redirect('CartController/checkout');
        }
    } else {
        setMessage('error', 'Invalid request or empty cart.');
        redirect('CartController/viewCart');
    }
}



public function orderConfirmation($order_id)
{
    // Use the order_details view to get a single consolidated order record
    $this->db->query("SELECT * FROM order_details WHERE order_id = :order_id");
    $this->db->bind(':order_id', $order_id);
    $order_data = $this->db->single(); // Use single() for a single row

    // Use the order_items_view to get all products for this order
    $this->db->query("SELECT * FROM order_items_view WHERE order_id = :order_id");
    $this->db->bind(':order_id', $order_id);
    $order_items = $this->db->resultSet(); // Use resultSet() for multiple rows

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

}