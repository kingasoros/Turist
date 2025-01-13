<!DOCTYPE html>
<html>
<head>
    <title>Üdvözlet</title>
</head>
<body>
    <h1>Üdvözlünk, {{ $user->name }}!</h1>
    <p>Kérlek, kattints az alábbi linkre, hogy aktiváld a fiókodat:</p>
    <a href="{{ $activationLink }}">Aktivációs link</a>
    <p>Ha nem te regisztráltál, hagyd figyelmen kívül ezt az e-mailt.</p>
</body>
</html>
