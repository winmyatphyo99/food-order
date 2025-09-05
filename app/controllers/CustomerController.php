
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

    $cancelledOrders = $this->orderRepository->getCancelledOrderCountByUserId($userId);
    
    $data = [
        'title' => 'My Dashboard',
        'userName' => $_SESSION['user_name'],
        'userRole' => $_SESSION['user_role'],
        'recentOrders' => $recentOrders,
        'totalOrders' => $totalOrders,
        'pendingOrders' => $pendingOrders,
        'lastOrderDate' => $formattedDate ,// Pass the formatted date
        'cancelledOrders' => $cancelledOrders,
    ];

    // Load the view and pass the data.
    $this->view('user/customer/dashboard', $data);
}


public function orderHistory()
{
    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Get the status from the URL query string, defaulting to 'all' if not set
    $status = isset($_GET['status']) ? $_GET['status'] : 'all';

    // Initialize variables
    $orders = [];
    $pageTitle = '';
    $pageHeading = '';

    // Fetch orders based on the status parameter
    if ($status === 'pending') {
        $orders = $this->orderRepository->getOrdersByUserIdAndStatus($userId, 'pending');
        $pageTitle = 'Pending Orders';
        $pageHeading = 'Pending Orders';
    } elseif ($status === 'cancelled') {
        $orders = $this->orderRepository->getOrdersByUserIdAndStatus($userId, 'cancelled');
        $pageTitle = 'Cancelled Orders';
        $pageHeading = 'Cancelled Orders';
    } else {
        // Default case: fetch all orders if status is not specified or is something else
        $orders = $this->orderRepository->getAllOrdersByUserId($userId);
        $pageTitle = 'Order History';
        $pageHeading = 'Order History';
    }

    $data = [
        'title' => $pageTitle,
        'heading' => $pageHeading,
        'orders' => $orders
    ];

    $this->view('user/customer/orderHistory', $data); // Assuming this is your view file
}

   
}

?>