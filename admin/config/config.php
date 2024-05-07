<?php
function connectdb() {
$server = 'localhost';
$username = 'root';
$password = '';
try {
    $conn = new PDO("mysql:host=$server;dbname=products", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "". $e->getMessage();
}
return $conn;
}
?>

