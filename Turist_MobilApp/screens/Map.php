<?php
header('Content-Type: application/json');

// Google Maps API kulcs
$apiKey = "AIzaSyDVSOhkMOeIE1WAx1ifwwpsuKEVCnyYk2Q";

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

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

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

// **Válasz a ToursScreen.js-nek (koordináták visszaküldése)**
echo json_encode([
    'success' => true,
    'coordinates' => $coordinates
]);
?>
