<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    public function register(Request $request, $ref_code = null)
    {
        $validate = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if($validate) {
            $credentials = [
                'personal' => [
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    
                ],
                'referral' => [
                    'new_code' => [
                        'code' => Str::uuid(),
                    ],
                    'ref_code' => $ref_code,
                ],
                'wallet' => [
                    'wallet_address' => mt_rand(1000000000, 9999999999),
                    'wallet_bal' => '0',
                    'isLimit' => (bool)1,
                ],
                'document' => [
                    'name' => '',
                    'isUpload' => (bool)0
                ]
            ];
            
            $response = $this->authService->register($credentials);
            return response()->JSON($response);
        }
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if($validate) {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            $response = $this->authService->login($credentials);
            return response()->JSON($response);
        }
    }
}
