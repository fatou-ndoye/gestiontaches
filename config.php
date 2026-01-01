<?php
$host = 'localhost'; $db = 'gestion_taches'; $user = 'root'; $pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
try { $pdo = new PDO($dsn, $user, $pass, $options); }
catch (PDOException $e) { exit('BDD erreur : ' . $e->getMessage()); }
session_start();
function requireAuth($role = null) {
    if (!isset($_SESSION['auth'])) { header('Location: login.php'); exit; }
    if ($role && $_SESSION['auth']['role'] !== $role) { header('Location: tableau.php'); exit; }
}
?>