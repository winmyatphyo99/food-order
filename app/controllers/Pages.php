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

  
//     public function menu($category_id = null)
// {
   
//     // Fetch all categories to display the category links
//     $categories = $this->db->readAll('categories');

//      // Fetch products based on the category_id.
//     if ($category_id) {
//         $this->db->query("SELECT * FROM products WHERE category_id = :category_id");
//         $this->db->bind(':category_id', $category_id);
//         $products = $this->db->resultSet();
//     } else {
//         // If no category is selected, show all products
//         $products = $this->db->readAll('products');
//     }


//     // 2. Prepare the data for the view
    
//     $data = [
//         'categories' => $categories,
//         'products' => $products,
//         'selected_category_id' => $category_id
//     ];
//     $this->view('user/product/category', $data);
// }
public function menu($category_id = null)
{
    // Pagination setup
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = 9; // Number of products to show per page
    $offset = ($page - 1) * $itemsPerPage;

    // Fetch all categories to display the category links
    $categories = $this->db->readAll('categories');

    // Build the base query and count query
    $baseQuery = "SELECT * FROM products";
    $countQuery = "SELECT COUNT(*) FROM products";
    $conditions = [];
    $bindings = [];

    // Add category filter if a category is selected
    if ($category_id) {
        $conditions[] = "category_id = :category_id";
        $bindings[':category_id'] = $category_id;
    }

    // Combine conditions into the WHERE clause
    if (!empty($conditions)) {
        $whereClause = " WHERE " . implode(" AND ", $conditions);
        $baseQuery .= $whereClause;
        $countQuery .= $whereClause;
    }

    // Execute the count query to get the total number of products
    $this->db->query($countQuery);
    foreach ($bindings as $key => $value) {
        $this->db->bind($key, $value);
    }
    $totalProducts = (int)$this->db->single()->{'COUNT(*)'};
    $totalPages = ceil($totalProducts / $itemsPerPage);

    // Fetch the products for the current page
    $baseQuery .= " LIMIT :limit OFFSET :offset";
    $this->db->query($baseQuery);
    foreach ($bindings as $key => $value) {
        $this->db->bind($key, $value);
    }
    $this->db->bind(':limit', $itemsPerPage);
    $this->db->bind(':offset', $offset);
    $products = $this->db->resultSet();

    // Prepare the data for the view
    $data = [
        'categories' => $categories,
        'products' => $products,
        'selected_category_id' => $category_id,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'totalProducts' => $totalProducts
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
