<?php

class OrderController extends Controller
{
    private $orderModel;
    private $db;
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
        redirect('orders/index'); // or show an error page
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





public function orderHistory() {
    $user_id = $_SESSION['user_id'];
    
    // Use the correct method name for your Database class, likely 'resultSet()'
    $this->db->query("SELECT * FROM `user_order_history_view` WHERE user_id = :user_id ORDER BY order_date DESC");
    $this->db->bind(':user_id', $user_id);
    
    // Corrected line:
    $orders = $this->db->resultSet(); 
    
    $this->view('user/order/history', ['orders' => $orders]);
}


    public function index()
{
    // Change the query to use the database view
    $orders = $this->db->readAll('orders');
  
    

    $data = [
        'orders' => $orders
         
    ];

    $this->view('admin/order/index', $data);
}
    public function create()
    {
        $orders = $this->db->readAll('orders');
        $products = $this->db->readAll('products');
        $users = $this->db->readAll('users');
        $payments = $this->db->readAll('payments');//['status' => 'active']


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
        $user_id = $_POST['user_id'];
        $payment_method_id = $_POST['payment_method_id'];
        $delivery_address = $_POST['delivery_address'];
        $status = $_POST['status'];

        $product_id = $_POST['product_id'] ?? [];
        $quantity = $_POST['quantity'] ?? [];
        
        // Check if no products were submitted.
        if (empty($product_id) || empty($quantity)) {
            setMessage('error', 'Please add at least one product to the order.');
            redirect('OrderController/create');
            return;
        }

        $total_amt = 0;
        foreach ($product_id as $index => $pid) {
            $product = $this->db->getById('products', $pid);
            $total_amt += $product['price'] * $quantity[$index];
        }

        $data = [
            'user_id' => $user_id,
            'payment_method_id' => $payment_method_id,
            'total_amt' => $total_amt,
            'delivery_address' => $delivery_address,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
       

        
        // Save order first
        if ($this->db->create('orders', $data)) {
            $order_id = $this->db->lastInsertId();
             

            
            // Save each product into order_items
            foreach ($product_id as $index => $pid) {
                $product = $this->db->getById('products', $pid);
                $order_item = [
                    'order_id' => $order_id,
                    'product_id' => $pid,
                    'quantity' => $quantity[$index],
                    'price' => $product['price'],
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->create('order_items', $order_item);
            //     echo "<pre>";
            //  var_dump($order_id);
            //   exit;
            }

            setMessage('success', 'Order created successfully!');
            redirect('OrderController/index');
        } else {
            setMessage('error', 'Failed to create order.');
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
                'status' => trim($_POST['status']),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update the order
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


    


}