<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city  = $request->query('city');
        $units = $request->query('units', 'metric');

        // 1) Geocode city → coords
        $geo = Http::get('http://api.openweathermap.org/geo/1.0/direct', [
            'q'     => $city,
            'limit' => 1,
            'appid' => env('OPENWEATHER_API_KEY'),
        ])->json();

        if (empty($geo[0])) {
            return response()->json(['error'=>'Location not found'], 404);
        }

        $lat = $geo[0]['lat'];
        $lon = $geo[0]['lon'];

        // 2) One Call API for weather
        $weather = Http::get('https://api.openweathermap.org/data/2.5/onecall', [
            'lat'     => $lat,
            'lon'     => $lon,
            'units'   => $units,
            'exclude' => 'minutely,hourly,alerts',
            'appid'   => env('OPENWEATHER_API_KEY'),
        ])->json();

        return response()->json($weather);
    }
}
