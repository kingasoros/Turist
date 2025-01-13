<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');

$stmt = $conn->prepare("SELECT * FROM attractions");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selectedName = session('selectedName', '');  // Laravel session metódus
$selectedAttraction = null;

// Ha a selectedName nem üres, módosítjuk az attractions listát
if (!empty($selectedName)) {
    $stmt = $conn->prepare("SELECT * FROM attractions WHERE name = :name LIMIT 1");
    $stmt->bindParam(':name', $selectedName, PDO::PARAM_STR);
    $stmt->execute();
    $selectedAttraction = $stmt->fetch(PDO::FETCH_ASSOC);

    // A kiválasztott látványosságot helyezzük az első helyre
    $attractions = array_filter($attractions, function ($attraction) use ($selectedName) {
        return $attraction['name'] !== $selectedName;
    });

    // Tegyük az első helyre a kiválasztott látványosságot
    if ($selectedAttraction) {
        array_unshift($attractions, $selectedAttraction);
    }
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
    </x-slot>

    <?php $selectedName = session('selectedName', ''); ?>

        <div class="content-container">
            <div class="wheel-box_first">
                <?php if (!empty($attractions)){ ?>
                    <?php foreach ($attractions as $attraction){ ?>
                        <div class="card mb-3" style=" margin:5px; background-color:#002f3b; color:#fff;" data-id="<?= htmlspecialchars($attraction['attractions_id']) ?>">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <?php if (!empty($attraction['image'])){ ?>
                                        <img src="http://localhost/Turist/img/<?= htmlspecialchars($attraction['image']) ?>" alt="<?= htmlspecialchars($attraction['name']) ?>" style="height:100%;">
                                    <?php }else{ ?>
                                        <img src=".." class="img-fluid rounded-start" alt="...">
                                    <?php } ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-weight:bold; font-size:20px;"><?= htmlspecialchars($attraction['name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($attraction['description']) ?></p>
                                        <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['address']) ?></small></p>
                                        <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['created_by']) ?></small></p>
                                        <p class="card-text"><small class="text-muted"><?= htmlspecialchars($attraction['city_name']) ?></small></p>
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
                    // Ha mobil eszköz, akkor megjelenítjük a linket
                    echo '<a class="app__text" href="https://example.com">Töltsd le az applikációt!</a>';
                } else {
                    // Ha asztali gép, nem jelenítünk meg semmit
                    echo '';
                }
            ?>
            <p>&copy; {{ date('Y') }} My Application. All rights reserved.</p>
        </div>
    </footer>
<script>
        document.getElementById('search').addEventListener('input', function () {
    const query = this.value;

    // AJAX kérés a Laravel API-hoz
    fetch(`/api/search?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';

            // A találatok megjelenítése
            data.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item.name;  // 'name' mező az attractions táblából

                // Kattintás esemény a találat kiválasztásához
                li.addEventListener('click', function () {
                    const selectedName = item.name;

                    // AJAX kérés a kiválasztott név mentésére a session-ba
                    fetch('/api/saveSelectedName', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Laravel CSRF token
                        },
                        body: JSON.stringify({ name: selectedName }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // console.log('Név mentve:', selectedName);

                            // Az oldalon a mentett név frissítése
                            const savedNameElement = document.querySelector('p');
                            // savedNameElement.textContent = `Mentett név: ${selectedName}`;

                            // A látványosságok sorrendjének frissítése AJAX segítségével
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
            // A DOM frissítése az új sorrenddel
            const attractionsContainer = document.querySelector('.wheel-box_first');
            attractionsContainer.innerHTML = ''; // Töröljük az eddigi tartalmat

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
        resultsContainer.innerHTML = ''; // Eltünteti a találatokat, ha kívül kattintanak
    }
});

function copyToClipboard() {
    // Az elem, aminek a szövegét másolni szeretnénk
    var text = document.getElementById("selectedWord").innerText;

    // Létrehozunk egy ideiglenes input mezőt a másoláshoz
    var tempInput = document.createElement("input");
    document.body.appendChild(tempInput);
    tempInput.value = text;  // Beállítjuk az input mező értékét a szövegre
    tempInput.select();  // Kiválasztjuk az input mezőt
    document.execCommand("copy");  // Másolás

    // Eltávolítjuk az ideiglenes input mezőt
    document.body.removeChild(tempInput);

    // Informáljuk a felhasználót (opcionális)
    alert("Szöveg másolva: " + text);
}

</script>
</body>
</html>
