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
    
    public function register(array $crendentials)
    {
        $user = User::create($credentials['personal']);
        $wallet = $user->wallets()->create($credentials['wallet']);
        $referral_code = $user->referral_codes()->create($credentials['referral']['new_code']);
        $document = $user->documents()->create($credentials['document']);

        $ref_code = ReferralCode::where('code', $credentials['referral']['ref_code'])->first();
        if($ref_code) {
            $earn = 1000;
            $remarks = 'This is a referral transaction';
            $wallet = Wallet::find($ref_code->user_id);
            $new_wallet_bal = ($wallet->wallet_bal + $earn);
            $updateWallet = $wallet->update(['wallet_bal' => $new_wallet_bal]);
            $transaction = $wallet->transactions()->create([
                'referral_code_id' => $ref_code->id,
                'type' => 'referral',
                'amount' => $earn,
                'remarks' => $remarks,
            ]);
        }

        if($user && $wallet && $referral_code && $documet) {
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
        $hashed_password = Hash::make($credentials['password']);
        $user = User::where('password', $hashed_password)->first();
        $token = JWTAuth::fromUser($user);
        if($token) {

            return [
                'msg' => 'You have successfully registered',
                'user' => $user,
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