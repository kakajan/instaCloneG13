<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(User::where('email', $request->email)->exists()){
            return response()->json([
                'message' => 'Email already exists',
                'stat' => 0
            ]);
        }

        $user = new user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'stat' => 1
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
    public function sendSMS($phone_number, $code)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $client = new \SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl");
            $user = "khadij";
            $pass = "M123455@";
            $fromNum = "+985000125475";
            $toNum = array($phone_number);
            $pattern_code = env("SMS_PATTERN", "u4fyhj92usyrulb");
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
}
