<?php
class ContactModel
{
    private $id;
    private $name;
    private $email;
    private $subject;
    private $message;
    private $created_at;

    // Setters & getters
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }

    public function setEmail($email) { $this->email = $email; }
    public function getEmail() { return $this->email; }

    public function setSubject($subject) { $this->subject = $subject; }
    public function getSubject() { return $this->subject; }

    public function setMessage($message) { $this->message = $message; }
    public function getMessage() { return $this->message; }

    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function getCreatedAt() { return $this->created_at; }

    public function toArray() {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "email" => $this->getEmail(),
            "subject" => $this->getSubject(),
            "message" => $this->getMessage(),
            "created_at" => $this->getCreatedAt()
        ];
    }
}
