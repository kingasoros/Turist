<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');

$stmt = $conn->prepare("SELECT * FROM attractions");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selectedName = session('selectedName', '');  
$selectedAttraction = null;

if (!empty($selectedName)) {
    $stmt = $conn->prepare("SELECT * FROM attractions WHERE name = :name LIMIT 1");
    $stmt->bindParam(':name', $selectedName, PDO::PARAM_STR);
    $stmt->execute();
    $selectedAttraction = $stmt->fetch(PDO::FETCH_ASSOC);

    $attractions = array_filter($attractions, function ($attraction) use ($selectedName) {
        return $attraction['name'] !== $selectedName;
    });

    if ($selectedAttraction) {
        array_unshift($attractions, $selectedAttraction);
    }
}

use Detection\MobileDetect;

$ipAddress = getIpAddress();
$ipAddress = $ipAddress === "127.0.0.1" ? "119.14.26.0" : $ipAddress;

$cookie = $_COOKIE["visited"] ?? "";

$detect = new MobileDetect();

if (!isset($_COOKIE['VISITED'])) {
    $apiFields = "country,proxy,isp"; 
    $response = getCurlData("http://ip-api.com/json/$ipAddress?fields=$apiFields");
    $apiData = json_decode($response, true);

    $userAgent = $detect->getUserAgent();
    $deviceType = $detect->isMobile() ? ($detect->isTablet() ? "tablet" : "phone") : "computer";
    $country = $apiData['country'] ?? "unknown";
    $proxy = $apiData['proxy'] ?? false;
    $isp = $apiData['isp'] ?? "unknown";

    insertIntoLog($userAgent, $ipAddress, $deviceType, $country, $proxy, $isp);
    setcookie("VISITED", "YES", time() + 10);
}

?>
<script>
    const sectors = @json(
        collect($attractions)
            ->shuffle() // Véletlenszerű sorrendbe rakja
            ->take(10) // Csak 10 elemet választ ki
            ->map(fn($attraction) => ['color' => '', 'label' => $attraction['name']])
            ->values() );
</script>

@extends('layouts.master')

@section('title', 'Látványosságok')

@section('header', 'Látványosságok')

@push('head')
    <script src="{{ asset('js/index.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="header-container flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Látványosságok') }}
            </h2>
            <div class="search-container">
                <input type="text" id="search" class="search-input" placeholder="Keresés...">
                <ul id="results"></ul>
            </div>
        </div>
        <div class="filters-container">
            <label for="city"></label>
            <select id="city" class="filter-input">
                <option value="">Város</option>
                <!-- Városok listája itt fog megjelenni -->
            </select>

            <label for="type"></label>
            <select id="type" class="filter-input">
                <option value="">Típus</option>
                <!-- Típusok listája itt fog megjelenni -->
            </select>

            <label for="interest"></label>
            <select id="interest" class="filter-input">
                <option value="">Érdeklődés</option>
                <!-- Érdeklődési körök listája itt fog megjelenni -->
            </select>

            <button class="search__button" id="apply-filters">Keresés</button>
        </div>

        <h3 id="wheelMessage">
            Túl sok látványosság, és nem tudsz dönteni? Bízd a szerencsére! Pörgesd meg a kereket, és fedezz fel valami izgalmasat!<br>
            <button id="toggle-wheel" class="toggle-button">▼</button>
        </h3>

        <div id="wheel-box_second">
            <div id="wheelOfFortune">
                <canvas id="wheel" width="500" height="500"></canvas>
                <div id="spin">SPIN</div>
            </div>
            <h4 id="selectedWord" onclick="copyToClipboard()"></h4>
        </div>
    </x-slot>

    <?php $selectedName = session('selectedName', ''); ?>

    <div class="row card-group">
        <?php if (!empty($attractions)){ ?>
            <?php foreach ($attractions as $attraction){ ?>
                <div class=" mb-3 col-6 col-md-6 card-group_body" style="margin:5px; background-color:#002f3b; color:#fff;" data-id="<?= htmlspecialchars($attraction['attractions_id']) ?>">
                    <div class="row g-0">
                        <div class="col-md-4 container-img">
                            <img src="http://localhost/Turist/img/<?= !empty($attraction['image']) ? htmlspecialchars($attraction['image']) : 'default.jpg' ?>" alt="<?= htmlspecialchars($attraction['name']) ?>" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title" style="font-weight:bold; font-size:20px;"><?= htmlspecialchars($attraction['name']) ?><br>
                                    <?= htmlspecialchars($attraction['open']) ?>-<?= htmlspecialchars($attraction['closed']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($attraction['description']) ?></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['address']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['created_by']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['city_name']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['type']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['interest']) ?></small></p>
                                <p class="card-text">Belépő ára: <?= htmlspecialchars($attraction['price']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p>Nincsenek elérhető adatok.</p>
        <?php } ?>
    </div>
    
    

    </x-app-layout>
    <script>
    
    //copying
    function copyToClipboard() {
        var text = document.getElementById("selectedWord").innerText;
    
        var tempInput = document.createElement("input");
        document.body.appendChild(tempInput);
        tempInput.value = text;  
        tempInput.select();  
        document.execCommand("copy");  
    
        document.body.removeChild(tempInput);
    
        alert("Szöveg másolva: " + text);
    }
    

    </script>
@endsection