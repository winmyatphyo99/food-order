<?php
class AdminController extends Controller{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }


    public function dashboard()
    { 
        // Get the total number of orders
        $totalOrders = $this->db->countAll('orders');
        // Fetch recent invoices from the 'invoice_summary' view
        $recentInvoices = $this->db->getRecent('invoice_summary_view', 5, 'invoice_date');
        // Create a data array to pass to the view
        $data = [
            'toalOrders' => $totalOrders,
            'recentInvoices'=> $recentInvoices
        ];


    // Load the dashboard view with the data
        $this->view('admin/dashboard',$data);
    }

   public function confirmOrder($orderId = null)
{
    // 1. Validate the input to ensure a valid order ID is provided.
    if (empty($orderId) || !is_numeric($orderId)) {
        setMessage('error', 'Invalid order ID.');
        redirect('admin/pending');
        return;
    }

    // 2. Begin a database transaction to ensure atomicity.
    $this->db->beginTransaction();

    try {
        // 3. Update the status in the 'orders' table using the existing update method.
        $this->db->update('orders', $orderId, ['status' => 'confirmed']);

        // 4. Update the 'order_status' in the 'invoices' table with a custom query.
        $sql = "UPDATE invoices SET status = :status WHERE order_id = :order_id";
        $this->db->query($sql);
        $this->db->bind(':status', 'confirmed');
        $this->db->bind(':order_id', $orderId);
        $this->db->execute();

        // 5. Commit the transaction if both updates are successful.
        $this->db->commit();

        setMessage('success', 'Order confirmed and invoice updated successfully!');
        redirect('admin/pending');
    } catch (Exception $e) {
        // 6. Rollback the transaction on failure.
        $this->db->rollBack();

        setMessage('error', 'Failed to confirm order. Please try again.');
        redirect('admin/pending');
    }
}

public function index() {
    $this->db->query("SELECT * FROM orders WHERE status = 'pending' ORDER BY created_at DESC");
    $this->db->execute(); 
    $pending_orders = $this->db->findAll(); 
    $this->view('admin/order/pending', ['orders' => $pending_orders]);
}

public function completed() {
    $this->db->query("SELECT * FROM orders WHERE status = 'confirmed' ORDER BY created_at DESC");
    $this->db->execute();
    $completed_orders = $this->db->findAll();
    $this->view('admin/order/completed', ['orders' => $completed_orders]);
}



} 


?>