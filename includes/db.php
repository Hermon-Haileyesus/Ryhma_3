<?php
$servername = "localhost";
$username = "ravintolan";
$password = "ravintola";
$database = "Ravintola1";
try {
  $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>