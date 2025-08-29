<?php

class CategoryController extends Controller
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->model('CategoryModel');
        $this->db = new Database();
    }

public function index()
    {
        $categories = $this->db->readAll('categories');
        $data = [
            'categories' => $categories
        ];
        $this->view('admin/category/index', $data);

        
        
    }

    

    // Add this new method
public function category($id)
{
    // 1. Get products filtered by category ID
    $products = $this->db->getProductsByCategoryId($id);

    // 2. Prepare the data for the view
    $data = [
        'products' => $products
    ];
    $this->view('user/product/category', $data);
}

    public function create()
    {
        $this->view('admin/category/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            // Handle image upload
            $imageFileName = '';
            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['category_image'];
                $imageFileName = time() . '_' . basename($file['name']);
                $targetDir = APPROOT . '/../public/img/categories/';

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $targetDir . $imageFileName)) {
                    setMessage('error', 'Image upload failed.');
                    redirect('CategoryController/create');
                }
            }

            // Prepare data for insertion
            $data = [
                'name' => $name,
                'description' => $description,
                'is_active' => $is_active,
                'category_image' => $imageFileName // Store the filename in the database
            ];

            // Create the category
            if ($this->db->create('categories', $data)) {
                setMessage('success', 'Category created successfully!');
                redirect('CategoryController/index');
            } else {
                setMessage('error', 'Failed to create category.');
                redirect('CategoryController/index');
            }
        } else {
            redirect('CategoryController/create');
        }
    }

    public function edit($id)
    {
        $category = $this->db->getById('categories', $id);

        if (!$category) {
            setMessage('error', 'Category not found.');
            redirect('CategoryController/index');
        }

        $data = [
            'category' => $category
        ];
        $this->view('admin/category/edit', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            // Get existing category data to handle image updates
            $existingCategory = $this->db->getById('categories', $id);
            if (!$existingCategory) {
                setMessage('error', 'Category not found.');
                redirect('CategoryController/index');
            }

            // Sanitize POST data
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            // Handle image upload
            $imageFileName = $existingCategory['category_image']; // Default to existing image
            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['category_image'];
                $newImageFileName = time() . '_' . basename($file['name']);
                $targetDir = APPROOT . '/../public/img/categories/';

                if (move_uploaded_file($file['tmp_name'], $targetDir . $newImageFileName)) {
                    // Delete old image if a new one is uploaded
                    if ($existingCategory['category_image'] && file_exists($targetDir . $existingCategory['category_image'])) {
                        unlink($targetDir . $existingCategory['category_image']);
                    }
                    $imageFileName = $newImageFileName;
                } else {
                    setMessage('error', 'Image upload failed.');
                    redirect('CategoryController/edit/' . $id);
                }
            }

            // Add the final image filename to the data array
            $data['category_image'] = $imageFileName;

            // Update the category
            if ($this->db->update('categories', $id, $data)) {
                setMessage('success', 'Category updated successfully');
                redirect('CategoryController/index');
            } else {
                setMessage('error', 'Failed to update category.');
                redirect('CategoryController/index');
            }
        } else {
            redirect('CategoryController/index');
        }
    }

  public function destroy($id)
{
    // 1. Decode the Base64-encoded ID and explicitly cast it to an integer.
    $decodedId = base64_decode($id);
    $numericId = (int)$decodedId;

    // 2. Validate the ID and fetch category details
    if (!$numericId) {
        setMessage('error', 'Invalid Category ID.');
        redirect('CategoryController/index');
        return;
    }

    $category = $this->db->getById('categories', $numericId);
    if (!$category) {
        setMessage('error', 'Category not found.');
        redirect('CategoryController/index');
        return;
    }

    // 3. Attempt to delete the record from the database.
    // This assumes your delete method takes a table name, a column name, and the numeric ID.
    if ($this->db->delete('categories', 'id', $numericId)) {

        // 4. If the database deletion is successful, delete the image file from the server.
        if (!empty($category['category_image']) && file_exists(APPROOT . '/../public/img/categories/' . $category['category_image'])) {
            unlink(APPROOT . '/../public/img/categories/' . $category['category_image']);
        }
        
        setMessage('success', 'Category deleted successfully.');
    } else {
        setMessage('error', 'Failed to delete category.');
    }

    redirect('CategoryController/index');
}
}