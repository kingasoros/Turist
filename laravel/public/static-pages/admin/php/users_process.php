<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $action = $_POST['action'];

        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
            $stmt->execute([
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                ':role' => 1 
            ]);
        }

        if ($action == 'edit') {
            $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id AND role = 1");
            $stmt->execute([
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                ':id' => $_POST['id']
            ]);
        }

        if ($action == 'delete') {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = :id AND role = 1");
            $stmt->execute([':id' => $_POST['id']]);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
    header('Location: ../users.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE role = 1");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
