<?php
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

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecotrips</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>    
    <!-- Slideshow container -->
    <div class="slideshow-container">

        <!-- Full-width images with number and caption text -->
        <div class="mySlides fade">
        <div class="numbertext">1 / 3</div>
        <img src="../img/slider.jpg" style="width:100%">
        <div class="text">
            <h1>Barangolj a Duna és Tisza között!</h1>
            <p>Természetvédelmi területek, kastélyok és hangulatos falvak csodái egy helyen.</p>
        </div>
        </div>

        <div class="mySlides fade">
        <div class="numbertext">2 / 3</div>
        <img src="../img/slider1.jpg" style="width:100%">
        <div class="text">
            <h1>Fedezd fel Vajdaság rejtett kincseit!</h1>
            <p>Történelmi városok, festői tájak és gasztronómiai élmények várnak rád.</p>
        </div>
        </div>

        <div class="mySlides fade">
        <div class="numbertext">3 / 3</div>
        <img src="../img/slider2.jpg" style="width:100%">
        <div class="text">
            <h1>Kóstolj bele Vajdaság ízeibe!</h1>
            <p>Hagyományos ételek, borászatok és helyi piacok különleges élményt nyújtanak.</p>
        </div>
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>

    <div class="info-blocks">
        <div class="info-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
            </svg>
            Fedezd fel a világ csodáit!
        </div>
        <div class="info-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-brightness-alt-high-fill" viewBox="0 0 16 16">
                <path d="M8 3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 3m8 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5m-13.5.5a.5.5 0 0 0 0-1h-2a.5.5 0 0 0 0 1zm11.157-6.157a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m-9.9 2.121a.5.5 0 0 0 .707-.707L3.05 5.343a.5.5 0 1 0-.707.707zM8 7a4 4 0 0 0-4 4 .5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5 4 4 0 0 0-4-4"/>
            </svg>
            Kiváló túrák minden szinthez.
        </div>
        <div class="info-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
            </svg>
            Helyi élmények, autentikus túrák.
        </div>
        <div class="info-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
            </svg>
            Csoportos túrák.
        </div>
    </div>

    <div class="card text-center">
        <div class="card-header">
            Turista túrák
        </div>
        <div class="card-body">
            <h5 class="card-title">Fedezd fel a világ legjobb túráit!</h5>
            <p class="card-text">Túrák, amelyek minden érzékszervedet megérintik. Akár a hegyek csúcsát akarod meghódítani, 
                akár a tengerparti tájakat szeretnéd felfedezni, mi segítünk megtalálni a tökéletes utat. Szakértő túravezetők 
                kísérnek végig minden útvonalon, miközben autentikus helyi élményekkel gazdagodhatsz. Élvezd a természet szépségeit, 
                miközben a legjobb helyekre kalauzolunk el, hogy felejthetetlen kalandokat élj át! Indulj el velünk, és találj rá a legszebb túrákra!</p>
        </div>
    </div>

    <h2 class="text-2xl font-semibold text-white mb-3 partners">Partnereink</h2>
    <ul class="partner-list mb-6">
        <li>GreenTech Solutions</li>
        <li>Skyline Ventures</li>
        <li>BlueWave Innovations</li>
        <li>QuantumSoft</li>
        <li>Future Foods</li>
        <li>SmartEnergy Systems</li>
        <li>TechLink Industries</li>
    </ul>

    <section class="gallery">
        <div class="gallery-images">
            <a class="" href="/attractions">
                <img src="http://localhost/Turist/img/home_img0.jpg" alt="Túra kép 1" title="Történelmi helyek">
            </a>
            <a class="" href="/attractions">
                <img src="http://localhost/Turist/img/home_img1.jpg" alt="Túra kép 2" title="Természeti látnivalók">
            </a>
            <a class="" href="/attractions">
                <img src="http://localhost/Turist/img/home_img2.jpg" alt="Túra kép 3" title="Családbarát">
            </a>
            <a class="" href="/attractions">
                <img src="http://localhost/Turist/img/home_img3.jpg" alt="Túra kép 4" title="Szórakoztató helyek">
            </a>
        </div>
    </section>

    <footer>
        <div class="footer__div">
            <div class="footer__container">
                <ul>
                    <li>Ecotrips Kft.</li>
                    <li>Minta utca 12.,</li>
                    <li>1101 Budapest,</li>
                    <li>Magyarország</li>
                    <li>+36 30 123 4567</li>
                    <li>ugyfelszolgalat@mintaceg.hu</li>
                </ul>   
            </div>
            <div class="footer__container footer__app">
                @php
                    $userAgent = request()->header('User-Agent');
                    if (preg_match('/mobile/i', $userAgent)) {
                        echo '<a class="app__text" href="https://192.168.1.6:8081">Töltsd le az applikációt!</a>';
                    }
                @endphp
                <p>&copy; {{ date('Y') }} My Application. All rights reserved.</p>
            </div>
        </div>
    </footer> 
<script>
    let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}

function updateSlides() {
    let slides = document.querySelectorAll(".mySlides img");

    // Csak akkor futtassuk, ha a slides tömb legalább 3 elemet tartalmaz
    if (slides.length >= 3) {
        if (window.innerWidth <= 768) {
            slides[0].src = "../img/slider-mobile.jpg";
            slides[1].src = "../img/slider1-mobile.jpg";
            slides[2].src = "../img/slider2-mobile.jpg";
        } else {
            slides[0].src = "../img/slider.jpg";
            slides[1].src = "../img/slider1.jpg";
            slides[2].src = "../img/slider2.jpg";
        }
    }
}

// Futtatás betöltéskor és ablakméret változáskor
window.addEventListener("load", updateSlides);
window.addEventListener("resize", updateSlides);

</script>
</x-app-layout>
</body>
</html>