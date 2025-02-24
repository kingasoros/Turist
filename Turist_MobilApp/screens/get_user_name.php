<?php
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['user_name'])) {
    http_response_code(200); 
    echo json_encode(['success' => true, 'user_name' => $_SESSION['user_name']]);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Nem található session adat.']);
}
?>
