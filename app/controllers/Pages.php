<?php
require_once APPROOT . '/repositories/BaseRepository.php';
require_once APPROOT . '/repositories/ProductRepository.php';
require_once APPROOT . '/repositories/RatingRepository.php';
class Pages extends Controller
{
    private $productRepository;
    private $ratingRepository;
    private $db;
    public function __construct()
    {
        $this->db = new Database();
        $this->productRepository = new ProductRepository($this->db);
        $this->ratingRepository = new RatingRepository($this->db);
        $this->model('UserModel');
       
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
    


public function home($id = null)
{
    // Products filtered by the selected category
    $products = $this->db->getProductsByCategoryId($id);

    // All categories for the top section
    $categories = $this->db->readAll('categories');

    //  Fetch best selling products again
    $this->db->query("SELECT * FROM V_best_selling_products LIMIT 6");
    $hotProducts = $this->db->resultSet();

    //  Fetch testimonials if they’re also used in the home view
    $testimonials = $this->ratingRepository->getTestimonials();

    $data = [
        'products'     => $products,
        'categories'   => $categories,
        'hotProducts'  => $hotProducts,   
        'testimonials' => $testimonials, 
        'selectedId'   => $id
    ];

    $this->view('pages/home', $data);
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



public function menu($categoryId = null) {
    // Get current page from URL or default to 1
    $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    
    // Get search query from URL or default to empty
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
    
    // Get sort order from URL or default to 'newest'
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
    
    $itemsPerPage = 8;
    $offset = ($currentPage - 1) * $itemsPerPage;

    // Use the updated repository method
    $productsData = $this->productRepository->getProductsWithPagination(
        $categoryId, 
        $itemsPerPage, 
        $offset, 
        $searchQuery,
        $sortOrder
    );

    $totalProducts = $productsData['total_products'];
    $products = $productsData['products'];
    $totalPages = ceil($totalProducts / $itemsPerPage);

    $data = [
        'products' => $products,
        'categories' => $this->productRepository->getCategories(),
        'selected_category_id' => $categoryId,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'searchQuery' => $searchQuery, // Pass search query to the view for the input value
        'sortOrder' => $sortOrder // Pass sort order to the view for the button text
    ];

    $this->view('user/product/category', $data);
}

}
