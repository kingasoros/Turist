<?php
require 'db_conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Hiányzó adatok.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = :email AND is_active = 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                unset($user['password']);
                
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['id'] = $user['id'];
                
                echo json_encode(['success' => true, 'message' => 'Bejelentkezés sikeres!', 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Hibás jelszó.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Az e-mail nem található vagy a fiók inaktív.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Hiba: ' . $e->getMessage()]);
    }
}
?>
