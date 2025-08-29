<?php

class OrderItemModel
{
    // Private properties representing the database columns
    private $id;
    private $order_id;
    private $product_id;
    private $quantity;
    private $price;
    private $created_at;
    private $updated_at;

    // Getters and Setters for each property

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }
    public function getOrderId()
    {
        return $this->order_id;
    }

    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }
    public function getProductId()
    {
        return $this->product_id;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    // toArray method to easily convert the object to an associative array
    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "order_id" => $this->getOrderId(),
            "product_id" => $this->getProductId(),
            "quantity" => $this->getQuantity(),
            "price" => $this->getPrice(),
            "created_at" => $this->getCreatedAt(),
            "updated_at" => $this->getUpdatedAt()
        ];
    }
}