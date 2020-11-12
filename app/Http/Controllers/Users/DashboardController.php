<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\DashboardService;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth:api');
        $this->dashboardService = $dashboardService;
    }



    public function index()
    {
        $user_transac_response = $this->dashboardService->read_user_transactions();
        $user_wallet_response = $this->dashboardService->read_user_wallet();
        $user_ref_code_response = $this->dashboardService->read_user_referral_code();
        $user_ref_transaction_resposnse = $this->dashboardService->read_user_ref_transactions();
        $user_document_response = $this->dashboardService->read_user_document();
        $user_data_response = $this->dashboardService->read_user();

        $dashboad_responses = [
            'user_data' => $user_data_response,
            'transactions' => $user_transac_response,
            'wallet' => $user_wallet_response,
            'referral_code' => $user_ref_code_response,
            'referral_transactions' => $user_ref_transaction_resposnse,
            'user_doc' => $user_document_response
        ];

        return response()->JSON($dashboad_responses);
    }

    public function user_wallet_spend(Request $request)
    {
        $validated = $request->validate([
            'wallet_address' => 'required|string',
            'amount' => 'required|string'
        ]);

        if($validated) {
            $credentials = [
                'wallet_address' => $request->wallet_address,
                'amount' => $request->amount,
            ];

            $response = $this->dashboardService->user_wallet_spend($credentials);
            
            return response()->JSON($response);
        }
    }

    // --> function for saving feature
    public function user_wallet_save(Request $request)
    {
        
    }


    public function upload_user_document(Request $request)
    {
        // $validated = $request->validate([
        //     'identity' => 'required'
        // ]);

        // if($validated) {
        //     $credentials = [
        //         'file' => $request->file('identity'),
        //         'user' => JWTAuth::user()
        //     ];

        //     $response = $this->dashboardService->upload_user_document($credentials);
        //     return response()->JSON($response);
        // }
        return $request->file('identity');
    }


    public function reset_password(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required|password',
            'new_password' => 'required|password',
        ]);

        if($validated) {
            $credentials = [
                'old_password' => $request->old_password,
                'new_password' => $request->new_password,
            ];

            $response = $this->dashboardService->reset_password($credentials);
            
            return response()->JSON($response);
        }
    }

    public function logout()
    {
        JWTAwt::user()->logout();
        return response()->JSON([
            'data' => [
                'msg' => 'Logout is succeesful',
                'isLogout' => true,
            ]
        ]);
    }
}
