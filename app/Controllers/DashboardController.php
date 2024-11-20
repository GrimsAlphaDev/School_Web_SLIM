<?php

namespace App\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class DashboardController
{

    protected $container;
    protected $Students;
    protected $Schools;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->Students = $container->get('Students');
        $this->Schools = $container->get('School');
    }

    public function index(Request $request, Response $response)
    {
        $flashMessage = [];
        if(isset($_SESSION['success'])) {
            $flashMessage['success'] = $_SESSION['success'] ?? [];
            unset($_SESSION['success']);
        } 
        
        $schoolsStudents = $this->Schools->studentBySchool();

        // pisahkan data students dengan data schools
        foreach ($schoolsStudents as $school) {
            // get all school
            $schoolOnly[] = $school['school_name'];
            // get all students
            $studentOnly[] = $school['total'];
        }

        return $this->container->view->render($response, 'dashboard/home.twig', [
            'title' => 'Dashboard',
            'flash' => $flashMessage ?? [],
            'countStudents' => $this->Students->count(),
            'countSchools' => $this->Schools->count(),
            'schools' => $schoolOnly,
            'students' => $studentOnly
        ]);
    }
}