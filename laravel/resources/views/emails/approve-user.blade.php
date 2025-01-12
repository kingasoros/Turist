<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiók Aktiválása</title>
</head>
<body>
    <p>Kedves {{ $user->name }},</p>

    <p>Az alábbi linken keresztül tudod aktiválni a fiókodat:</p>
    
    <a href="{{ $approvalLink }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Aktiváld a fiókodat
    </a>

    <p>Ha nem regisztráltál, kérlek ne vedd figyelembe ezt az üzenetet.</p>
    
    <p>Köszönjük, hogy velünk regisztráltál!</p>
</body>
</html>
