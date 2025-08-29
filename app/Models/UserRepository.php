<?php
class UserRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    

    public function getAllUsersWithOrderCount() {
    $this->db->query("SELECT * FROM `user_total_order`
    ");
    return $this->db->resultSet();
}

    
public function getUserById($id) {
    $this->db->query("SELECT id, name, email, phone_number, profile_image FROM users WHERE id = :id");
    $this->db->bind(':id', $id);
    return $this->db->single();
}

public function updateUserProfile($id, $data) {
    $fields = [];
    $params = [':id' => $id];

    if(isset($data['name'])){
        $fields[] = "name = :name";
        $params[':name'] = $data['name'];
    }
    if(isset($data['email'])){
        $fields[] = "email = :email";
        $params[':email'] = $data['email'];
    }
    if(isset($data['phone_number'])){
        $fields[] = "phone_number = :phone_number";
        $params[':phone_number'] = $data['phone_number'];
    }
    if(isset($data['profile_image'])){
        $fields[] = "profile_image = :profile_image";
        $params[':profile_image'] = $data['profile_image'];
    }

    if (empty($fields)) {
        return false;
    }

    $sql = "UPDATE users SET " . implode(',', $fields) . " WHERE id = :id";
    $this->db->query($sql);

    foreach($params as $key => $value){
        $this->db->bind($key, $value);
    }

    return $this->db->execute();
}


    // Update password
public function updatePassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password = :password WHERE id = :id");
        $this->db->bind(':password', $hashed);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }


    // Delete user my admin
    public function delete($id)
    {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(":id", $id);
        return $this->db->execute();
    }

    
}
