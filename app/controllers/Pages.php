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
        $this->view('pages/home');
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
   
    // Query the V_best_selling_products view to get the top 6 items
    $this->db->query("SELECT * FROM V_best_selling_products LIMIT 6");
    $hotProducts = $this->db->resultSet();

    $data = [
        'hotProducts' => $hotProducts
    ];
    $this->view('pages/home', $data);
}

  
    public function menu($category_id = null)
{
   
    // Fetch all categories to display the category links
    $categories = $this->db->readAll('categories');

     // Fetch products based on the category_id.
    if ($category_id) {
        $this->db->query("SELECT * FROM products WHERE category_id = :category_id");
        $this->db->bind(':category_id', $category_id);
        $products = $this->db->resultSet();
    } else {
        // If no category is selected, show all products
        $products = $this->db->readAll('products');
    }


    // 2. Prepare the data for the view
    
    $data = [
        'categories' => $categories,
        'products' => $products,
        'selected_category_id' => $category_id
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
