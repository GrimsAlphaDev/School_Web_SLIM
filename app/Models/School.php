<?php
namespace App\Models;

class School {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function all() {
        return $this->db->select('tbl_schools', '*');
    }

    public function findById($id) {
        return $this->db->get('tbl_schools', '*', [
            'id' => $id
        ]);
    }

    public function create($data) {
        return $this->db->insert('tbl_schools', $data);
    }

    public function update($id, $data) {
        return $this->db->update('tbl_schools', $data, [
            'id' => $id
        ]);
    }

    public function delete($id) {
        return $this->db->delete('tbl_schools', [
            'id' => $id
        ]);
    }
}
