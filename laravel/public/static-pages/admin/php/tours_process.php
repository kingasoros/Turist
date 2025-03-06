<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("
            INSERT INTO tours (tour_name, tour_description, status, start_date, end_date) 
            VALUES (:tour_name, :tour_description, :status, :start_date, :end_date)
        ");
        $stmt->execute([
            ':tour_name' => $_POST['tour_name'],
            ':tour_description' => $_POST['tour_description'],
            ':status' => $_POST['status'],
            ':start_date' => $_POST['start_date'],
            ':end_date' => $_POST['end_date']
        ]);

        $tour_id = $conn->lastInsertId();

        if (!empty($_POST['attractions'])) {
            foreach ($_POST['attractions'] as $attraction_id) {
                $stmt = $conn->prepare("
                    INSERT INTO tour_attractions (tour_id, attractions_id) 
                    VALUES (:tour_id, :attractions_id)
                ");
                $stmt->execute([
                    ':tour_id' => $tour_id,
                    ':attractions_id' => $attraction_id
                ]);
            }
        }
    } 

    if ($action == 'edit') {
        $stmt = $conn->prepare("
            UPDATE tours 
            SET tour_name = :tour_name, 
                tour_description = :tour_description, 
                status = :status, 
                start_date = :start_date, 
                end_date = :end_date 
            WHERE tour_id = :tour_id
        ");
        $stmt->execute([
            ':tour_name' => $_POST['tour_name'],
            ':tour_description' => $_POST['tour_description'],
            ':status' => $_POST['status'],
            ':start_date' => $_POST['start_date'],
            ':end_date' => $_POST['end_date'],
            ':tour_id' => $_POST['tour_id']
        ]);

        $stmt = $conn->prepare("DELETE FROM tour_attractions WHERE tour_id = :tour_id");
        $stmt->execute([':tour_id' => $_POST['tour_id']]);

        // Hozzáadjuk az új látványosságokat
        if (!empty($_POST['attractions'])) {
            foreach ($_POST['attractions'] as $attraction_id) {
                $stmt = $conn->prepare("
                    INSERT INTO tour_attractions (tour_id, attractions_id) 
                    VALUES (:tour_id, :attractions_id)
                ");
                $stmt->execute([
                    ':tour_id' => $_POST['tour_id'],
                    ':attractions_id' => $attraction_id
                ]);
            }
        }
    }elseif ($action == 'delete') {
        // Töröljük a tour_attractions rekordokat
        $stmt = $conn->prepare("DELETE FROM tour_attractions WHERE tour_id = :tour_id");
        if ($stmt->execute([':tour_id' => $_POST['tour_id']])) {
            error_log("Tour attractions deleted successfully for tour_id: " . $_POST['tour_id']);
        } else {
            error_log("Failed to delete tour attractions for tour_id: " . $_POST['tour_id']);
        }
    
        // Töröljük a tours rekordot
        $stmt = $conn->prepare("DELETE FROM tours WHERE tour_id = :tour_id");
        if ($stmt->execute([':tour_id' => $_POST['tour_id']])) {
            error_log("Tour deleted successfully for tour_id: " . $_POST['tour_id']);
        } else {
            error_log("Failed to delete tour for tour_id: " . $_POST['tour_id']);
        }
    }
    
    

    header("Location: ../tours.php");
    exit();
}
