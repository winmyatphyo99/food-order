<?php

class OrderItemController extends Controller
{
    private $orderItemModel;
    private $db;

    public function __construct()
    {
        $this->model('OrderItemModel');
        $this->db = new Database();
    }

    public function index()
    {
        $orderItems = $this->db->readAll('order_items');
        $data = [
            'orderItems' => $orderItems
        ];
        $this->view('admin/orderItem/orderDetails', $data);
    }
    
    public function show($id)
{
    // 1. Fetch the main order details
    $order = $this->db->find('order_details', 'order_id', $id);

    if (!$order) {
        setMessage('error', 'Order not found.');
        redirect('OrderController/index');
    }

    // 2. Fetch all order items for this order
    $orderItems = $this->db->findAllBy('order_items_view', 'order_id', $id);

    // Debugging
    // var_dump($orderItems); exit;

    // 3. Pass to view
//  $order → single row (main order details).
// $orderItems → multiple rows (all products in that order).
    $data = [
        'order' => $order,
        'order_items' => $orderItems
    ];
    
    $this->view('admin/orderItem/orderDetails', $data);
}

}