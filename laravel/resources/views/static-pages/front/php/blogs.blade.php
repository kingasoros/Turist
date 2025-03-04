<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');


$stmt = $conn->prepare("SELECT * FROM blogs");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

@endsection