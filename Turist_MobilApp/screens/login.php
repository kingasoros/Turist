<?php
require 'db_conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        http_response_code(400);
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

                $token = bin2hex(random_bytes(32)); 

                $updateStmt = $conn->prepare("UPDATE users SET auth_token = :token WHERE id = :id");
                $updateStmt->bindParam(':token', $token);
                $updateStmt->bindParam(':id', $user['id']);
                $updateStmt->execute();

                $_SESSION['user_name'] = $user['name'];
                $_SESSION['id'] = $user['id'];
                
                http_response_code(200); // OK
                echo json_encode([
                    'success' => true, 
                    'message' => 'Bejelentkezés sikeres!', 
                    'user' => $user, 
                    'token' => $token
                ]);
            } else {
                http_response_code(401); 
                echo json_encode(['success' => false, 'message' => 'Hibás jelszó.']);
            }
        } else {
            http_response_code(404); 
            echo json_encode(['success' => false, 'message' => 'Az e-mail nem található vagy a fiók inaktív.']);
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(['success' => false, 'message' => 'Hiba: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Csak POST kérések engedélyezettek.']);
}
?>
