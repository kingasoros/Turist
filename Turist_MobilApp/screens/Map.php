<?php
header('Content-Type: application/json');

// Google Maps API kulcsod
$apiKey = "YOUR_GOOGLE_MAPS_API_KEY";

// JSON adat beolvasása
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON input',
        'json_error' => json_last_error_msg()
    ]);
    exit;
}

// Ellenőrzés: vannak-e címek
if (!isset($data['addresses']) || !is_array($data['addresses'])) {
    echo json_encode(['success' => false, 'message' => 'No valid addresses received']);
    exit;
}

// Geokódolás függvény
function getCoordinates($address, $apiKey) {
    $formattedAddress = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$formattedAddress}&key={$apiKey}";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if ($json['status'] === 'OK') {
        return [
            'lat' => $json['results'][0]['geometry']['location']['lat'],
            'lng' => $json['results'][0]['geometry']['location']['lng']
        ];
    } else {
        return ['error' => 'Failed to geocode: ' . $json['status']];
    }
}

// Címek átalakítása koordinátákra
$coordinates = [];
foreach ($data['addresses'] as $address) {
    $coords = getCoordinates($address, $apiKey);
    $coordinates[] = [
        'address' => $address,
        'coordinates' => $coords
    ];
}

// Visszaküldjük a koordinátákat JSON formátumban
echo json_encode([
    'success' => true,
    'message' => 'Coordinates retrieved successfully',
    'data' => $coordinates
]);
?>
