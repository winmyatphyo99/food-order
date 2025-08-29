<?php

class InvoiceController extends Controller
{
    private $invoiceModel;
    private $db;
    

    public function __construct()
    {
        $this->model('InvoiceModel');
        $this->db = new Database();
        
    }

    // Show all invoices
    public function index()
    {

        if (isAdmin()) {
            
            $this->db->query("SELECT * FROM invoice_summary_view ORDER By invoice_date DESC");
            $invoices = $this->db->resultSet();

            $data = [
                'invoices' => $invoices
            ];
            $this->view('admin/invoice/index', $data);
        } else {
            $invoices = $this->db->readAll('invoices');
            $data = [
                'invoices' => $invoices
            ];
            $this->view('user/invoice/index', $data);
        }
    }


    

//      public function show($invoice_number)
// {
//     
        
//         $this->db->query("SELECT * FROM invoices WHERE invoice_number = :invoice_number");
//         $this->db->bind(':invoice_number', $invoice_number);
//         $invoice = $this->db->single();

//         if (!$invoice) {
//             redirect('admin/invoice/index');
//         }

//         // Get order data
//         $this->db->query("SELECT * FROM order_details WHERE order_id = :order_id");
//         $this->db->bind(':order_id', $invoice->order_id);
//         $order_data = $this->db->single();

//         // Get order items
//         $this->db->query("SELECT * FROM order_items_view WHERE order_id = :order_id");
//         $this->db->bind(':order_id', $invoice->order_id);
//         $order_items = $this->db->resultSet();

//         if ($order_data && $order_items) {
//             $data = [
//                 'invoice' => $invoice,
//                 'order_data' => $order_data,
//                 'order_items' => $order_items
//             ];
//             // echo '<pre>';
//             // var_dump($data);exit;
//             $this->view('admin/invoice/show', $data);
//         } else {
//             redirect('InvoiceController/index');
//         }
//     } else {
       
//         redirect('pages/index'); 
//     }
// }




    

  


}
