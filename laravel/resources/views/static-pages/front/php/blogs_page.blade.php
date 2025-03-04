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

@extends('layouts.master')

@section('title', 'Blogok')

@section('header', 'Blogok')

@section('content')

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

@endsection

<?php 
    } else {
        echo "<p>Blog post not found.</p>";
    }
} else {
    echo "<p>No blog ID provided.</p>";
}
?>