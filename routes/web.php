<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

// Auth
$app->get('/login', 'AuthController:login')->setName('login')->add(new GuestMiddleware($container));
$app->post('/login', 'AuthController:postLogin')->setName('post.login')->add(new GuestMiddleware($container));
$app->get('/logout', 'AuthController:logout')->setName('logout');

// Dashboard
$app->get('/', 'DashboardController:index')->setName('home')->add(new AuthMiddleware($container));

// school 
$app->get('/school', 'SchoolController:index')->setName('school')->add(new AuthMiddleware($container));
// get school data only
$app->get('/school/get', 'SchoolController:getSchool')->setName('school.get')->add(new AuthMiddleware($container));
// insert school
$app->post('/school/insert', 'SchoolController:insertSchool')->setName('school.insert')->add(new AuthMiddleware($container));
// get school by id
$app->get('/school/get/{id}', 'SchoolController:getSchoolById')->setName('school.get.id')->add(new AuthMiddleware($container));
// update school
$app->post('/school/update/{id}', 'SchoolController:updateSchool')->setName('school.update')->add(new AuthMiddleware($container));
// delete school
$app->delete('/school/delete/{id}', 'SchoolController:deleteSchool')->setName('school.delete')->add(new AuthMiddleware($container));

// student
$app->get('/student', 'StudentController:index')->setName('student')->add(new AuthMiddleware($container));
// get student data only
$app->get('/student/get', 'StudentController:getStudent')->setName('student.get')->add(new AuthMiddleware($container));
// insert student
$app->post('/student/insert', 'StudentController:insertStudent')->setName('student.insert')->add(new AuthMiddleware($container));
// get student by id
$app->get('/student/get/{id}', 'StudentController:getStudentById')->setName('student.get.id')->add(new AuthMiddleware($container));
// update student
$app->post('/student/update/{id}', 'StudentController:updateStudent')->setName('student.update')->add(new AuthMiddleware($container));
// delete student
$app->delete('/student/delete/{id}', 'StudentController:deleteStudent')->setName('student.delete')->add(new AuthMiddleware($container));

// admin
$app->get('/admin', 'AdminController:index')->setName('admin')->add(new AuthMiddleware($container));
// get admin data only
$app->get('/admin/get', 'AdminController:getAdmin')->setName('admin.get')->add(new AuthMiddleware($container));
// insert admin
$app->post('/admin/insert', 'AdminController:insertAdmin')->setName('admin.insert')->add(new AuthMiddleware($container));
// get admin by id
$app->get('/admin/get/{id}', 'AdminController:getAdminById')->setName('admin.get.id')->add(new AuthMiddleware($container));
// update admin
$app->post('/admin/update/{id}', 'AdminController:updateAdmin')->setName('admin.update')->add(new AuthMiddleware($container));
// delete admin
$app->delete('/admin/delete/{id}', 'AdminController:deleteAdmin')->setName('admin.delete')->add(new AuthMiddleware($container));
