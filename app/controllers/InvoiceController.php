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

    public function index($page = 1)
{
    // Define the number of invoices per page
    $invoicesPerPage = 5;

    // Sanitize the page number
    $currentPage = filter_var($page, FILTER_VALIDATE_INT, array('options' => array('default' => 1, 'min_range' => 1)));

    // Calculate the offset
    $offset = ($currentPage - 1) * $invoicesPerPage;

    // Get the total number of invoices
    $this->db->query("SELECT COUNT(*) AS total_invoices FROM invoice_summary_view");
    $totalInvoices = $this->db->single()->total_invoices;

    // Calculate the total number of pages
    $totalPages = ceil($totalInvoices / $invoicesPerPage);

    // Fetch the invoices for the current page
    $this->db->query("SELECT * FROM invoice_summary_view ORDER BY invoice_date DESC LIMIT :limit OFFSET :offset");
    $this->db->bind(':limit', $invoicesPerPage);
    $this->db->bind(':offset', $offset);
    $invoices = $this->db->resultSet();

    // Pass the data to the view
    $data = [
        'invoices' => $invoices,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'totalInvoices' => $totalInvoices,
        'invoicesPerPage' => $invoicesPerPage
    ];

    $this->view('admin/invoice/index', $data);
}

    // Show all invoices
    // public function index()
    // {
    //     if (isAdmin()) {

    //         $this->db->query("SELECT * FROM invoice_summary_view ORDER By invoice_date DESC");
    //         $invoices = $this->db->resultSet();

    //         $data = [
    //             'invoices' => $invoices
    //         ];
    //         $this->view('admin/invoice/index', $data);
    //     } else {
    //         $invoices = $this->db->readAll('invoices');
    //         $data = [
    //             'invoices' => $invoices
    //         ];
    //         $this->view('user/invoice/index', $data);
    //     }


    // }


    public function searchInvoice()
    {
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (!empty($search)) {
            $this->db->query("SELECT * FROM invoice_summary_view
                              WHERE invoice_number LIKE :search
                                 OR customer_name LIKE :search
                                 OR customer_email LIKE :search
                                 OR customer_phone_number LIKE :search
                              ORDER BY invoice_date DESC");
            $this->db->bind(':search', '%' . $search . '%');
        } else {
            $this->db->query("SELECT * FROM  invoice_summary_view ORDER BY invoice_date DESC");
        }

        $invoices = $this->db->resultSet();

        $data = [
            'invoices' => $invoices
        ];

        $this->view('admin/invoice/index', $data);
    }

}
