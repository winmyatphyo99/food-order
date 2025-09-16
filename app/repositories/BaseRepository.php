<?php
abstract class BaseRepository {
    protected $db;
    protected $table;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->setTable();
    }

    abstract protected function setTable();

    public function findById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}