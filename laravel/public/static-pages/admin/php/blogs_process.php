<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO blogs (title, content, author, image) VALUES (:title, :content, :author, :new_file_name)");
            $stmt->execute([
                ':title' => $_POST['title'],
                ':content' => $_POST['content'],
                ':author' => $_POST['author'],
                ':new_file_name' => $_POST['new_file_name'] ?? null
            ]);
        }

        if ($action == 'edit') {
            $stmt = $conn->prepare("UPDATE blogs SET title = :title, content = :content, author = :author, image = :new_file_name WHERE id = :id");
            $stmt->execute([
                ':title' => $_POST['title'],
                ':content' => $_POST['content'], 
                ':author' => $_POST['author'],
                ':new_file_name' => $_POST['new_file_name'] ?? null,
                ':id' => $_POST['id']
            ]);
        }

        if ($action == 'delete') {
            $stmt = $conn->prepare("DELETE FROM blogs WHERE id = :id");
            $stmt->execute([':id' => $_POST['id']]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
            $imagePath = "../../../../../img/" . $new_file_name;
            if (file_exists($imagePath)) {
                unlink($imagePath);  
            }
            $stmt = $conn->prepare("DELETE FROM blogs WHERE id = :id");
            $stmt->execute([':id' => (int)$_POST['id']]);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
    header('Location: ../blogs.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM blogs");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
