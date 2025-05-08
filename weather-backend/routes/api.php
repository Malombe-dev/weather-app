use App\Services\WeatherService;

Route::get('weather/{city}', function ($city, WeatherService $weatherService) {
    return response()->json($weatherService->getWeatherByCity($city));
});

Route::get('forecast/{city}', function ($city, WeatherService $weatherService) {
    return response()->json($weatherService->getForecastByCity($city));
});
