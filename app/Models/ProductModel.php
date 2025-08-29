<?php

class ProductModel
{
    // Private properties representing the database columns
    private $id;
    private $category_id;
    private $product_name;
    private $description;
    private $price;
    private $quantity;
    private $product_img; // Corresponds to the 'product_img' column
    private $is_available;
    private $is_hot;
    private $date; // Corresponds to the 'date' column
    
    // Getters and Setters for each property

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }
    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function setProductName($product_name)
    {
        $this->product_name = $product_name;
    }
    public function getProductName()
    {
        return $this->product_name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setProductImg($product_img)
    {
        $this->product_img = $product_img;
    }
    public function getProductImg()
    {
        return $this->product_img;
    }

    public function setIsAvailable($is_available)
    {
        $this->is_available = $is_available;
    }
    public function getIsAvailable()
    {
        return $this->is_available;
    }

    public function setIsHot($is_hot)
    {
        $this->is_hot = $is_hot;
    }
    public function getIsHot()
    {
        return $this->is_hot;
    }


    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getDate()
    {
        return $this->date;
    }

    // toArray method to easily convert the object to an associative array
    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "category_id" => $this->getCategoryId(),
            "product_name" => $this->getProductName(),
            "description" => $this->getDescription(),
            "price" => $this->getPrice(),
            "quantity" => $this->getQuantity(),
            "product_img" => $this->getProductImg(),
            "is_available" => $this->getIsAvailable(),
            "is_hot" => $this->getIsHot(),
            "date" => $this->getDate()
        ];
    }
}