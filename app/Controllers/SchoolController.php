<?php

namespace App\Controllers;

use Rakit\Validation\Validator;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

$validator = new Validator;

class SchoolController
{
    protected $container;
    protected $Schools;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->Schools = $container->get('School');
    }

    public function index(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'schools/index.twig', [
            'title' => 'Manajemen Sekolah',
            'schools' => $this->Schools->all()
        ]);
    }

    public function getSchool(Request $request, Response $response)
    {
        $schools = $this->Schools->all();
        return $response->withJson($schools);
    }

    public function insertSchool(Request $request, Response $response)
    {
        $validator = new Validator();

        $validation = $validator->validate($request->getParams(), [
            'school_name' => 'required',
            'address' => 'required'
        ]);

        if ($validation->fails()) {
            return $response->withJson([
                'status' => 422,
                'message' => 'Data sekolah gagal ditambahkan',
                'errors' => $validation->errors()->firstOfAll()
            ]);
        }


        // Insert data
        if ($this->Schools->create([
            'school_name' => $request->getParam('school_name'),
            'address' => $request->getParam('address')
        ])) {
            // Ambil data terakhir yang diinsert
            $lastInsertedData = $this->Schools->lastInserted();

            // Kirim response JSON
            $response = [
                'status' => 200,
                'success' => true,
                'message' => 'Sekolah berhasil ditambahkan',
                'school' => $lastInsertedData[0]
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        } else {
            // Kirim response JSON
            $response = [
                'status' => 422,
                'success' => false,
                'message' => 'Sekolah gagal ditambahkan'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        }
    }

    public function getSchoolById(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $school = $this->Schools->findById($id);
        if ($school) {
            $response = [
                'status' => 200,
                'success' => true,
                'message' => 'Sekolah berhasil ditambahkan',
                'school' => $school
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

    public function updateSchool(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        $validator = new Validator();

        $validation = $validator->validate($request->getParams(), [
            'school_name' => 'required',
            'address' => 'required'
        ]);

        if ($validation->fails()) {
            return $response->withJson([
                'status' => 422,
                'message' => 'Data sekolah gagal diupdate',
                'errors' => $validation->errors()->firstOfAll()
            ]);
        }

        // Update data
        if ($this->Schools->update($id, [
            'school_name' => $request->getParam('school_name'),
            'address' => $request->getParam('address')
        ])) {
            // Ambil data terakhir yang diinsert
            $lastInsertedData = $this->Schools->findById($id);

            // Kirim response JSON
            $response = [
                'status' => 200,
                'success' => true,
                'message' => 'Sekolah berhasil diupdate',
                'schools' => $lastInsertedData
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        } else {
            // Kirim response JSON
            $response = [
                'status' => 422,
                'success' => false,
                'message' => 'Sekolah gagal diupdate'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);

        }
    }

    public function deleteSchool(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        if ($this->Schools->delete($id)) {
            $response = [
                'status' => 200,
                'success' => true,
                'message' => 'Sekolah berhasil dihapus'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = [
                'status' => 422,
                'success' => false,
                'message' => 'Sekolah gagal dihapus'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
