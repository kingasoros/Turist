<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');

$stmt = $conn->prepare("
    SELECT 
        t.*,
        a.name AS attraction_name,
        a.description AS attraction_description,
        a.image AS attraction_image
    FROM tours t
    LEFT JOIN tour_attractions ta ON t.tour_id = ta.tour_id
    LEFT JOIN attractions a ON ta.attractions_id = a.attractions_id
    WHERE EXISTS (
        SELECT 1 FROM turist_favorites tf WHERE tf.tour_id = t.tour_id
    )
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="http://localhost/Turist/img/logo.png">
    <title>Tours make</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/styles_1.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
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
            <div class="col-12 col-md-6 mb-4">
                <div class="card">
                <div class="card-header text-white text-center py-3">
                    <h4><?= htmlspecialchars($tour['tour_name']) ?> <i class="fas fa-heart text-danger"></i></h4>
                </div>
                    <div class="card-body">
                        <h5 class="card-title text-secondary"><?= htmlspecialchars($tour['tour_description'] ?? 'Nincs leírás') ?></h5>
                        <p class="card-text text-muted">Felbecsült ár: <?= htmlspecialchars($tour['price'] ?? 'Nincs ár megadva') ?></p>

                        <h6 class="mt-3 text-dark">Látványosságok:</h6>
                        <?php if (!empty($tour['attractions'])) { ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($tour['attractions'] as $attraction) { ?>
                                    <li class="list-group-item d-flex align-items-center py-3">
                                        <strong class="mr-2"><?= htmlspecialchars($attraction['name']) ?>:</strong>
                                        <div class="row w-100">
                                            <!-- Leírás oszlop -->
                                            <div class="col-md-6">
                                                <small class="text-muted"><?= htmlspecialchars($attraction['description'] ?? 'Nincs leírás') ?></small>
                                            </div>
                                            <!-- Kép oszlop -->
                                            <div class="col-md-6 text-center">
                                                <?php if (!empty($attraction['image'])) { ?>
                                                    <img src="http://localhost/Turist/img/<?= htmlspecialchars($attraction['image']) ?>" alt="<?= htmlspecialchars($attraction['name']) ?>">
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-muted">Nincsenek látványosságok a túrához.</p>
                        <?php } ?>
                        <div class="favorites_buttons">
                            <a href="#" class="btn btn-dark mt-3">Delete from my list</a>
                        </div>
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
</body>
</html>