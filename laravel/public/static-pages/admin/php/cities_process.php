<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $action = $_POST['action'];

        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO cities (country_name, city_name, zip_code) VALUES (:country_name, :city_name, :zip_code)");
            $stmt->execute([
                ':country_name' => $_POST['country_name'],
                ':city_name' => $_POST['city_name'],
                ':zip_code' => $_POST['zip_code']
            ]);
        }

        if ($action == 'edit') {
            $stmt = $conn->prepare("UPDATE cities SET country_name = :country_name, city_name = :city_name, zip_code = :zip_code WHERE city_id = :city_id");
            $stmt->execute([
                ':country_name' => $_POST['country_name'],
                ':city_name' => $_POST['city_name'],
                ':zip_code' => $_POST['zip_code'],
                ':city_id' => $_POST['city_id']
            ]);
        }

        if ($action == 'delete') {
            $stmt = $conn->prepare("DELETE FROM cities WHERE city_id = :city_id");
            $stmt->execute([':city_id' => $_POST['city_id']]);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
    header('Location: ../cities.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM cities");
$stmt->execute();
$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
