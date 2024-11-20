<?php
namespace App\Models;

class Admin {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function findByUsername($username) {
        return $this->db->get('tbl_admins', '*', [
            'username' => $username
        ]);
    }

    public function create($data) {
        return $this->db->insert('tbl_admins', $data);
    }

    public function update($id, $data) {
        return $this->db->update('tbl_admins', $data, [
            'id' => $id
        ]);
    }

    public function delete($id) {
        return $this->db->delete('tbl_admins', [
            'id' => $id
        ]);
    }
}