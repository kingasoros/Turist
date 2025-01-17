<?php
require "db_conn.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM attractions WHERE name LIKE :search";
$stmt = $conn->prepare($query);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->execute();

$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($attractions);
?>
