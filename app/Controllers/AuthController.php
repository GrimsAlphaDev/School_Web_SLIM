<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Rakit\Validation\Validator;
use Slim\Container;
use Firebase\JWT\JWT;

$validator = new Validator;

class AuthController
{
    protected $container;
    protected $Admin;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->Admin = $container->get('Admin');
    }

    public function login(Request $request, Response $response)
    {
        if(isset($_SESSION['__flash_messages'])) {
            $flashMessage = $_SESSION['__flash_messages'];
            unset($_SESSION['__flash_messages']);
        }
        return $this->container->view->render($response, 'auth/login.twig', [
            'title' => 'Login',
            'flash' => $flashMessage ?? []
        ]);
    }

    public function postLogin(Request $request, Response $response)
    {
        $validator = new Validator();
        
        $validation = $validator->validate($request->getParams(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        
        if ($validation->fails()) {
            setFlash('error', $validation->errors()->firstOfAll());
            return $response->withRedirect('/login')->withStatus(302);
        }
        
        $username = $request->getParam('username');
        $password = $request->getParam('password');
        
        try {
            $admin = $this->Admin->getByUsername($username);
            
            if ($admin && password_verify($password, $admin['password'])) {
                
                // Generate JWT Token
                $token = $this->generateToken($admin);
                
                // set session
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['token'] = $token;
                // flash message
                setSession('success', 'Login success');
                
                return $response->withRedirect('/')->withStatus(302);
            } else {
                setFlash('error', 'Username or password is wrong');


                return $response->withRedirect('/login')->withStatus(302);
            }
        } catch (\Throwable $th) {
            setFlash('error', $th->getMessage());
            return $response->withRedirect('/login')->withStatus(302);
        }

        return $response->withRedirect('/login');
    }

    public function logout(Request $request, Response $response)
    {
        // delete session
        unset($_SESSION['user_id']);
        unset($_SESSION['token']);
        session_destroy();

        setFlash('success', 'Logout success');
        return $response->withRedirect('/login')->withStatus(302);
    }

    public function postRegister(Request $request, Response $response)
    {
        $validator = new Validator();

        $validation = $validator->validate($request->getParams(), [
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
        ]);

        if ($validation->fails()) {
            setFlash('error', $validation->errors()->firstOfAll());
            return $response->withRedirect('/register')->withStatus(302);
        }

        $data = [
            'username' => $request->getParam('username'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            'name' => $request->getParam('name'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->Admin->create($data);

            setFlash('success', 'Admin created successfully');
            return $response->withRedirect('/login')->withStatus(302);
        } catch (\Throwable $th) {
            setFlash('error', $th->getMessage());
            return $response->withRedirect('/login')->withStatus(302);
        }

        return $response->withRedirect('/login');
    }

    private function generateToken($user)
    {
        $key = $_ENV['JWT_SECRET'];
        $payload = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'iat' => time(),
            'exp' => time() + 43200 // Token berlaku 12 jam
        ];

        return JWT::encode($payload, $key, 'HS256',null, [
            'kid' => $_ENV['JWT_KID']
        ]);
    }
}
