<?php

namespace App\Controllers;

use Rakit\Validation\Validator;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

$validator = new Validator;

class AdminController
{
    protected $container;
    protected $Admin;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->Admin = $container->get('Admin');
    }

    public function index(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'admin/index.twig', [
            'title' => 'Manajemen Admin',
            'admins' => $this->Admin->getAll()
        ]);
    }

    public function getAdmin(Request $request, Response $response)
    {
        $admins = $this->Admin->getAll();
        return $response->withJson($admins);
    }

    public function insertAdmin(Request $request, Response $response)
    {
        $validator = new Validator();

        $validation = $validator->validate($request->getParams(), [
            'username' => 'required',
            'name' => 'required'
        ]);

        if ($validation->fails()) {
            return $response->withJson([
                'status' => 422,
                'message' => 'Data admin gagal ditambahkan',
                'errors' => $validation->errors()->firstOfAll()
            ]);
        }

        // Insert data
        if ($this->Admin->create([
            'username' => $request->getParam('username'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            'name' => $request->getParam('name'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ])) {

            $adminData = $this->Admin->lastInserted();

            return $response->withJson([
                'status' => 200,
                'success' => true,
                'message' => 'Data admin berhasil ditambahkan',
                'admin' => $adminData[0]
            ]);
        }

        return $response->withJson([
            'status' => 500,
            'message' => 'Data admin gagal ditambahkan'
        ]);
    }

    public function getAdminById(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $admin = $this->Admin->getById($id);

        if ($admin) {
            $response = [
                'status' => 200,
                'success' => true,
                'message' => 'Data admin ditemukan',
                'admin' => $admin
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = [
                'status' => 404,
                'success' => false,
                'message' => 'Data admin tidak ditemukan'
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }

    }

    public function updateAdmin(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        $validator = new Validator();

        $validation = $validator->validate($request->getParams(), [
            'username' => 'required',
            'name' => 'required'
        ]);

        if ($validation->fails()) {
            return $response->withJson([
                'status' => 422,
                'message' => 'Data admin gagal diupdate',
                'errors' => $validation->errors()->firstOfAll()
            ]);
        }

        if($request->getParam('password')) {
            $data = [
                'username' => $request->getParam('username'),
                'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
                'name' => $request->getParam('name'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        } else {
            $data = [
                'username' => $request->getParam('username'),
                'name' => $request->getParam('name'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        // Update data
        if ($this->Admin->update($id, $data)) {
            $adminData = $this->Admin->getById($id);

            return $response->withJson([
                'status' => 200,
                'success' => true,
                'message' => 'Data admin berhasil diupdate',
                'admin' => $adminData
            ]);
        }

        return $response->withJson([
            'status' => 500,
            'message' => 'Data admin gagal diupdate'
        ]);
    }

    public function deleteAdmin(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        if ($this->Admin->delete($id)) {
            return $response->withJson([
                'status' => 200,
                'success' => true,
                'message' => 'Data admin berhasil dihapus'
            ]);
        }

        return $response->withJson([
            'status' => 500,
            'message' => 'Data admin gagal dihapus'
        ]);
    }
    

}