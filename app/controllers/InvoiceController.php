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


// public function searchInvoice()
// {
//     $search = isset($_GET['q']) ? trim($_GET['q']) : '';

//     if (!empty($search)) {
//         $this->db->query("SELECT * FROM invoice_summary_view
//                           WHERE invoice_number LIKE :search
//                              OR customer_name LIKE :search
//                              OR customer_email LIKE :search
//                              OR customer_phone_number LIKE :search
//                           ORDER BY invoice_date DESC");
//         $this->db->bind(':search', '%' . $search . '%');
//     } else {
//         $this->db->query("SELECT * FROM  invoice_summary_view ORDER BY invoice_date DESC");
//     }

//     $invoices = $this->db->resultSet();

//     $data = [
//         'invoices' => $invoices
//     ];

//     $this->view('admin/invoice/index', $data);
// }

    
    


    




    

  


}
