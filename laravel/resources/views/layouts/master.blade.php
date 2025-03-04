<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    <title>@yield('title', 'Alapértelmezett cím')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    @stack('head')
</head> 
<body>

@yield('content')

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

</body>
</html>
