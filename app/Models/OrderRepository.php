<?php

class OrderRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get single order by ID (using order_id)
    public function getOrderWithItems($order_id)
    {
        $sql = "SELECT * FROM order_details WHERE order_id = :order_id";
        $this->db->query($sql);
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    // Get all items for the order
    public function getOrderItems($orderId)
    {
        $sql = "SELECT * FROM order_items_view WHERE order_id = :order_id";
        $this->db->query($sql);
        $this->db->bind(':order_id', $orderId);
        return $this->db->resultSet();
    }

    // Get invoice by order_id
    public function getOrderInvoice($orderId)
    {
        $sql = "SELECT * FROM invoices WHERE order_id = :order_id";
        $this->db->query($sql);
        $this->db->bind(':order_id', $orderId);
        return $this->db->single();
    }

    public function getTodayRevenue()
    {
        $this->db->query("
        SELECT * FROM `today_revenue`
    ");
        $result = $this->db->single();
        return $result->total_revenue ?? 0;
    }
    // In a file like app/models/OrderRepository.php

    public function countConfirmedOrders()
    {
        $this->db->query("SELECT COUNT(*) AS total_confirmed FROM orders WHERE status = 'confirmed'");
        $result = $this->db->single();

        return $result->total_confirmed ?? 0;
    }

    // This method counts the total number of orders in the 'orders' table.
    public function getTotalOrdersCount()
    {
        $this->db->query('SELECT COUNT(*) AS total FROM orders');
        $row = $this->db->single();
        return $row->total;
    }



    public function getRecentOrdersByUserId($userId, $limit = 6)
    {
        $this->db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':limit', $limit);

        // This method will fetch and return a set of results
        return $this->db->resultSet();
    }

    public function getTotalOrdersByUserId($userId)
    {
        $this->db->query('SELECT COUNT(*) as total_orders FROM orders WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);

        $row = $this->db->single();

        return $row->total_orders;
    }
    public function getPendingOrdersCountByUserId($userId)
    {
        $this->db->query('SELECT COUNT(*) as pending_orders_count FROM orders WHERE user_id = :user_id AND status = "Pending"');
        $this->db->bind(':user_id', $userId);

        $row = $this->db->single();

        return $row->pending_orders_count;
    }

    public function getOrdersByUserIdAndStatus($userId, $status)
    {
        $this->db->query('SELECT * FROM orders WHERE user_id = :user_id AND status = :status ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':status', $status);

        $results = $this->db->resultSet();

        return $results;
    }

    public function getLastOrderDateByUserId($userId)
    {
        $this->db->query('SELECT created_at FROM orders WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1');
        $this->db->bind(':user_id', $userId);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row->created_at;
        } else {
            return null;
        }
    }

    public function getCancelledOrderCountByUserId($userId)
    {
        $this->db->query("select count(*) as total_cancelled from orders where user_id =:user_id and status = 'cancelled'");
        $this->db->bind(':user_id', $userId);
        return $this->db->single()->total_cancelled;
    }

    public function getAllOrdersByUserId($userId)
    {
        $this->db->query("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->db->bind(':user_id', $userId);
        return $this->db->findAll();
    }

    public function getRecentOrdersWithImages($userId)
    {
        $sql = "SELECT * FROM recent_orders_with_images WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 5";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        $this->db->execute();
        return $this->db->findAll();
    }

    public function getSalesDataLast7Days()
    {
        // Query the invoice_summary_view to get total sales per day for the last 7 days
        $this->db->query("
        SELECT 
            DATE(invoice_date) AS date, 
            SUM(grand_total) AS total_sales
        FROM invoice_summary_view
        WHERE invoice_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(invoice_date)
        ORDER BY DATE(invoice_date) ASC
    ");

        // Return the result set
        return $this->db->resultSet();
    }
}
