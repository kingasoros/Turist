<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = $_POST['action'];
        $imagePath = null;

        // Kép feltöltése
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "../uploads/";
            $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $imageName;

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['image']['type'], $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = "uploads/" . $imageName;
                } else {
                    throw new Exception("Kép feltöltése nem sikerült.");
                }
            } else {
                throw new Exception("Csak JPEG, PNG, vagy GIF formátum engedélyezett.");
            }
        }

        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO attractions (city_name, name, description, address, created_by, image) 
                                    VALUES (:city_name, :name, :description, :address, :created_by, :image)");
            $stmt->execute([
                ':city_name' => trim($_POST['city_name']),
                ':name' => trim($_POST['name']),
                ':description' => trim($_POST['description']),
                ':address' => trim($_POST['address']),
                ':created_by' => trim($_POST['created_by']),
                ':image' => $imagePath
            ]);
        } elseif ($action === 'edit') {
            $stmt = $conn->prepare("UPDATE attractions 
                                    SET city_name = :city_name, name = :name, description = :description, 
                                        address = :address, created_by = :created_by, 
                                        image = COALESCE(:image, image)
                                    WHERE attractions_id = :attractions_id");
            $stmt->execute([
                ':attractions_id' => (int)$_POST['attractions_id'],
                ':city_name' => trim($_POST['city_name']),
                ':name' => trim($_POST['name']),
                ':description' => trim($_POST['description']),
                ':address' => trim($_POST['address']),
                ':created_by' => trim($_POST['created_by']),
                ':image' => $imagePath ?: null
            ]);
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM attractions WHERE attractions_id = :attractions_id");
            $stmt->execute([':attractions_id' => (int)$_POST['attractions_id']]);
        }
    } catch (Exception $e) {
        echo "Hiba történt: " . htmlspecialchars($e->getMessage());
        exit;
    }
}

header("Location: ../attractions.php");
exit;
?>
