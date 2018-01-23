<?php
require_once("Registry.php");

$dsn = 'mysql:host=localhost;dbname=testephp';
$user = 'root';
$password = '1234';
try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Armazenar essa instância no Registry
$registry = Registry::getInstance();
$registry->set('Connection', $conn);
?>