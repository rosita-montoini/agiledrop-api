<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Auth\Jobs\LoginJob;
use App\Domains\Auth\Jobs\LogoutJob;
use App\Domains\User\Jobs\ValidateAddUserInputJob;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $requestParams = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        try {
            (new ValidateAddUserInputJob($requestParams))->handle(new \App\Domains\User\AddUserValidator);
            
        } catch (ValidationException $e) {

            return response()->json(['errors' => $e->errors()], 422);
        }

        $loginResponse = (new LoginJob($requestParams['email'], $requestParams['password']))->handle();

        return $loginResponse;
    }
    
    public function logout(Request $request)
    {
        $logoutResponse = (new LogoutJob($request->user()))->handle();

        return $logoutResponse;
    }
}
