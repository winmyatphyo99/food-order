<?php

class Pages extends Controller
{
    

    private $db;
    public function __construct()
    {
        $this->db = new Database();
       
    }

    public function index()
    {
        $this->view('pages/login');
    }

    public function login()
    {
        $this->view('pages/login');
    }

    public function register()
    {
        $this->view('pages/register');
    }

    

    public function about()
    {
        $this->view('pages/about');
    }

    public function home()
    {
        $hotProducts = $this->db->query("SELECT * FROM products WHERE is_hot = 1");
        $hotProducts = $this->db->resultSet();
        $data = [
            'hotProducts' => $hotProducts
        ];
        $this->view('pages/home', $data);
       
    }

    public function menu()
{
    // 1. Get products filtered by category ID
    $products = $this->db->readAll('products');
    $categories = $this->db->readAll('categories');

    

    // 2. Prepare the data for the view
    $data = [
        'title' => 'Our Menu',
        'products' => $products,
        'categories' => $categories
    ];
    $this->view('user/product/category', $data);
}


    public function menuCategory()
    {
        $categories = $this->db->readAll('categories');
         // 2. Prepare the data for the view
    $data = [
        'categories' => $categories
    ];
        $this->view('user/category/index', $data);
    }

}
