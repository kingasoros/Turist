<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');

$request_uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $request_uri);
$id = isset($parts[2]) ? $parts[2] : null; 

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($blog) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="http://localhost/Turist/img/logo.png">
    <title>Blogs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Blogok') }}
        </h2>   
    </x-slot>
    <div class="blog_container">
        <img src="http://localhost/Turist/img/<?= !empty($blog['image']) ? htmlspecialchars($blog['image']) : 'default.jpg' ?>" class="img-fluid" alt="...">

        <h5 class="card-title"><?= htmlspecialchars($blog['title']) ?></h5>
            <p class="card-text"><small class="text-muted"><?= htmlspecialchars($blog['author']) ?></small></p>
            <br>
            <p class="card-text"><?= htmlspecialchars($blog['content']) ?></p>
    </div>
</x-app-layout>
<script>
    if (window.location.href.includes('blogs_page')) {
        const logoImage = document.getElementById('logoImage');

        if (logoImage) {
            logoImage.src = 'http://localhost/Turist/img/logo.png';
        }
    }    
</script>
<footer>
        <div class="footer__container">
            <?php
               $userAgent = $_SERVER['HTTP_USER_AGENT'];
               
               if (preg_match('/mobile/i', $userAgent)) {
                   echo '<a class="app__text" href="https://192.168.1.6:8081">Töltsd le az applikációt!</a>';
               } else {
                   echo '';
               }
               
            ?>
            <p>&copy; {{ date('Y') }} My Application. All rights reserved.</p>
        </div>
</footer> 
</body>
</html>

<?php 
    } else {
        echo "<p>Blog post not found.</p>";
    }
} else {
    echo "<p>No blog ID provided.</p>";
}
?>