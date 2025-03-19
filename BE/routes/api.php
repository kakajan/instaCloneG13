<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\API\UserController;

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
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
        function sendSMS($phone_number, $code)
        {
            ini_set("soap.wsdl_cache_enabled", "0");
            try {
                $client = new \SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
                $user = "khadij";
                $pass = "M123455@";
                $fromNum = "+983000505";
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
