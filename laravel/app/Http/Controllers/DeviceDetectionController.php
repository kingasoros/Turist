<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MobileDetect;

class DeviceDetectionController extends Controller
{
    public function storeDeviceData(Request $request)
    {
        $detect = new MobileDetect;
        $deviceType = $detect->isMobile() ? 'Mobile' : 'Desktop';

        // IP cím és User-Agent lekérése
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Adatok mentése az adatbázisba
        DeviceDetection::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'device_type' => $deviceType,
        ]);

        // JSON válasz visszaküldése
        return response()->json([
            'deviceType' => $deviceType,
        ]);
    }

}
