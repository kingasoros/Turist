<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');


$stmt = $conn->prepare("SELECT * FROM blogs");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <?php if (!empty($blogs)) { ?>
        <div class="row card-group">
            <?php foreach ($blogs as $index => $blog) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <a href="{{ route('blogs_page', ['id' => $blog['id']]) }}">
                                <img src="http://localhost/Turist/img/<?= !empty($blog['image']) ? htmlspecialchars($blog['image']) : 'default.jpg' ?>" alt="Blog image" class="card-img-top" style="width: 100%; height: auto;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($blog['title']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars(substr($blog['content'], 0, 100)) ?>...</p>
                                    <p class="card-text"><small class="text-muted"><?= htmlspecialchars($blog['author']) ?></small></p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php if (($index + 1) % 3 == 0) { ?>
                        </div><div class="row card-group">
                    <?php } ?>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-info text-center" role="alert">
            Nincsenek elérhető bejegyzések.
        </div>
    <?php } ?>

</x-app-layout>
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