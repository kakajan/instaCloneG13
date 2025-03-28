<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\API\UserController;

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/users', UserController::class);
Route::middleware(['auth:api'])->resource('/posts', PostController::class);
Route::post('sendVerify', function (Request $request) {
    $code = rand(1000, 9999);
    if ($user = User::where('mobile', $request->username)->first()) {
        $user->password = $code;
        $user->save();
    } else {
        $user = new User();
        $user->mobile = $request->username;
        $user->password = $code;
        $user->save();
    }
    return $user->sendVerifyCode($code, $request->username);
    // if ($user->sendVerifyCode($code, $request->username)) {

    //     return response()->json(['status' => true], 200);
    // } else {
    //     return response()->json(['status' => false, 'message' => 'sms failed'], 400);
    // }
});
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
