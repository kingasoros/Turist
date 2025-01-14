<?php
// db_conn.php bekötése
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = $_POST['action'];
        $new_file_name = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file_name = $_FILES['image']["name"];
            $file_temp = $_FILES["image"]["tmp_name"];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; 
            if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                header("Location: ../attractions.php?error=Csak JPEG, PNG, vagy GIF formátum engedélyezett.");
                exit();
            }

            if (!exif_imagetype($file_temp)) {
                header("Location: ../attractions.php?error=Nem érvényes képfájl.");
                exit();
            }

            $ext_temp = explode(".", $file_name);
            $extension = end($ext_temp);
            $new_file_name = date("YmdHis") . ".$extension";

            $directory = "../../../../../img";
            $upload = "$directory/$new_file_name";
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true); 
            }

            if (move_uploaded_file($file_temp, $upload)) {
            } else {
                header("Location: ../attractions.php?error=Hiba történt a fájl feltöltése közben.");
                exit();
            }
        }

        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO attractions (city_name, name, description, address, created_by, image, type, interest) 
                                    VALUES (:city_name, :name, :description, :address, :created_by, :image, :type, :interest)");
            $stmt->execute([
                ':city_name' => trim($_POST['city_name']),
                ':name' => trim($_POST['name']),
                ':description' => trim($_POST['description']),
                ':address' => trim($_POST['address']),
                ':created_by' => trim($_POST['created_by']),
                ':image' => $new_file_name, 
                ':type' => trim($_POST['type']),
                ':interest' => trim($_POST['interest'])
            ]);
        } 
        if ($action === 'edit') {
            $stmt = $conn->prepare("UPDATE attractions 
                                    SET city_name = :city_name, name = :name, description = :description, 
                                        address = :address, created_by = :created_by, 
                                        image = :image, type = :type, interest = :interest
                                    WHERE attractions_id = :attractions_id");
            $stmt->execute([
                ':attractions_id' => (int)$_POST['attractions_id'],
                ':city_name' => trim($_POST['city_name']),
                ':name' => trim($_POST['name']),
                ':description' => trim($_POST['description']),
                ':address' => trim($_POST['address']),
                ':created_by' => trim($_POST['created_by']),
                ':image' => $new_file_name ?? $_POST['existing_image'], 
                ':type' => trim($_POST['type']),
                ':interest' => trim($_POST['interest'])
            ]);
        }  
        elseif ($action === 'delete') {
            $stmt = $conn->prepare("SELECT image FROM attractions WHERE attractions_id = :attractions_id");
            $stmt->execute([':attractions_id' => (int)$_POST['attractions_id']]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
            $imagePath = "../../../../../img/" . $new_file_name;
            if (file_exists($imagePath)) {
                unlink($imagePath);  
            }
            $stmt = $conn->prepare("DELETE FROM attractions WHERE attractions_id = :attractions_id");
            $stmt->execute([':attractions_id' => (int)$_POST['attractions_id']]);
        }
        
    } catch (Exception $e) {
        echo "Hiba történt: " . htmlspecialchars($e->getMessage());
        exit;
    }
    header("Location:../attractions.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM attractions");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
