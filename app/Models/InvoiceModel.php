<?php

class InvoiceModel
{
    // Private properties representing the database columns
    private $id;
    private $invoice_number;
    private $order_id;
    private $created_at;

    /**
     * Public getters and setters for each property.
     * They provide a controlled interface for accessing and modifying
     * the private properties from outside the class.
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setInvoiceNumber($invoice_number)
    {
        $this->invoice_number = $invoice_number;
    }
    public function getInvoiceNumber()
    {
        return $this->invoice_number;
    }

    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }
    public function getOrderId()
    {
        return $this->order_id;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * The toArray method is a utility function to return the object's properties as an array.
     */
    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "invoice_number" => $this->getInvoiceNumber(),
            "order_id" => $this->getOrderId(),
            "created_at" => $this->getCreatedAt()
        ];
    }
}