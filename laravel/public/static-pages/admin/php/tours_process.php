<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO tours (tour_name, tour_description, price, status) VALUES (:tour_name, :tour_description, :price, :status)");
        $stmt->execute([
            ':tour_name' => $_POST['tour_name'],
            ':tour_description' => $_POST['tour_description'],
            ':price' => $_POST['price'],
            ':status' => $_POST['status'] 
        ]);

        $tour_id = $conn->lastInsertId();

        if (!empty($_POST['attractions'])) {
            foreach ($_POST['attractions'] as $attraction_id) {
                $stmt = $conn->prepare("INSERT INTO tour_attractions (tour_id, attractions_id) VALUES (:tour_id, :attractions_id)");
                $stmt->execute([
                    ':tour_id' => $tour_id,
                    ':attractions_id' => $attraction_id
                ]);
            }
        }
    } 

    if ($action == 'edit') {
        $stmt = $conn->prepare("UPDATE tours SET tour_name = :tour_name, tour_description = :tour_description, price = :price, status = :status WHERE tour_id = :tour_id");
        $stmt->execute([
            ':tour_name' => $_POST['tour_name'],
            ':tour_description' => $_POST['tour_description'],
            ':price' => $_POST['price'],
            ':status' => $_POST['status'], 
            ':tour_id' => $_POST['tour_id']
        ]);

        $stmt = $conn->prepare("DELETE FROM tour_attractions WHERE tour_id = :tour_id");
        $stmt->execute([':tour_id' => $_POST['tour_id']]);

        if (!empty($_POST['attractions'])) {
            foreach ($_POST['attractions'] as $attraction_id) {
                $stmt = $conn->prepare("INSERT INTO tour_attractions (tour_id, attractions_id) VALUES (:tour_id, :attractions_id)");
                $stmt->execute([
                    ':tour_id' => $_POST['tour_id'],
                    ':attractions_id' => $attraction_id
                ]);
            }
        }
    }

    if ($action == 'delete') {
        $stmt = $conn->prepare("DELETE FROM tours WHERE tour_id = :tour_id");
        $stmt->execute([':tour_id' => $_POST['tour_id']]);
    }

    header("Location: ../tours.php");
    exit();
}
