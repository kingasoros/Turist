<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../bootstrap/app.php';

use Illuminate\Support\Facades\DB;

if (isset($_POST['attraction_name'])) {
    $attractionName = $_POST['attraction_name'];

    $attraction = DB::table('attractions')
                    ->where('name', $attractionName)
                    ->first(); 

    if ($attraction) {
        $_SESSION['selected_attraction'] = [
            'attractions_id' => $attraction->attractions_id,
            'city_name' => $attraction->city_name,
            'name' => $attraction->name,
            'description' => $attraction->description,
            'address' => $attraction->address,
            'created_by' => $attraction->created_by,
            'image' => $attraction->image,
            'created_at' => $attraction->created_at
        ];

        echo "Attraction stored in session.";
    } else {
        echo "Attraction not found.";
    }
} else {
    echo "No attraction name provided.";
}
?>