<?php
use App\Models\Tour;

include base_path('resources/views/static-pages/front/php/db_conn.php');

$stmt = $conn->prepare("
    SELECT 
        t.*,
        a.name AS attraction_name,
        a.description AS attraction_description,
        a.image AS attraction_image,
        t.start_date,  -- Hozzáadva a start_date
        t.end_date     -- Hozzáadva az end_date
    FROM tours t
    LEFT JOIN tour_attractions ta ON t.tour_id = ta.tour_id
    LEFT JOIN attractions a ON ta.attractions_id = a.attractions_id
    WHERE t.status = 'public'
    ORDER BY t.tour_id, ta.attraction_order
");
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
            'price' => $tour['price'],
            'created_at' => $tour['created_at'],
            'start_date' => $tour['start_date'],  // Hozzáadva a start_date
            'end_date' => $tour['end_date'],      // Hozzáadva az end_date
            'attractions' => []
        ];
    }
    if (!empty($tour['attraction_name'])) {
        $toursGrouped[$tourId]['attractions'][] = [
            'name' => $tour['attraction_name'],
            'description' => $tour['attraction_description'],
            'image' => $tour['attraction_image']
        ];
    }
}

?>

@extends('layouts.master')

@section('title', 'Túrák')

@section('header', 'Túrák')

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="header-container flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Túrák') }}
            </h2>
    </x-slot>

    <div class="container my-4">
    <div class="row">
    <?php if (!empty($toursGrouped)) { ?>
    <?php foreach ($toursGrouped as $tour) { ?>
        <div class="col-12 col-md-6 mb-4">
            <div class="card shadow-sm rounded">
                <div class="card-header text-white text-center py-3">
                    <h4><?= htmlspecialchars($tour['tour_name']) ?></h4>
                </div>
                <div class="card-body p-4 bg-light">
                    <h5 class="card-title text-secondary" style="color:#464c51 !important;"><?= htmlspecialchars($tour['tour_description'] ?? 'Nincs leírás') ?></h5>
                    <p class="card-text text-muted" style="color:#464c518a !important;">Felbecsült ár: <?= htmlspecialchars($tour['price'] ?? 'Nincs ár megadva') ?></p>

                    <h6 class="mt-3 text-dark">Látványosságok:</h6>
                    <?php if (!empty($tour['attractions'])) { ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($tour['attractions'] as $attraction) { ?>
                                <li class="list-group-item d-flex align-items-center py-3">
                                    <strong class="mr-2"><?= htmlspecialchars($attraction['name']) ?>:</strong>
                                    <div class="row w-100">
                                        <!-- Leírás oszlop -->
                                        <div class="col-md-6">
                                            <small class="text-muted" style="color:#464c51 !important;"><?= htmlspecialchars($attraction['description'] ?? 'Nincs leírás') ?></small>
                                        </div>
                                        <!-- Kép oszlop -->
                                        <div class="col-md-6 text-center">
                                            <img src="http://localhost/Turist/img/<?= !empty($attraction['image']) ? htmlspecialchars($attraction['image']) : 'default.jpg' ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($attraction['name']) ?>" style="max-height: 100px; object-fit: cover;">
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p class="text-muted">Nincsenek látványosságok a túrához.</p>
                    <?php } ?>
                    
                    <form method="POST" action="{{ url('/add-to-favorites') }}">
                        @csrf <!-- Laravel CSRF token -->
                        <input type="hidden" name="tour_id" value="{{ $tour['id'] }}"> 
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}"> 
                        
                        <button type="submit" class="btn btn-dark mt-3" 
                            @if(\App\Models\Tour::find($tour['id'])->isFavorite(Auth::id())) disabled @endif>
                            @if(\App\Models\Tour::find($tour['id'])->isFavorite(Auth::id())) 
                                Kedvencek között
                            @else
                                Tetszik
                            @endif
                        </button>
                    </form>

                </div>
                <div class="card-footer bg-secondary text-white text-center py-2">
                    <small>
                        <!-- Eltérő dátumformátumok megjelenítése -->
                        <?php 
                            $startDate = isset($tour['start_date']) ? date('Y-m-d', strtotime($tour['start_date'])) : 'Nincs kezdési dátum';
                            $endDate = isset($tour['end_date']) ? date('Y-m-d', strtotime($tour['end_date'])) : 'Nincs befejezési dátum';
                            echo "Túra időpontja: $startDate - $endDate";
                        ?>
                    </small>
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

@endsection