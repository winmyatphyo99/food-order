<?php

class CategoryModel
{
    // These properties are private because they represent the internal state of the object.
    // They should not be accessed or modified directly from outside the class.
    private $id;
    private $name;
    private $description;
    private $category_image;
    private $is_active;
    private $created_at;
    private $updated_at;

    /**
     * Getters and setters are public because they provide a controlled interface
     * for accessing and modifying the private properties from outside the class.
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setCategoryImage($category_image)
    {
        $this->category_image = $category_image;
    }
    public function getCategoryImage()
    {
        return $this->category_image;
    }


    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }
    public function getIsActive()
    {
        return $this->is_active;
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

    // The toArray method is public because it's a utility function needed by other parts of the application.
    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "category_image" => $this->getCategoryImage(),
            "is_active" => $this->getIsActive(),
            "created_at" => $this->getCreatedAt(),
            "updated_at" => $this->getUpdatedAt()
        ];
    }
}