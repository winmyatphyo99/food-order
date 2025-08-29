<?php

class ProductController extends Controller
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->model('ProductModel');
        $this->db = new Database();
    }


    public function index(){
        
        $products = $this->db->readAll('products');
        $data = ['products' => $products];
        $this->view('admin/product/index', $data);
    }

    public function category($id){
        $products = $this->db->getProductsByCategoryId($id);

        $data = [
            'products' => $products
        ];
        $this->view('user/product/category',$data);

    }

    


    public function create()
    {
        // Get categories to populate a dropdown in the create form
        $categories = $this->db->readAll('categories');
        $data = [
            'categories' => $categories
        ];
        $this->view('admin/product/create', $data);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $category_id = trim($_POST['category_id']);
            $product_name = trim($_POST['product_name']);
            $description = trim($_POST['description']);
            $price = trim($_POST['price']);
            $quantity = trim($_POST['quantity']);
            $is_available = isset($_POST['is_available']) ? 1 : 0;
            $is_hot = isset($_POST['is_hot']) ? 1 : 0;
            
            // Handle image upload
            $imageFileName = '';
            if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['product_img'];
                $imageFileName = time() . '_' . basename($file['name']);
                $targetDir = APPROOT . '/../public/img/products/';

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $targetDir . $imageFileName)) {
                    setMessage('error', 'Image upload failed.');
                    redirect('ProductController/create');
                }
            }

            // Prepare data for insertion
            $data = [
                'category_id' => $category_id,
                'product_name' => $product_name,
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
                'product_img' => $imageFileName, // Store the filename
                'is_available' => $is_available,
                'is_hot' => $is_hot,
                'date' => date('Y-m-d H:i:s') // Set the current date/time
            ];

            // Create the product
            if ($this->db->create('products', $data)) {
                setMessage('success', 'Product created successfully!');
                redirect('ProductController/index');
            } else {
                setMessage('error', 'Failed to create product.');
                redirect('ProductController/index');
            }
        } else {
            redirect('ProductController/create');
        }
    }

    public function edit($id)
    {
        $product = $this->db->getById('products', $id);
        $categories = $this->db->readAll('categories');

        if (!$product) {
            setMessage('error', 'Product not found.');
            redirect('ProductController/index');
        }

        $data = [
            'product' => $product,
            'categories' => $categories
        ];
        $this->view('admin/product/edit', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            // Get existing product data to handle image updates
            $existingProduct = $this->db->getById('products', $id);
            if (!$existingProduct) {
                setMessage('error', 'Product not found.');
                redirect('ProductController/index');
            }

            // Sanitize POST data
            $data = [
                'category_id' => trim($_POST['category_id']),
                'product_name' => trim($_POST['product_name']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity']),
                'is_available' => isset($_POST['is_available']) ? 1 : 0,
                'is_hot' => isset($_POST['is_hot']) ? 1 : 0
            ];

            // Handle image upload
            $imageFileName = $existingProduct['product_img']; // Default to existing image
            if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['product_img'];
                $newImageFileName = time() . '_' . basename($file['name']);
                $targetDir = APPROOT . '/../public/img/products/';

                if (move_uploaded_file($file['tmp_name'], $targetDir . $newImageFileName)) {
                    // Delete old image if a new one is uploaded
                    if ($existingProduct['product_img'] && file_exists($targetDir . $existingProduct['product_img'])) {
                        unlink($targetDir . $existingProduct['product_img']);
                    }
                    $imageFileName = $newImageFileName;
                } else {
                    setMessage('error', 'Image upload failed.');
                    redirect('ProductController/edit/' . $id);
                }
            }

            // Add the final image filename and update timestamp to the data array
            $data['product_img'] = $imageFileName;
            $data['date'] = date('Y-m-d H:i:s'); // Update the date column

            // Update the product
            if ($this->db->update('products', $id, $data)) {
                setMessage('success', 'Product updated successfully');
                redirect('ProductController/index');
            } else {
                setMessage('error', 'Failed to update product.');
                redirect('ProductController/index');
            }
        } else {
            redirect('ProductController/index');
        }
    }

    public function destroy($id)
{
    // 1. Decode the Base64-encoded ID and cast to an integer
    $decodedId = base64_decode($id);
    $numericId = (int)$decodedId;

    // 2. Validate the ID and fetch product details
    if (!$numericId) {
        setMessage('error', 'Invalid Product ID.');
        redirect('ProductController/index');
        return;
    }

    $product = $this->db->getById('products', $numericId);
    if (!$product) {
        setMessage('error', 'Product not found.');
        redirect('ProductController/index');
        return;
    }

    // 3. Delete the image file from the server
    if (!empty($product['product_img']) && file_exists(APPROOT . '/../public/img/products/' . $product['product_img'])) {
        unlink(APPROOT . '/../public/img/products/' . $product['product_img']);
    }

    // 4. Delete the record from the database
    // This assumes your delete method takes a table name, a column name, and the value to match.
    if ($this->db->delete('products', 'id', $numericId)) {
        setMessage('success', 'Product deleted successfully.');
    } else {
        setMessage('error', 'Failed to delete product.');
    }

    redirect('ProductController/index');
}
}