<?php

namespace App\Models;

class Students {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function all() {
        // select all students with school name
        return $this->db->query('SELECT tbl_students.*, tbl_schools.school_name as school_name FROM tbl_students JOIN tbl_schools ON tbl_students.id_school = tbl_schools.id')->fetchAll();
    }

    public function findById($id) {
        return $this->db->query('SELECT tbl_students.*, tbl_schools.school_name as school_name FROM tbl_students JOIN tbl_schools ON tbl_students.id_school = tbl_schools.id WHERE tbl_students.id = ' . $id)->fetch();
    }

    public function create($data) {
        return $this->db->insert('tbl_students', $data);
    }

    public function lastInserted() {
        // return $this->db->select('tbl_students', '*', [
        //     'ORDER' => ['id' => 'DESC'],
        //     'LIMIT' => 1
        // ]); after that join the school name
        return $this->db->query('SELECT tbl_students.*, tbl_schools.school_name as school_name FROM tbl_students JOIN tbl_schools ON tbl_students.id_school = tbl_schools.id ORDER BY tbl_students.id DESC LIMIT 1')->fetch();
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

    public function count() {
        return $this->db->count('tbl_students');
    }

    
}