<?php
require_once 'BaseRepository.php';

class CartRepository extends BaseRepository
{

    protected function setTable()
    {
        $this->table = 'carts';
    }


    // public function getUserCart($userId) {
    //     $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :user_id");
    //     $this->db->bind(':user_id', $userId);
    //     return $this->db->resultSet();
    // }

    public function getUserCart($userId)
    {
        // Select cart quantity and also product details (name and price)
        $this->db->query('SELECT 
                        c.product_id, 
                        c.quantity, 
                        p.product_name, 
                        p.price 
                      FROM carts AS c
                      JOIN products AS p
                      ON c.product_id = p.id
                      WHERE c.user_id = :user_id');

        $this->db->bind(':user_id', $userId);

        // Return the result set as an array of objects/arrays
        return $this->db->resultSet();
    }

    // Cart Item update
    public function updateCartItem($userId, $productId, $quantity)
    {
        $this->db->query("UPDATE {$this->table} 
                          SET quantity = :quantity 
                          WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);
        return $this->db->execute();
    }


    public function addCartItem($userId, $productId, $quantity, $price)
    {
        $this->db->query("INSERT INTO {$this->table} (user_id, product_id, quantity, price) 
                          VALUES (:user_id, :product_id, :quantity, :price)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':price', $price);
        return $this->db->execute();
    }
    /**
     * Get session key for cart based on login status
     */
    public function getCartSessionKey(): string
    {
        return isLoggedIn() ? 'cart' : 'guest_cart';
    }



    public function getProductStock(int $productId): ?int
    {
        $this->db->query("SELECT quantity FROM products WHERE id = :id");
        $this->db->bind(':id', $productId);
        $product = $this->db->single();
        return $product->quantity ?? null;
    }




    public function removeCartItem($userId, $productId)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);
        return $this->db->execute();
    }

     public function getCartItemsByUserId(int $userId): array
    {
        $this->db->query('SELECT
                            c.product_id,
                            c.quantity,
                            p.product_name,
                            p.price,
                            p.product_img
                          FROM carts c
                          INNER JOIN products p ON c.product_id = p.id
                          WHERE c.user_id = :user_id');

        $this->db->bind(':user_id', $userId);

        $results = $this->db->resultSet();

        return $results ?? [];
    }
    
    

    public function clearCart($userId)
{
    $this->db->query("DELETE FROM {$this->table} WHERE user_id = :user_id");
    $this->db->bind(':user_id', $userId);
    return $this->db->execute();
}

 public function addToCart($userId, $productId, $quantity)
    {
        // Check if the item already exists in the user's cart
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);
        $existingItem = $this->db->single();

        if ($existingItem) {
            // Item exists, update its quantity
            $this->db->query("UPDATE {$this->table} SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':product_id', $productId);
            return $this->db->execute();
        } else {
            // New item, insert it into the database
            $this->db->query("INSERT INTO {$this->table} (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':product_id', $productId);
            $this->db->bind(':quantity', $quantity);
            return $this->db->execute();
        }
    }
      public function getCartItem(int $userId, int $productId)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);
        return $this->db->single();
    }



}
