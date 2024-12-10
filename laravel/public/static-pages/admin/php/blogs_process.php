<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $action = $_POST['action'];

        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO blogs (title, content, author, image) VALUES (:title, :content, :author, :image)");
            $stmt->execute([
                ':title' => $_POST['title'],
                ':content' => $_POST['content'],
                ':author' => $_POST['author'],
                ':image' => $_POST['image'] ?? null
            ]);
        }

        if ($action == 'edit') {
            $stmt = $conn->prepare("UPDATE blogs SET title = :title, content = :content, author = :author, image = :image WHERE id = :id");
            $stmt->execute([
                ':title' => $_POST['title'],
                ':content' => $_POST['content'], 
                ':author' => $_POST['author'],
                ':image' => $_POST['image'] ?? null,
                ':id' => $_POST['id']
            ]);
        }

        if ($action == 'delete') {
            $stmt = $conn->prepare("DELETE FROM blogs WHERE id = :id");
            $stmt->execute([':id' => $_POST['id']]);
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
