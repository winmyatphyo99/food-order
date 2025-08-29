<?php

class OrderModel
{
    // Private properties representing the database columns
    private $id;
    private $user_id;
    private $payment_method_id;
    private $total_amt;
    private $delivery_address;
    private $status;
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

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getUserId()
    {
        return $this->user_id;
    }


     public function setPaymentMethodId($payment_method_id)
    {
        $this->payment_method_id = $payment_method_id;
    }
    public function getPaymentMethodId()
    {
        return $this->payment_method_id;
    }


    public function setTotalAmt($total_amt)
    {
        $this->total_amt = $total_amt;
    }
    public function getTotalAmt()
    {
        return $this->total_amt;
    }

    public function setDeliveryAddress($delivery_address)
    {
        $this->delivery_address = $delivery_address;
    }
    public function getDeliveryAddress()
    {
        return $this->delivery_address;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
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
            "user_id" => $this->getUserId(),
            "payment_method_id" => $this->getPaymentMethodId(),
            "total_amt" => $this->getTotalAmt(),
            "delivery_address" => $this->getDeliveryAddress(),
            "status" => $this->getStatus(),
            "created_at" => $this->getCreatedAt(),
            "updated_at" => $this->getUpdatedAt()
        ];
    }
}