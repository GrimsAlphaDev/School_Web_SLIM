<?php

namespace App\Models;

class Students {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function all() {
        return $this->db->select('tbl_students', '*');
    }

    public function findById($id) {
        return $this->db->get('tbl_students', '*', [
            'id' => $id
        ]);
    }

    public function create($data) {
        return $this->db->insert('tbl_students', $data);
    }

    public function update($id, $data) {
        return $this->db->update('tbl_students', $data, [
            'id' => $id
        ]);
    }

    public function delete($id) {
        return $this->db->delete('tbl_students', [
            'id' => $id
        ]);
    }
}