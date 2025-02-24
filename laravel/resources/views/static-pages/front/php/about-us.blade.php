<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="http://localhost/Turist/img/logo.png">
    <title>About us</title>
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
            {{ __('Rólunk') }}
        </h2>   
    </x-slot>

    <div class="about_us">
        <h1 class="text-2xl font-semibold text-black">Ecotrips</h1>
        <br>
        <p class="text-lg text-gray-700 mb-6">
            Üdvözlünk az <strong>Ecotrips</strong>-nél! Célunk, hogy segítsünk neked 
            felfedezni a természet szépségeit, megismerni lenyűgöző látványosságokat, 
            és egyedi túrákat létrehozni, amelyek örök emlékek maradnak.
        </p>

        <h2 class="text-2xl font-semibold text-black">Küldetésünk</h2>
        <p class="text-gray-700 mb-6">
            Hiszünk abban, hogy a természetjárás és a túrázás nemcsak kikapcsolódás, hanem egy életforma is. 
            Az <strong>Ecotrips</strong> segítségével saját túrákat tervezhetsz, felfedezheted a környezeted 
            rejtett kincseit, és megoszthatod élményeidet más természetkedvelőkkel.
        </p>

        <h2 class="text-2xl font-semibold text-black mb-3">Mit kínálunk?</h2>
        <ul class="list-disc list-inside text-gray-700 mb-6">
            <li>Könnyen használható túratervező eszköz</li>
            <li>Részletes információk látványosságokról</li>
            <li>Közösségi funkciók, hogy megoszthasd tapasztalataidat</li>
            <li>Környezettudatos utazási tippek</li>
        </ul>

        <h2 class="text-2xl font-semibold text-black mb-3">Csatlakozz hozzánk!</h2>
        <p class="text-gray-700">
            Fedezd fel a világot velünk, és hozd létre saját felejthetetlen túráidat!
            Legyél részese egy természetkedvelő közösségnek, és oszd meg kalandjaidat másokkal.
        </p>
        <img src="http://localhost/Turist/img/rolunk.jpg">

        <h2 class="text-2xl font-semibold text-black mb-3">Partnereink</h2>
        <ul class="list-disc list-inside text-gray-700 mb-6">
            <li>GreenTech Solutions</li>
            <li>Skyline Ventures</li>
            <li>BlueWave Innovations</li>
            <li>QuantumSoft</li>
            <li>Future Foods</li>
            <li>SmartEnergy Systems</li>
            <li>TechLink Industries</li>
        </ul>
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
</body>
</html>