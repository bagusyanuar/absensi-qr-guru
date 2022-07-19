<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);
        if (!$token = auth('api')->setTTL(null)->attempt($credentials)) {
            return $this->jsonResponse('Username dan Password Tidak Cocok', 401);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return $this->jsonResponse('success', 200, [
            'access_token' => $token,
            'type' => 'Bearer'
        ]);
    }
}
