<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');

$userId = Auth::id();

if ($userId) {
    $stmt = $conn->prepare("
        SELECT 
            t.tour_id,
            t.tour_name,
            t.tour_description,
            t.start_date,
            t.end_date,
            t.created_at,
            a.name AS attraction_name,
            a.description AS attraction_description,
            a.image AS attraction_image,
            a.price AS attraction_price,
            a.open AS attraction_open,
            a.closed AS attraction_closed
        FROM tours t
        LEFT JOIN tour_attractions ta ON t.tour_id = ta.tour_id
        LEFT JOIN attractions a ON ta.attractions_id = a.attractions_id
        WHERE EXISTS (
            SELECT 1 FROM turist_favorites tf 
            WHERE tf.tour_id = t.tour_id 
            AND tf.id = :user_id
        )
        ORDER BY t.tour_id, ta.attraction_order
    ");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $toursGrouped = [];
    foreach ($tours as $tour) {
        $tourId = $tour['tour_id'];
        if (!isset($toursGrouped[$tourId])) {
            $toursGrouped[$tourId] = [
                'id' => $tour['tour_id'],
                'tour_name' => $tour['tour_name'],
                'tour_description' => $tour['tour_description'],
                'created_at' => $tour['created_at'],
                'start_date' => $tour['start_date'],
                'end_date' => $tour['end_date'],
                'attractions' => []
            ];
        }
        if (!empty($tour['attraction_name'])) {
            $toursGrouped[$tourId]['attractions'][] = [
                'name' => $tour['attraction_name'],
                'description' => $tour['attraction_description'],
                'image' => $tour['attraction_image'],
                'price' => $tour['attraction_price'],
                'open' => $tour['attraction_open'],
                'closed' => $tour['attraction_closed']
            ];
        }
    }
} else {
    $toursGrouped = []; 
}
?>

@extends('layouts.master')

@section('title', 'Kedvencek')

@section('header', 'Kedvencek')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/styles_1.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kedvenc túrák') }}
        </h2>   
    </x-slot>
    <div class="container my-4">
        <div class="row">
        <?php if (!empty($toursGrouped)) { ?>
        <?php foreach ($toursGrouped as $tour) { ?>
            <!-- Show the tour_id here -->
            <div class="col-12 col-md-6 mb-4" id="tour-<?= htmlspecialchars($tour['id']) ?>">
                <div class="card">
                    <div class="card-header text-white text-center py-3">
                        <h4><?= htmlspecialchars($tour['tour_name']) ?> <i class="fas fa-heart text-danger"></i></h4>
                    </div>
                    <div class="card-body">
                        
                        <h5 class="card-title text-secondary"><?= htmlspecialchars($tour['tour_description'] ?? 'Nincs leírás') ?></h5>

                        <h6 class="mt-3 text-dark">Látványosságok:</h6>
                        <?php if (!empty($tour['attractions'])) { ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($tour['attractions'] as $attraction) { ?>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <strong class="mr-2"><?= htmlspecialchars($attraction['name']) ?>:</strong>
                                        <div class="row w-100">
                                            <!-- Leírás oszlop -->
                                            <div class="col-md-4">
                                                <small class="text-muted" style="color:#464c51 !important;"><?= htmlspecialchars($attraction['description'] ?? 'Nincs leírás') ?></small>
                                            </div>
                                            <!-- Ár oszlop -->
                                            <div class="col-md-4 text-center">
                                                <small class="text-muted" style="color:#464c51 !important;">Ár: <?= htmlspecialchars($attraction['price'] ) ?> Din</small>
                                                <small class="text-muted" style="color:#464c51 !important;">Nyitvatartás: <?= htmlspecialchars($attraction['open'] ) ?> - <?= htmlspecialchars($attraction['closed'] ) ?></small>
                                            </div>
                                            <!-- Kép oszlop -->
                                            <div class="col-md-4 text-center">
                                                <img src="http://localhost/Turist/img/<?= !empty($attraction['image']) ? htmlspecialchars($attraction['image']) : 'default.jpg' ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($attraction['name']) ?>" style="max-height: 100px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-muted">Nincsenek látványosságok a túrához.</p>
                        <?php } ?>

                        <?php if (isset($tour['id'])) { ?>
                            <form id="deleteForm-<?= htmlspecialchars($tour['id']) ?>" action="{{ route('favorites.delete') }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tour['id']) ?>">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <button type="button" class="btn btn-dark mt-3" onclick="deleteFavorite(<?= htmlspecialchars($tour['id']) ?>)">Törlés a kedvencekből</button>
                            </form>
                        <?php } else { ?>
                            <p class="text-danger">Tour ID hiányzik</p>
                        <?php } ?>
                    </div>
                    <div class="card-footer text-center py-2">
                        <small><?= date('Y-m-d', strtotime($tour['created_at'] ?? 'now')) ?></small>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-center text-muted">Nincsenek elérhető adatok.</p>
    <?php } ?>
        </div>
    </div>
</x-app-layout>
  
<script>
    function deleteFavorite(tourId) {
        var form = document.getElementById('deleteForm-' + tourId);
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var tourCard = document.getElementById('tour-' + tourId);
                if (tourCard) {
                    tourCard.remove();
                }
                alert('Túra sikeresen törölve a listádról.');
            } else {
                alert('Hiba történt a törlés során.');
            }
        })
        .catch(error => {
            console.error('Hiba történt:', error);
            alert('Hiba történt a törlés során.');
        });
    }
</script>

@endsection