<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\PostController;

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::resource('/users', UserController::class);
Route::middleware(['auth:api'])->resource('/posts', PostController::class);
Route::get(
    'testSMS',
    function () {
        function sendSMS($phone_number, $code)
        {
            ini_set("soap.wsdl_cache_enabled", "0");
            try {
                $client = new \SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
                $user = "khadij";
                $pass = "M123455@";
                $fromNum = "+985000125475";
                $toNum = array($phone_number);
                $pattern_code = env("SMS_PATTERN", "zm1iaar92adcesj");
                $input_data = array("code" => $code);
                $sent = $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
                if ($sent) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        sendSMS('09028427527', '4525');
    }
);

