<?php
class ContactRepository {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    // Save contact message
    public function save(ContactModel $contact) {
        return $this->db->create('contacts', $contact->toArray());
    }

    // Get all messages (optional)
    public function getAll() {
        return $this->db->readAll('contacts');
    }
}
