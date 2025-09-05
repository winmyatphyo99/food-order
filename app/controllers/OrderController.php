<?php

class OrderController extends Controller
{
    private $orderModel;
    private $db;
    private const ORDERS_PER_PAGE = 6;
    private $orderRepository;

    public function __construct()
    {
        $this->model('OrderModel');
        $this->db = new Database();
        $this->orderRepository = new OrderRepository();
    }

    
    public function userInvoice($id) {
        // This method works correctly because it receives an order ID
        $order = $this->orderRepository->getOrderWithItems($id);
        $items = $this->orderRepository->getOrderItems($id);
        // echo "<pre>";
        // var_dump($items);exit;

        $invoice = null;
        if ($order && property_exists($order, 'invoice_number')) {
            $invoice = $this->orderRepository->getOrderInvoice($order->invoice_number);
        }

        $this->view('admin/invoice/show', [
            'order' => $order,
            'items' => $items,
            'invoice' => $invoice,
            'role' => 'user'
        ]);
    }

   public function adminInvoice($order_id) {
    // 1. Fetch order by its primary key (order_id)
    $order = $this->orderRepository->getOrderWithItems($order_id);

    if (!$order) {
        // No order found, redirect or show error
        redirect('orders/index'); 
        return;
    }

    // 2. Fetch all items for this order
    $items = $this->orderRepository->getOrderItems($order->order_id);

    // 3. Fetch invoice for this order
    $invoice = $this->orderRepository->getOrderInvoice($order->invoice_number ?? null);

    // 4. Pass data to view
    $this->view('admin/invoice/show', [
        'order'   => $order,
        'items'   => $items,
        'invoice' => $invoice,
        'role'    => 'admin'
    ]);
}


// public function orderHistory() {
//     $user_id = $_SESSION['user_id'];
    
//     // Use the correct method name for your Database class, likely 'resultSet()'
//     $this->db->query("SELECT * FROM `user_order_history_view` WHERE user_id = :user_id ORDER BY order_date DESC");
//     $this->db->bind(':user_id', $user_id);
//     $orders = $this->db->resultSet();     
//     $this->view('user/order/history', ['orders' => $orders]);
// }
public function orderHistory($page = 1)
{
    // Define the number of orders per page
    $ordersPerPage = 5;
    
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Sanitize the page number, ensuring it's an integer and at least 1
    $currentPage = filter_var($page, FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);

    // Calculate the offset for the SQL query
    $offset = ($currentPage - 1) * $ordersPerPage;

    // Get the total number of orders for this user
    $this->db->query("SELECT COUNT(*) AS total_orders FROM `user_order_history_view` WHERE user_id = :user_id");
    $this->db->bind(':user_id', $userId);
    $totalOrders = $this->db->single()->total_orders;

    // Calculate the total number of pages
    $totalPages = ceil($totalOrders / $ordersPerPage);

    // Fetch the specific set of orders for the current page
    $this->db->query("SELECT * FROM `user_order_history_view` WHERE user_id = :user_id ORDER BY order_date DESC LIMIT :limit OFFSET :offset");
    $this->db->bind(':user_id', $userId);
    $this->db->bind(':limit', $ordersPerPage);
    $this->db->bind(':offset', $offset);
    $orders = $this->db->resultSet();

    // Pass the data to the view, including all pagination variables
    $data = [
        'orders' => $orders,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'totalOrders' => $totalOrders,
        'ordersPerPage' => $ordersPerPage
    ];
    
    $this->view('user/order/history', $data);
}


     public function index()
    {
        // Get the current page number from the URL, defaulting to 1
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Calculate the offset for the SQL query
        $offset = ($currentPage - 1) * self::ORDERS_PER_PAGE;
        
        // Fetch the orders for the current page
        $orders = $this->db->readPaginated('orders', self::ORDERS_PER_PAGE, $offset);
        
        // Get the total count of all orders
        $totalOrders = $this->db->countAll('orders');
        
        // Calculate the total number of pages
        $totalPages = ceil($totalOrders / self::ORDERS_PER_PAGE);

        // Prepare the data to pass to the view, including pagination info
        $data = [
            'orders' => $orders,
            'pagination' => [
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'totalOrders' => $totalOrders
            ]
        ];
        
        $this->view('admin/order/index', $data);
    }

    public function create()
    {
        $orders = $this->db->readAll('orders');
        $products = $this->db->readAll('products');
        $users = $this->db->readAll('users');
        $payments = $this->db->readAll('payments');
        $data = [
            'orders' => $orders,
            'products'=> $products,
            'users' => $users,
            'payments'=> $payments
        ];
        $this->view('admin/order/create',$data);
    }

  public function store()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Start a database transaction to ensure data integrity
        $this->db->beginTransaction();

        try {
            // 1. Sanitize and validate user input
            $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
            $payment_method_id = filter_var($_POST['payment_method_id'], FILTER_SANITIZE_NUMBER_INT);
            $delivery_address = filter_var($_POST['delivery_address'], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

            $product_ids = $_POST['product_id'] ?? [];
            $quantities = $_POST['quantity'] ?? [];

            if (empty($product_ids) || empty($quantities)) {
                setMessage('error', 'Please add at least one product to the order.');
                redirect('OrderController/create');
                return;
            }

            $subtotal = 0;
            $order_items_to_save = [];

            // 2. Loop through products to check stock and calculate subtotal
            foreach ($product_ids as $index => $pid) {
                $qty = filter_var($quantities[$index], FILTER_SANITIZE_NUMBER_INT);
                
                $product = $this->db->getById('products', $pid);
                
                if (!$product || $product['quantity'] < $qty) {
                    $this->db->rollBack();
                    setMessage('error', 'Not enough stock for a product in your order.');
                    redirect('OrderController/create');
                    return;
                }
                
                $product_price = $product['price'];
                $subtotal += $product_price * $qty;

                $order_items_to_save[] = [
                    'product_id' => $pid,
                    'quantity' => $qty,
                    'price' => $product_price
                ];
            }

            // 3. Calculate delivery fee, tax, and grand total
            $delivery_fee = 5.00; // Example fixed fee
            $tax_rate = 0.05; // Example 5% tax rate
            $tax_amount = $subtotal * $tax_rate;
            $grand_total = $subtotal + $delivery_fee + $tax_amount;

            // 4. Prepare and save the main order record
            $order_data = [
                'user_id' => $user_id,
               
                'payment_method_id' => $payment_method_id,
                'total_amt' => $subtotal,
                'delivery_fee' => $delivery_fee,
                'tax_amount' => $tax_amount,
                'grand_total' => $grand_total,
                'delivery_address' => $delivery_address,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if (!$this->db->create('orders', $order_data)) {
                $this->db->rollBack();
                setMessage('error', 'Failed to create the main order record.');
                redirect('OrderController/create');
                return;
            }

            $order_id = $this->db->lastInsertId();

            // 5. Save each order item without reducing stock
            foreach ($order_items_to_save as $item) {
                $order_item_data = [
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                if (!$this->db->create('order_items', $order_item_data)) {
                    $this->db->rollBack();
                    setMessage('error', 'Failed to create one or more order items.');
                    redirect('OrderController/create');
                    return;
                }
            }
            
            // 6. Commit the transaction after all operations are successful
            $this->db->commit();
            setMessage('success', 'Order created successfully!');
            redirect('OrderController/index');

        } catch (Exception $e) {
            // Catch any unexpected errors and rollback the transaction
            $this->db->rollBack();
            setMessage('error', 'An unexpected error occurred: ' . $e->getMessage());
            redirect('OrderController/create');
        }
    }
}
    public function edit($id)
    {
        $order = $this->db->getById('orders', $id);
        $payments = $this->db->readAll('payments');

        if (!$order) {
            setMessage('error', 'Order not found.');
            redirect('OrderController/index');
        }

        $data = [
            'order' => $order,
            'payments' => $payments
        ];
        $this->view('admin/order/edit', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            // Sanitize POST data
            $data = [
                'user_id' => trim($_POST['user_id']),
                'payment_method_id' => trim($_POST['payment_method_id']),
                'total_amt' => trim($_POST['total_amt']),
                'delivery_address' => trim($_POST['delivery_address']),
                'status' => trim($_POST['status']),//The key field for the trigger
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update the order// Update the order. The trigger will fire automatically on success.
            if ($this->db->update('orders', $id, $data)) {
                setMessage('success', 'Order updated successfully');
                redirect('OrderController/index');
            } else {
                setMessage('error', 'Failed to update order.');
                redirect('OrderController/index');
            }
        } else {
            redirect('OrderController/index');
        }
    }

    public function destroy($orderId)
{
    // 1. Convert the Base64-encoded ID back to a number.
    $orderId = base64_decode($orderId);
    // 2. Explicitly cast the ID to an integer to satisfy the delete method.
    $numericId = (int)$orderId;

    // 2. Delete the associated invoice record(s) first.
    $this->db->delete('invoices', 'order_id',  $numericId );

    // 3. Now delete the order record from the `orders` table.
    if ($this->db->delete('orders', 'id', $numericId)) {
        setMessage('success', 'Order and associated data deleted successfully!');
    } else {
        setMessage('error', 'Failed to delete the order.');
    }

    redirect('OrderController/index');
}


public function cancel($order_id)
{
    // 1. Sanitize the order ID
    $order_id = filter_var($order_id, FILTER_SANITIZE_NUMBER_INT);

    // 2. Fetch the current order
    $this->db->query("SELECT * FROM orders WHERE id = :id");
    $this->db->bind(':id', $order_id);
    $current_order = $this->db->single();

    // 3. Check if order belongs to the user and is still pending
    if ($current_order && $current_order->user_id == $_SESSION['user_id'] && $current_order->status == 'pending') {
        // Update order status to cancelled
        $data = [
            'status' => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->update('orders', $order_id, $data)) {
            setMessage('success', 'Your order has been cancelled.');
            redirect('OrderController/orderHistory');
        } else {
            setMessage('error', 'Could not cancel the order.');
            redirect('OrderController/orderHistory');
        }
    } else {
        setMessage('error', 'You cannot cancel this order.');
        redirect('OrderController/orderHistory');
    }
}

}