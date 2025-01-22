<?php
use Illuminate\Support\Facades\DB;

/**
 * Function detects ip address of the request.
 * It returns valid ip address or unknown word.
 *
 * @return string
 */
function getIpAddress(): string
{

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = "unknown";
    }

    return $ip;
}

function insertIntoLog(string $userAgent, string $ipAddress, string $deviceType, string $country, bool $proxy, string $isp): void
{
    DB::table('log')->insert([
        'user_agent' => $userAgent,
        'ip_address' => $ipAddress,
        'country' => $country,
        'proxy' => $proxy,
        'device_type' => $deviceType,
        'isp' => $isp,
        'date_time' => now(),
    ]);
}

function getLogData(): array
{
    return DB::table('log')
        ->select(
            'id_log',
            'user_agent',
            'ip_address',
            'country',
            DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y %H:%i:%s') AS date"),
            'device_type',
            'proxy',
            'isp'
        )
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();
}

/**
 * Performs cURL session and returns the transfer as a string
 *
 * @param $url
 * @return string
 */
function getCurlData($url): string
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

