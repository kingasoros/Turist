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
    const sectors = <?= json_encode(array_map(fn($attraction) => ['color' => '', 'label' => $attraction['name']], $attractions)); ?>;
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions</title>
    <link rel="icon" type="image/x-icon" href="http://localhost/Turist/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/index.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
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

    </x-slot>

    <?php $selectedName = session('selectedName', ''); ?>

    <div class="content-container">
    <div class="wheel-box_first">
        <?php if (!empty($attractions)){ ?>
            <?php foreach ($attractions as $attraction){ ?>
                <div class="card mb-3" style=" margin:5px; background-color:#002f3b; color:#fff;" data-id="<?= htmlspecialchars($attraction['attractions_id']) ?>">
                    <div class="row g-0">
                        <div class="col-md-4">
                                <img src="http://localhost/Turist/img/<?= !empty($attraction['image']) ? htmlspecialchars($attraction['image']) : 'default.jpg' ?>" alt="<?= htmlspecialchars($attraction['name']) ?>" style="height:100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title" style="font-weight:bold; font-size:20px;"><?= htmlspecialchars($attraction['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($attraction['description']) ?></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['address']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['created_by']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['city_name']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['type']) ?></small></p>
                                <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['interest']) ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p>Nincsenek elérhető adatok.</p>
        <?php } ?>
    </div>
            <div id="wheel-box_second">
                <h3 id="wheelMessage">Túl sok látványosság, és nem tudsz dönteni? Bízd a szerencsére! Pörgesd meg a kereket, és fedezz fel valami izgalmasat!</h3>
                <div id="wheelOfFortune">
                    <canvas id="wheel" width="500" height="500"></canvas>
                    <div id="spin">SPIN</div>
                </div>
                <h4 id="selectedWord" onclick="copyToClipboard()"></h4>
            </div>
        </div>

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

<script>
    const searchInput = document.getElementById('search');
    const resultsList = document.getElementById('results');
    
    searchInput.addEventListener('input', function () {
    const query = this.value;

    // AJAX kérés a Laravel API-hoz a kereséshez
    fetch(`/api/search?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';

            // A találatok megjelenítése
            data.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item.name; 

                // Kattintás esemény a találat kiválasztásához
                li.addEventListener('click', function () {
                    const selectedName = item.name;

                    // AJAX kérés a kiválasztott név mentésére a session-ba
                    fetch('/api/saveSelectedName', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ name: selectedName }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateAttractionsOrder(selectedName);
                        }
                    });
                });

                resultsContainer.appendChild(li);
            });
        });
});

// A látványosságok sorrendjének frissítése
function updateAttractionsOrder(selectedName) {
    fetch(`/api/getAttractions?selectedName=${encodeURIComponent(selectedName)}`)
        .then(response => response.json())
        .then(data => {
            const attractionsContainer = document.querySelector('.wheel-box_first');
            attractionsContainer.innerHTML = ''; 

            data.forEach(attraction => {
                const card = document.createElement('div');
                card.className = 'card mb-3';
                card.style = 'margin:5px; background-color:#002f3b; color:#fff;';
                card.innerHTML = `
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="http://localhost/Turist/img/${attraction.image || '..'}" alt="${attraction.name}" style="height:100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">${attraction.name}</h5>
                                <p class="card-text">${attraction.description}</p>
                                <p class="card-text"><small class="text-muted">${attraction.address}</small></p>
                                <p class="card-text"><small class="text-muted">${attraction.created_by}</small></p>
                                <p class="card-text"><small class="text-muted">${attraction.city_name}</small></p>
                                <p class="card-text"><small class="text-muted">${attraction.type}</small></p>
                                <p class="card-text"><small class="text-muted">${attraction.interest}</small></p>
                            </div>
                        </div>
                    </div>
                `;
                attractionsContainer.appendChild(card);
            });
        });
}


// Kattintás kívül, hogy eltüntesse a keresési találatokat
document.addEventListener('click', function (event) {
    const searchInput = document.getElementById('search');
    const resultsContainer = document.getElementById('results');

    if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
        resultsContainer.innerHTML = '';  // Kiürítjük a találatokat
    }
});

// Városok, típusok és érdeklődési körök lista betöltése
// fetch('/api/cities')
//     .then(response => response.json())
//     .then(cities => {
//         const citySelect = document.getElementById('city');
//         cities.forEach(city => {
//             const option = document.createElement('option');
//             option.value = city;
//             option.textContent = city;
//             citySelect.appendChild(option);
//         });
//     });

fetch('/api/types')
    .then(response => response.json())
    .then(types => {
        const typeSelect = document.getElementById('type');
        types.forEach(type => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = type;
            typeSelect.appendChild(option);
        });
    });

fetch('/api/interests')
    .then(response => response.json())
    .then(interests => {
        const interestSelect = document.getElementById('interest');
        interests.forEach(interest => {
            const option = document.createElement('option');
            option.value = interest;
            option.textContent = interest;
            interestSelect.appendChild(option);
        });
    });


    document.getElementById('apply-filters').addEventListener('click', function () {
    const city = document.getElementById('city').value;
    const type = document.getElementById('type').value;
    const interest = document.getElementById('interest').value;

    const data = {
        city: city,
        type: type,
        interest: interest,
    };

    console.log('Küldött JSON:', JSON.stringify(data));

    // requests.js
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('http://127.0.0.1:8000/api/saveFilterStatistics', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            city: '',
            type: 'Történelmi helyek',
            interest: '',
        }),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });

    // Szűrt adatok lekérése az adatbázisból
    fetch(`/api/getAttractionsByFilters?city=${encodeURIComponent(city)}&type=${encodeURIComponent(type)}&interest=${encodeURIComponent(interest)}`)
        .then(response => response.json())
        .then(data => {
            const attractionsContainer = document.querySelector('.wheel-box_first');
            attractionsContainer.innerHTML = ''; // Az előző találatok törlése

            // Kártyák létrehozása az adatok megjelenítéséhez
            data.forEach(attraction => {
                const card = document.createElement('div');
                card.className = 'card mb-3';
                card.style = 'margin:5px; background-color:#002f3b; color:#fff;';
                card.innerHTML = `
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="http://localhost/Turist/img/${attraction.image || '..'}" alt="${attraction.name}" style="height:100%; width:100%;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">${attraction.name}</h5>
                                <p class="card-text">${attraction.description}</p>
                                <p class="card-text"><small class="text-muted">Cím: ${attraction.address}</small></p>
                                <p class="card-text"><small class="text-muted">Készítő: ${attraction.created_by}</small></p>
                                <p class="card-text"><small class="text-muted">Város: ${attraction.city_name}</small></p>
                                <p class="card-text"><small class="text-muted">Típus: ${attraction.type}</small></p>
                                <p class="card-text"><small class="text-muted">Érdeklődés: ${attraction.interest}</small></p>
                            </div>
                        </div>
                    </div>
                `;
                attractionsContainer.appendChild(card);
            });
        })
        .catch(error => console.error('Lekérési hiba:', error));
});


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
fetch('/store-device-data')
        .then(response => response.json())
        .then(data => {
            if (data.deviceType === 'Mobile') {
                const footer = document.querySelector('.footer__container');
                const appText = document.createElement('a');
                appText.classList.add('app__text');
                appText.href = 'https://example.com';
                appText.textContent = 'Töltsd le az applikációt!';
                footer.appendChild(appText);
            }
        })
        .catch(error => console.error('Error:', error));
</script>
</body>
</html>