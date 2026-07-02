<?php
$host = '127.0.0.1';
$username = 'root';
$password = 'xiaoqiang2024';
$database = 'enterprise_cms';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->close();
