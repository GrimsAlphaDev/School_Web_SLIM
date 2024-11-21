<?php

namespace App\Controllers;

use Rakit\Validation\Validator;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

$validator = new Validator;

class StudentController
{
    protected $container;
    protected $Schools;
    protected $Students;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->Schools = $container->get('School');
        $this->Students = $container->get('Students');
    }

    public function index(Request $request, Response $response)
    {
        // print_r($this->Students->all());
        // die;
        return $this->container->view->render($response, 'students/index.twig', [
            'title' => 'Manajemen Siswa',
            'schools' => $this->Schools->all(),
            'students' => $this->Students->all()
        ]);
    }

    public function getStudent(Request $request, Response $response)
    {
        return $response->withJson($this->Students->all());
    }

    public function getStudentById(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $Student = $this->Students->findById($id);
        if ($Student) {
            $response = [
                'status' => 200,
                'success' => true,
                'message' => 'Siswa ditemukan',
                'student' => $Student
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = [
                'status' => 404,
                'success' => false,
                'message' => 'Sekolah tidak ditemukan'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function insertStudent(Request $request, Response $response)
    {
        $validator = new Validator();

        $validation = $validator->validate($request->getParams(), [
            'name' => 'required',
            'school_id' => 'required',
            'email' => 'required',

        ]);

        if ($validation->fails()) {
            return $response->withJson([
                'status' => 422,
                'message' => 'Data siswa gagal ditambahkan',
                'errors' => $validation->errors()->firstOfAll()
            ]);
        }

        // Insert data
        if ($this->Students->create([
            'name' => $request->getParam('name'),
            'id_school' => $request->getParam('school_id'),
            'email' => $request->getParam('email'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ])) {
            // Ambil data terakhir yang diinsert
            // Ambil data terakhir yang diinsert
            $lastInsertedData = $this->Students->lastInserted();
            return $response->withJson([
                'status' => 200,
                'success' => true,
                'message' => 'Data siswa berhasil ditambahkan',
                'student' => $lastInsertedData,
            ]);
        }

        return $response->withJson([
            'status' => 500,
            'message' => 'Data siswa gagal ditambahkan'
        ]);
    }

    public function updateStudent(Request $request, Response $response, $args)
    {
        $validator = new Validator();

        $validation = $validator->validate($request->getParams(), [
            'name' => 'required',
            'school_id' => 'required',
            'email' => 'required',
        ]);

        if ($validation->fails()) {
            return $response->withJson([
                'status' => 422,
                'message' => 'Data siswa gagal diupdate',
                'errors' => $validation->errors()->firstOfAll()
            ]);
        }

        // Update data
        if ($this->Students->update($args['id'], [
            'name' => $request->getParam('name'),
            'id_school' => $request->getParam('school_id'),
            'email' => $request->getParam('email'),
            'updated_at' => date('Y-m-d H:i:s')
        ])) {

            // Ambil data terakhir yang diinsert
            $lastInsertedData = $this->Students->findById($args['id']);

            return $response->withJson([
                'status' => 200,
                'success' => true,
                'message' => 'Data siswa berhasil diupdate',
                'student' => $lastInsertedData
            ]);
        }

        return $response->withJson([
            'status' => 500,
            'message' => 'Data siswa gagal diupdate'
        ]);
    }

    public function deleteStudent(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        if ($this->Students->delete($id)) {
            return $response->withJson([
                'status' => 200,
                'success' => true,
                'message' => 'Data siswa berhasil dihapus'
            ]);
        }

        return $response->withJson([
            'status' => 500,
            'message' => 'Data siswa gagal dihapus'
        ]);
    }
}
