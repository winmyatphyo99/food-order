<?php
require_once 'BaseRepository.php';

class CategoryRepository extends BaseRepository {

    protected function setTable() {
        
    }

    // Get all categories
    public function getAllCategories() {
        $this->db->query("SELECT * FROM categories");
        return $this->db->resultSet();
    }

    // Get a single category by ID
    public function getCategoryById($id) {
        $this->db->query("SELECT * FROM categories WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    
    public function getCategoriesWithProductCount() {
        $this->db->query("
            SELECT c.*, COUNT(p.id) as product_count
            FROM categories c
            LEFT JOIN products p ON c.id = p.category_id
            GROUP BY c.id
        ");
        return $this->db->resultSet();
    }
}
