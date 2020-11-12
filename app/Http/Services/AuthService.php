<?php
namespace App\Http\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Document;
use App\Models\ReferralCode;

class AuthService
{
    
    public function register(array $credentials)
    {
        $user = User::create($credentials['personal']);
        $wallet = $user->wallets()->create($credentials['wallet']);
        $referral_code = $user->referral_codes()->create($credentials['referral']['new_code']);
        $document = $user->documents()->create($credentials['document']);

        $ref_code = ReferralCode::where('code', $credentials['referral']['ref_code'])->first();
        if($ref_code) {
            $earn = 1000;
            $remarks = 'This is a referral transaction';
            $user_wallet = Wallet::where('user_id', $ref_code->user_id)->first();
            $new_wallet_bal = ($user_wallet->wallet_bal + $earn);
            $updateWallet = $user_wallet->update(['wallet_bal' => $new_wallet_bal]);
            $transaction = $user_wallet->transactions()->create([
                'user_id' => $ref_code->user_id,
                'referral_code_id' => $ref_code->id,
                'type' => 'referral',
                'amount' => $earn,
                'remarks' => $remarks,
            ]);
        }

        if($user && $wallet && $referral_code && $document) {
            $user->password = '';
            return [
                'msg' => 'You have successfully registered',
                'isRegister' => true,
            ];
        }
        return [
            'error' => 'Not registered',
            'isRegister' => false,
        ];
    }

    public function login($credentials)
    {
        $token = JWTAuth::attempt($credentials);
        if($token) {

            return [
                'msg' => 'You have successfully logged in',
                'isLogin' => true,
                'token' => $token,
                'expires' => JWTAuth::factory()->getTTL() * 60,
            ];
        }
        return [
            'error' => 'Unauthorized',
            'isLogin' => false,
        ];
    }

}