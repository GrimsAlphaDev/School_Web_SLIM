<?php

use Medoo\Medoo;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

try {
    $dotenv->load();

    $database = new Medoo([
        'database_type' => 'mysql',
        'database_name' => $_ENV['DB_NAME'],
        'server' => $_ENV['DB_HOST'] ?? 'localhost',
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'charset' => 'utf8mb4',
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'option' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]);


} catch (\Exception $e) {
    // Tampilkan detail error untuk debugging
    die("Koneksi database gagal: " . $e->getMessage());
}