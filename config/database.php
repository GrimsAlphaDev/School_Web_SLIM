<?php
use Medoo\Medoo;

$database = new Medoo([
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'school_web',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4'
]);