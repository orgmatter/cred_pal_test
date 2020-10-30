<?php
namespace App\Http\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\ReferralCode;
use App\Models\Transactions;
use App\Models\Document;


class DashboardService
{

    public function read_user_transactions()
    {
        $user_id = JWTAuth::user()->id;
        $transactions = Transaction::where('user_id', $user_id)->get();

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

    public function read_user_wallet()
    {
        $user_id = JWTAuth::user()->id;
        $wallet = Wallet::where('user_id', $user_id)->first();

        if($wallet) {
            return [
                'msg' => 'User wallet successful',
                'iswallet' => true,
            ];
        }
        return [
            'msg' => 'User wallet failed',
            'isWallet' => false,
        ];
    }

    public function read_user_referral_code()
    {
        $user_id = JWTAuth::user()->id;
        $referral_code = ReferralCode::where('user_id', $user_id)->first();

        if($referral_code) {
            return [
                'msg' => 'User referral code successful',
                'isreferral_code' => true,
            ];
        }
        return [
            'msg' => 'User referral code failed',
            'isreferral_code' => false,
        ];
    }

    public function read_user_ref_transactions()
    {
        $user_id = JWTAuth::user()->id;
        $referral_transactions = Transaction::where(['user_id' => $user_id, 'type' => 'referral'])->get();

        if($referral_transactions) {
            return [
                'msg' => 'User transactions successful',
                'isRefTransactions' => true,
            ];
        }
        return [
            'msg' => 'User transactions failed',
            'isREfTransactions' => false,
        ];
    }

    public function read_user_document()
    {
        $user_id = JWTAuth::user()->id;
        $user_doc = Document::where(['user_id' => $user_id, 'isUpload', '<>', (bool)0])->first();
        if($user_doc) {
            return [
                'msg' => 'User document successful',
                'isDocument' => true,
            ];
        }
        return [
            'msg' => 'User document failed',
            'isDocument' => false,
        ];
    }

    public function upload_user_document()
    {

    }

    public function user_wallet_spend(array $credentials)
    {
        $user_id = JWTAuth::user()->id;
        $wallet_address = $credentials['wallet_address'];
        $amount = $credentials['amount'];
       
        $sender_user_wallet = Wallet::where('user_id', $user_id)->first();
        $receiver_user_wallet = Wallet::where('wallet_address', $wallet_address)->first();
        $receiver_user_id = $receiver_user->id;
        $isSenderLimit = $sender_user_wallet->isLimit;

        // --> make sure the sender amount does not exceed 50000 if wallet limit is set, this is because the sender has no valid ID
        if($isSenderLimit && ($amount > 50000)) {

            return [
                'msg' => 'Sending failed because amount greater than 50000 is not permitted on this wallet without a valid ID',
                'isSending' => false,
            ];
            
            // --> make sure the sender is not sending to himself
        }elseif($user_id === $receiver_user_id) { 
            return [
                'msg' => 'Sending failed because user cant transfer from same wallet to self',
                'isSending' => false,
            ];
        }else {

            // --> update the wallet bal for both receiver and sender
            $new_receiver_wallet_bal = ($receiver_user_wallet->wallet_bal + $amount);
            $new_sender_wallet_bal = ($sender_user_wallet->wallet_bal - $amount);
            $isReceiverWalletUpdate = $receiver_user_wallet->update(['wallet_bal' => $new_receiver_wallet_bal]);
            $isSenderWalletUpdate = $receiver_user_wallet->update(['wallet_bal' => $new_sender_wallet_bal]);

            //--> update the transaction table for the receiver
            $receiver_transac = $receiver_user_wallet->transactions()->create([
                'user_id' => $user_id,
                'type' => 'receive',
                'amount' => $amount,
                'remarks' => 'This is a receive transaction',
            ]);
            
            //--> update the transaction table for the sender
            $sender_transac = $sender_user_wallet->transactions()->create([
                'user_id' => $receiver_user_id,
                'type' => 'transfer',
                'amount' => $amount,
                'remarks' => 'This is a transfer transaction',
            ]);

            if($isReceiverWalletUpdate && $isSenderWalletUpdate && $receiver_transac && $sender_transac) {

                return [
                    'msg' => 'Transfer was successful',
                    'isTransfer' => true,
                ];
            }
            return [
                'msg' => 'Transfer failed',
                'isTransfer' => false,
            ];
        }
    }

    public function reset_password(array $credentials)
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
}