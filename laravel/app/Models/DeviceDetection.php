<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceDetection extends Model
{
    use HasFactory;

    // Az adatbázis táblát, amit a modell reprezentál
    protected $table = 'device_detection'; 

    // Mivel nem minden mező automatikusan védett, itt meghatározzuk, hogy melyik mezőket lehet tömegesen kitölteni
    protected $fillable = [
        'ip_address', 
        'user_agent', 
        'device_type',
    ];
}
