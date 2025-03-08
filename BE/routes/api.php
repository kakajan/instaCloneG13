<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\API\UserController;

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::resource('/users', UserController::class);
Route::middleware(['auth:api'])->resource('/posts', PostController::class);
Route::get(
    'testSMS',
    function () {
        $client = new \GuzzleHttp\Client([
            'verify' => false // Disable SSL certificate verification
        ]);

        $headers = [
            'apikey' => 'OWU1ZTVkNmYtZWQ3Ny00YTQwLTg4MTctYTRkNzhjZjhkMjUzMThlOTUxYTU0Y2EwOWZmZDBlMWU4M2Y2YjcwMmMxNzE=',
            'accept' => '*/*',
            'Content-Type' => 'application/json',
        ];

        $body = '{
            "code": "zdpp7kyvuuh0bvt",
            "sender": "+983000505",
            "recipient": "+989119777534",
            "variable": {
                "order_id": "45454",
                "table_id": "1"
            }
        }';

        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://api2.ippanel.com/api/v1/sms/pattern/normal/send', $headers, $body);
        $response = $client->sendAsync($request)->wait();

        echo $response->getBody();
    }
);
