<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Campaign;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        if(Auth::check()) {
            $user = Auth::user();
            if($user['role'] != 1) {
                return response()->json(["message" => "You cannot access this page!"]);
            }
        }
    }

    /**
     * Publish a campaign post
     *
     * @param string $id
     * @return JsonResponse
     */
    public function publishCampaign(string $id): JsonResponse {
        $campaign = Campaign::findOrFail($id);
        $campaign['status'] = 1; // published
        $campaign->save();
        return response()->json(['message' => 'Campaign data successfully published!'],200);
    }

    /**
     * Display all transactions
     *
     * @return AnonymousResourceCollection
     */
    public function listTransactions(): AnonymousResourceCollection
    {
        $limit = config('app.configApp.limitPaginate');
        return TransactionResource::collection(Transaction::paginate($limit));
    }

    /**
     * @param String $id
     * @return JsonResponse
     */
    public function verifyTransaction(String $id): JsonResponse
    {
        $transaction = Transaction::findOrFail($id);
        if($transaction['status'] != 0) {
            return response()->json(['failed' => 'transaction is already paid.'], 400);
        }
        $campaign = Campaign::find($transaction->campaign->id)->first();
        $finalAmount = $campaign['current_amount'] + $transaction['amount'];
        $campaign['current_amount'] = $finalAmount;
        $campaign->save();
        Transaction::query()->update(['status' => 1]);
        return response()->json(['success'=>'transaction status change successfully.'], 200);
    }
}
