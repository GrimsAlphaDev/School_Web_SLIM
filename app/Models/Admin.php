<?php

namespace App\Models;

use Medoo\Medoo;

class Admin
{
    protected $database;
    protected $table = 'tbl_admins';


    public function __construct($database)
    {
        $this->database = $database;
    }

    // Method dasar CRUD
    public function getAll($columns = '*', $where = null)
    {
        return $this->database->select($this->table, $columns, $where);
    }

    public function getById($id, $columns = '*')
    {
        return $this->database->get($this->table, $columns, ['id' => $id]);
    }

    public function getByUsername($username, $columns = '*')
    {
        return $this->database->get($this->table, $columns, ['username' => $username]);
    }

    public function create(array $data)
    {
        return $this->database->insert($this->table, $data);
    }

    public function lastInserted($columns = '*')
    {
        return $this->database->select($this->table, $columns, [
            'ORDER' => ['id' => 'DESC'],
            'LIMIT' => 1
        ]);
    }

    public function update($id, $data)
    {
        return $this->database->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->database->delete($this->table, ['id' => $id]);
    }
}
