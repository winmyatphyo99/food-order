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

    public function getTodayRevenue() {
    $this->db->query("
        SELECT * FROM `today_revenue`
    ");
    $result = $this->db->single();
    return $result->total_revenue ?? 0;
}
// In a file like app/models/OrderRepository.php

public function countConfirmedOrders() {
    $this->db->query("SELECT COUNT(*) AS total_confirmed FROM orders WHERE status = 'confirmed'");
    $result = $this->db->single();

    return $result->total_confirmed ?? 0;
}

// This method counts the total number of orders in the 'orders' table.
    public function getTotalOrdersCount() {
        $this->db->query('SELECT COUNT(*) AS total FROM orders');
        $row = $this->db->single();
        return $row->total;
    }

 
}

