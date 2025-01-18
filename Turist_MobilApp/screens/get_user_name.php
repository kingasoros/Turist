<?php
session_start();

if (isset($_SESSION['user_name'])) {
    echo json_encode(['success' => true, 'user_name' => $_SESSION['user_name']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Nem található session adat.']);
}
?>
