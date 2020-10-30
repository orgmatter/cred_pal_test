<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\DashboardService;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth.api');
        $this->dashboardService = $dashboardService;
    }



    public function dashboard()
    {
        $user_transac_response = $this->dashboardService->read_user_transactions();
        $user_wallet_response = $this->dashboardService->read_user_wallet();
        $user_ref_code_response = $this->dashboardService->read_user_referral_code();
        $user_ref_transaction_resposnse = $this->dashboardService->read_user_ref_transactions();
        $user_document_response = $this->dashboardService->read_user_document();

        $dashboad_responses = [
            'dashboard' => [
                $user_transac_response,
                $user_wallet_response,
                $user_ref_code_response,
                $user_ref_transaction_resposnse,
                $user_document_response
            ]
        ];

        return response()->JSON($dashboad_responses);
    }

    public function user_wallet_spend(Request $request)
    {
        $validated = $request->validate([
            'wallet_address' => 'required|number',
            'amount' => 'required|number'
        ]);

        if($validated) {
            $credentials = [
                'wallet_address' => $request->wallet_address,
                'amount' => $request->amount,
            ];

            $response = $this->dashboardService->wallet_spend($credentials);
            
            return response()->JSON($response);
        }
    }

    // --> function for saving feature
    public function wallet_save(Request $request)
    {
        
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
}
