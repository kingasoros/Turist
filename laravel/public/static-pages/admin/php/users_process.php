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
                ':role' => $_POST['role'] // A role itt most már dinamikusan van beállítva a felhasználó által választott érték alapján
            ]);
        }

        if ($action == 'edit') {
            $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, password = :password, role = :role WHERE id = :id");
            $stmt->execute([
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                ':role' => $_POST['role'], // A szerepkör frissítése
                ':id' => $_POST['id']
            ]);
        }

        if ($action == 'delete') {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $_POST['id']]);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
    header('Location: ../users.php');
    exit();
}

// Lekérdezzük az adatbázisból azokat a felhasználókat, akiknek a role értéke 0 (tiltott) vagy 1 (felhasználó)
$stmt = $conn->prepare("SELECT * FROM users WHERE role IN (0, 1)");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
