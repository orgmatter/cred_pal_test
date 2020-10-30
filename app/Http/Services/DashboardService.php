<?php
namespace App\Http\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transactions;



class DashboardService
{

    public function reset_password($credentials)
    {
        $hash_old_password = Hash::make($credentials['old_password']);
        $hash_new_password = Hash::make($credentials['new_password']);
        
        $old_user = User::where('password', $hash_old_password)->first();
        $reset_password = $user->update(['password' => $hash_new_password]);
        if($reset_password) {
            $new_user = User::find($old_user->id);
            $token = JWTAuth::fromUser($new_user);
            $new_user->password = '';

            return [
                'msg' => 'Password reset successful',
                'isReset' => true,
                'user' => $new_user,
                'token' => $token,
                'expires' => JWTAuth::factory()->getTTL() * 60,
            ];
        }
        return [
            'error' => 'Reset password failed',
            'isReset' => false,
        ];
    }

    public function user_transactions()
    {
        $user_id = JWTAuth::user()->id;
        $transactions = Transaction::where('user_id', $user_id);

        if($transactions) {
            return [
                'msg' => 'User transactions successful',
                'isTransactions' => true,
            ];
        }
        return [
            'msg' => 'User transactions failed',
            'isTransactions' => false,
        ];
    }
}