<?php
// File ini dibuat oleh Maria (Project Manager)
// Pastikan file ini sudah ada dan koneksi sesuai

$host     = 'localhost';
$dbname   = 'event_management';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
