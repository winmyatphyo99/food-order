
<?php

class CustomerController extends Controller
{
    
    protected $orderRepository;
      
    private $db;
    public function __construct()
    {
        $this->model('UserModel');
        $this->db = new Database();
        // Instantiate the OrderRepository and inject the database dependency
        $this->orderRepository = new OrderRepository();
        
    }

public function dashboard()
{
    // Get the user ID from the session.
    $userId = $_SESSION['user_id'];

    // Retrieve recent orders, total orders, and pending orders...
    $recentOrders = $this->orderRepository->getRecentOrdersByUserId($userId);
    $totalOrders = $this->orderRepository->getTotalOrdersByUserId($userId);
    $pendingOrders = $this->orderRepository->getPendingOrdersCountByUserId($userId);
    
    // Retrieve the last order date
    $lastOrderDate = $this->orderRepository->getLastOrderDateByUserId($userId);
    
    // Format the date for display
    $formattedDate = $lastOrderDate ? date('M d, Y', strtotime($lastOrderDate)) : 'N/A';
    
    $data = [
        'title' => 'My Dashboard',
        'userName' => $_SESSION['user_name'],
        'userRole' => $_SESSION['user_role'],
        'recentOrders' => $recentOrders,
        'totalOrders' => $totalOrders,
        'pendingOrders' => $pendingOrders,
        'lastOrderDate' => $formattedDate // Pass the formatted date
    ];

    // Load the view and pass the data.
    $this->view('user/customer/dashboard', $data);
}


public function orderHistory()
{
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];
    
    // Check if a status filter is set in the URL
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : null;

    if ($statusFilter) {
        // Call a new repository method to get orders filtered by status
        $orders = $this->orderRepository->getOrdersByUserIdAndStatus($userId, $statusFilter);
    } else {
        // Get all orders for the user if no filter is set
        $orders = $this->orderRepository->getPendingOrdersCountByUserId($userId);
    }

    $data = [
        'title' => 'Order History',
        'orders' => $orders
    ];

    $this->view('user/customer/orderHistory', $data);
}
   
}

?>