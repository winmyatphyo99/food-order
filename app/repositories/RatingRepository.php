<?php

require_once 'BaseRepository.php';

class RatingRepository extends BaseRepository
{
    protected function setTable()
    {
        $this->table = 'ratings';
    }

    // In your RatingRepository.php
    public function addRating($data)
    {
        $this->db->query('INSERT INTO ratings (product_id, user_id, rating, comment, created_at) VALUES (:product_id, :user_id, :rating, :comment, NOW())');
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':comment', $data['comment'] ?? '');
        return $this->db->execute();
    }
    // In your RatingRepository.php
    public function updateRating($data)
    {
        $this->db->query('UPDATE ratings SET rating = :rating, comment = :comment, created_at = NOW() WHERE product_id = :product_id AND user_id = :user_id');
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':comment', $data['comment'] ?? '');
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':user_id', $data['user_id']);
        return $this->db->execute();
    }


    public function getAverageRating($productId)
    {
        $this->db->query('SELECT COALESCE(AVG(rating), 0) as avg_rating FROM ratings WHERE product_id = :product_id');
        $this->db->bind(':product_id', $productId);
        $result = $this->db->single();
        return isset($result->avg_rating) ? (float)$result->avg_rating : 0.0;
    }

    public function getRatingCount($productId)
    {
        $this->db->query('SELECT COUNT(*) as count FROM ratings WHERE product_id = :product_id');
        $this->db->bind(':product_id', $productId);
        $result = $this->db->single();
        return $result->count;
    }


    public function hasUserRatedProduct($userId, $productId)
    {
        $this->db->query('SELECT COUNT(*) as cnt FROM ratings WHERE user_id = :user_id AND product_id = :product_id');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);
        $result = $this->db->single();
        $count = isset($result->cnt) ? (int)$result->cnt : 0;
        return $count > 0;
    }

    public function getTestimonials()
    {
        $this->db->query("
        SELECT *
        FROM user_ratings_view
        LIMIT 6
    ");

        return $this->db->resultSet();
    }
}
