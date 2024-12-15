<?php
include base_path('resources/views/static-pages/front/php/db_conn.php');

$stmt = $conn->prepare("SELECT name FROM attractions ORDER BY RAND() LIMIT 10");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
    const sectors = <?= json_encode(array_map(fn($attraction) => ['color' => '', 'label' => $attraction['name']], $attractions)); ?>;
</script>
<?php

$stmt = $conn->prepare("SELECT * FROM attractions");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
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

    <style>
        .text-muted {
            color: #ffffffc4 !important;
        }
    </style>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Látványosságok') }}
            </h2>
        </x-slot>
        <div>
            <input type="text" id="search" placeholder="Keresés...">
            <ul id="results"></ul>
        </div>
        <div class="content-container">
            <div class="wheel-box_first">
                <?php if (!empty($attractions)){ ?>
                    <?php foreach ($attractions as $attraction){ ?>
                        <div class="card mb-3" style=" margin:5px; background-color:#002f3b; color:#fff;">
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
                <h4 id="selectedWord"></h4> 
            </div>
        </div>

    </x-app-layout>
    <script>
        const searchInput = document.getElementById('search');
        const resultsList = document.getElementById('results');

        searchInput.addEventListener('input', async function () {
            const query = searchInput.value;

            if (query.length < 3) {
                resultsList.innerHTML = '';
                return;
            }

            const response = await fetch(`/search?query=${query}`);
            const results = await response.json();

            resultsList.innerHTML = results.map(result => `<li>${result.name}</li>`).join('');
        });
    </script>
</body>

</html>
