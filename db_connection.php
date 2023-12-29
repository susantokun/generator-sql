<?php
require_once './config/dotenv.php';

loadEnv();

$DB_HOST = getenv('DB_HOST');
$DB_USER = getenv('DB_USER');
$DB_PASSWORD = getenv('DB_PASSWORD');
$DB_DATABASE = getenv('DB_DATABASE');

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
