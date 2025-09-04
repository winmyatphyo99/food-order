<?php
class AdminController extends Controller
{
    private $db;
    private $userRepository;
    public function __construct()
    {
        $this->db = new Database();
         $this->userRepository = new UserRepository();
    }
   
     public function profile() {
        $user = $this->userRepository->getUserById($_SESSION['user_id']);
        $this->view('admin/adminprofile/profile', ['user' => $user]);
    }

      public function editProfile()
    {

        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->getUserById($userId);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone_number' => trim($_POST['phone_number'])

            ];
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
                $filename = time() . '_' . basename($_FILES['profile_image']['name']);
                $target =  APPROOT . '/../public/uploads/profile/' . $filename;
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
                    $data['profile_image'] = $filename;
                    //  var_dump($data['profile_image'] );exit;
                    // Update session with new image name
                    $_SESSION['profile_image'] = $filename;
                }
            }
            $this->userRepository->updateUserProfile($userId, $data);
            setMessage('success', 'Profile updated successfully!');
            redirect('Admin/dashboard');
        }
        // send full user row to view
        $this->view('admin/adminprofile/editProfile', ['user' => $user]);
    }
    public function delete($id)
    {
        $this->userRepository->delete($id);
        setMessage('success', 'User deleted successfully.');
        redirect('AdminController/profile');
    }

    public function changePassword()
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->getUserById($userId);
        //  var_dump($user);exit;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $current = trim($_POST['current_password']);
            $new = trim($_POST['new_password']);
            $confirm = trim($_POST['confirm_password']);
            if (!password_verify($current, $user->password)) {
                setMessage('error', 'Current password is incorrect!');
                redirect('admin/profile');
            } elseif ($new !== $confirm) {
                setMessage('error', 'New password and confirm password do not match!');
                redirect('admin/changePassword');
            } else {
                $this->userRepository->updatePassword($userId, $new);
                setMessage('success', 'Password updated successfully!');
                redirect('AdminController/profile');
            }
        }

        $this->view('admin/adminprofile/changePassword');
    }


    public function dashboard()
    {
        $orderRepository = new OrderRepository();
        $totalOrders = $this->db->countAll('orders');
        $recentInvoices = $this->db->getRecent('invoice_summary_view', 5, 'invoice_date');
        $this->db->query("SELECT COUNT(*) AS total_pending FROM orders WHERE status = 'pending'");
        $total_pending = $this->db->single();
        $total_pending_orders = $total_pending->total_pending;
        // Create a data array to pass to the view
        $data = [
            'toalOrders' => $totalOrders,
            'recentInvoices' => $recentInvoices,
            'revenueToday' => $orderRepository->getTodayRevenue(),
            'pending_orders' => $total_pending_orders,
            'completedOrdersCount' => $orderRepository->countConfirmedOrders(), 
            'totalOrdersCount' => $orderRepository->getTotalOrdersCount(), 
            
        ];


        // Load the dashboard view with the data
        $this->view('admin/dashboard', $data);
    }

    public function confirmOrder($orderId = null)
    {
        // 1. Validate the input
        if (empty($orderId) || !is_numeric($orderId)) {
            setMessage('error', 'Invalid order ID.');
            redirect('admin/pending');
            return;
        }
        try {
            // 2. Fetch the pending order details before calling the stored procedure.
            $order = $this->db->getById('orders', $orderId);
            if (!$order) {
                setMessage('error', 'Failed to retrieve order details.');
                redirect('admin/pending');
                return;
            }
            $invoice_number = 'INV-' . date('Ymd') . '-' . mt_rand(1000, 9999) . '-' . $orderId;
            // 4. Call the stored procedure to confirm the order and reduce stock.
            $procedure_params = [
                'p_order_id' => $orderId
            ];
            $this->db->executeStoredProcedure('ConfirmOrderAndReduceQuantity', $procedure_params);

            // 5. Create the invoice record in the 'invoices' table.
            $invoice_data = [
                'invoice_number' => $invoice_number,
                'order_id' => $orderId,
                'user_id' => $order['user_id'],
                'total_amt' => $order['total_amt'],
                'delivery_fee' => $order['delivery_fee'],
                'tax_amount' => $order['tax_amount'],
                'grand_total' => $order['grand_total'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->db->create('invoices', $invoice_data)) {
                setMessage('error', 'Order confirmed but failed to create the invoice record.');
                redirect('admin/pending');
                return;
            }

            setMessage('success', 'Order confirmed and invoice created successfully!');
            redirect('admin/pending');
        } catch (Exception $e) {
            setMessage('error', 'Failed to confirm order. Error: ' . $e->getMessage());
            redirect('admin/pending');
        }
    }

    public function home()
    {
        $this->db->query("SELECT * FROM orders WHERE status = 'pending' ORDER BY created_at DESC");
        $this->db->execute();
        $pending_orders = $this->db->findAll();
        $this->view('admin/order/pending', ['orders' => $pending_orders]);
    }

    public function completed()
    {
        $this->db->query("SELECT * FROM orders WHERE status = 'confirmed' ORDER BY created_at DESC");
        $this->db->execute();
        $completed_orders = $this->db->findAll();
        $this->view('admin/order/completed', ['orders' => $completed_orders]);
    }
}
