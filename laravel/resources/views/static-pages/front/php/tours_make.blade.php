<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');

// Fetch attractions for selection
$attractionsQuery = $conn->prepare("SELECT * FROM attractions ORDER BY city_name, name");
$attractionsQuery->execute();
$attractions = $attractionsQuery->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for creating a new tour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tourName = $_POST['tour_name'];
    $tourDescription = $_POST['tour_description'];
    $price = $_POST['price'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $status = $_POST['status']; 
    $selectedAttractions = $_POST['attractions'];

    $insertTour = $conn->prepare("INSERT INTO tours (tour_name, tour_description, price, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?)");
    $insertTour->execute([$tourName, $tourDescription, $price, $startDate, $endDate, $status]);
    $tourId = $conn->lastInsertId();

    $order = 1;
    foreach ($selectedAttractions as $attractionId) {
        $insertAttraction = $conn->prepare("INSERT INTO tour_attractions (tour_id, attractions_id, attraction_order) VALUES (?, ?, ?)");
        $insertAttraction->execute([$tourId, $attractionId, $order]);
        $order++;
    }

    echo "Túra sikeresen létrehozva!";
}

// Fetch tours and their associated attractions
$stmt = $conn->prepare("
    SELECT 
        t.*,
        a.name AS attraction_name,
        a.description AS attraction_description,
        a.image AS attraction_image
    FROM tours t
    LEFT JOIN tour_attractions ta ON t.tour_id = ta.tour_id
    LEFT JOIN attractions a ON ta.attractions_id = a.attractions_id
    WHERE t.status = 'private'  
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
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Új túra létrehozása') }}
        </h2>   
    </x-slot>
    <div class="container my-4 tours_make-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tours.store') }}" method="POST">
    @csrf
        <div class="mb-3">
            <label for="tour_name" class="form-label">Túra neve</label>
            <input type="text" class="form-control tours_input" id="tour_name" name="tour_name" required>
        </div>
        <div class="mb-3">
            <label for="tour_description" class="form-label">Leírás</label>
            <textarea class="form-control tours_input" id="tour_description" name="tour_description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Ár</label>
            <input type="number" class="form-control tours_input" id="price" name="price" step="0.01" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Kezdési dátum</label>
                <input type="date" class="form-control tours_input" id="start_date" name="start_date" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Befejezési dátum</label>
                <input type="date" class="form-control tours_input" id="end_date" name="end_date" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Státusz</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_private" value="private" checked>
                    <label class="form-check-label" for="status_private">Privát</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_public" value="public">
                    <label class="form-check-label" for="status_public">Publikus</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Látványosságok</label>
            <div class="row">
                <?php foreach ($attractions as $attraction) { ?>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= $attraction['attractions_id'] ?>" id="attraction_<?= $attraction['attractions_id'] ?>" name="attractions[]">
                            <label class="form-check-label" for="attraction_<?= $attraction['attractions_id'] ?>">
                                <?= htmlspecialchars($attraction['name']) ?> (<?= htmlspecialchars($attraction['city_name']) ?>)
                            </label>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mentés</button>
    </form>
</div>

<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" style="margin-left:310px;">Privát túrák</h2>

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
                            <form action="{{ route('tours.destroy', $tour['id']) }}" method="POST" onsubmit="return confirm('Biztos, hogy törölni szeretnéd ezt a túrát?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3">Törlés</button>
                            </form>
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
