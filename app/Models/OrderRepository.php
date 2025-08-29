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

   
}

