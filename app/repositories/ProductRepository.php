<?php

require_once 'BaseRepository.php';

class ProductRepository extends BaseRepository {
    protected function setTable() {
        // This repository handles multiple tables, so we'll handle the queries directly.
    }

    public function getCategories() {
        $this->db->query("SELECT * FROM categories");
        return $this->db->resultSet();
    }

//    public function getProductsWithPagination($categoryId = null, $itemsPerPage = 8, $offset = 0, $searchQuery = null){  
//     // Base query for products with ratings
//     $baseQuery = "SELECT p.*, 
//                          IFNULL(AVG(r.rating), 0) AS average_rating, 
//                          COUNT(r.id) AS rating_count 
//                   FROM products p 
//                   LEFT JOIN ratings r ON p.id = r.product_id";

//     $countQuery = "SELECT COUNT(*) AS total FROM products";
//     $bindings = [];
    

//     // Filter by category if provided
//     if ($categoryId) {
//         $baseQuery .= " WHERE p.category_id = :category_id";
//         $countQuery .= " WHERE category_id = :category_id";
//         $bindings[':category_id'] = $categoryId;
//     }

//     // Group by product for aggregation
//     $baseQuery .= " GROUP BY p.id";

//     // Execute count query
//     $this->db->query($countQuery);
//     foreach ($bindings as $key => $value) {
//         $this->db->bind($key, $value);
//     }
//     $totalResult = $this->db->single();
//     $totalProducts = isset($totalResult->total) ? (int)$totalResult->total : 0;

//     // Execute product query with pagination
//     $baseQuery .= " LIMIT :limit OFFSET :offset";
//     $this->db->query($baseQuery);
//     foreach ($bindings as $key => $value) {
//         $this->db->bind($key, $value);
//     }
//     $this->db->bind(':limit', $itemsPerPage, PDO::PARAM_INT);
//     $this->db->bind(':offset', $offset, PDO::PARAM_INT);
//     $products = $this->db->resultSet();

//     return [
//         'products' => $products,
//         'total_products' => $totalProducts
//     ];
// }
// In ProductRepository.php

// In ProductRepository.php

// In ProductRepository.php

public function getProductsWithPagination($categoryId = null, $itemsPerPage = 8, $offset = 0, $searchQuery = null, $sortOrder = 'newest') {
    $conditions = [];
    $bindings = [];

    // Filter by category
    if ($categoryId) {
        $conditions[] = "p.category_id = :category_id";
        $bindings[':category_id'] = $categoryId;
    }

    // Search by product name or description
   if ($searchQuery) {
    $conditions[] = "(p.product_name LIKE :search_name OR p.description LIKE :search_desc)";
    $bindings[':search_name'] = "%" . $searchQuery . "%";
    $bindings[':search_desc'] = "%" . $searchQuery . "%";
}


    // Build WHERE clause
    $whereClause = !empty($conditions) ? " WHERE " . implode(' AND ', $conditions) : '';

    // 1 COUNT query to get total products
    $countQuery = "SELECT COUNT(*) AS total FROM products p" . $whereClause;
    $this->db->query($countQuery);
    foreach ($bindings as $key => $value) {
        $this->db->bind($key, $value);
    }
    $totalResult = $this->db->single();
    $totalProducts = isset($totalResult->total) ? (int)$totalResult->total : 0;

    // 2 Main products query
    $baseQuery = "SELECT p.*,
                         IFNULL(AVG(r.rating), 0) AS average_rating,
                         COUNT(r.id) AS rating_count
                  FROM products p
                  LEFT JOIN ratings r ON p.id = r.product_id";

    $baseQuery .= $whereClause;
    $baseQuery .= " GROUP BY p.id";

    // Sorting
    switch ($sortOrder) {
        case 'price_low_high':
            $baseQuery .= " ORDER BY p.price ASC";
            break;
        case 'price_high_low':
            $baseQuery .= " ORDER BY p.price DESC";
            break;
        case 'name_az':
            $baseQuery .= " ORDER BY p.product_name ASC";
            break;
        case 'name_za':
            $baseQuery .= " ORDER BY p.product_name DESC";
            break;
        case 'newest':
        default:
            $baseQuery .= " ORDER BY p.created_at DESC";
            break;
    }

    // Add LIMIT and OFFSET directly (no named params)
    $baseQuery .= " LIMIT " . (int)$itemsPerPage . " OFFSET " . (int)$offset;

    $this->db->query($baseQuery);

    // Bind only category and search parameters
    foreach ($bindings as $key => $value) {
        $this->db->bind($key, $value);
    }

    $products = $this->db->resultSet();

    return [
        'products' => $products,
        'total_products' => $totalProducts
    ];
}



}