<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Config;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display all transactions data
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $limit = config('app.configApp.limitPaginate');
        return TransactionResource::collection(Transaction::paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return TransactionResource
     */
    public function store(TransactionRequest $request): TransactionResource
    {
        $userId =  Auth::id();
        $transaction = Transaction::query()
            ->create([
                'campaign_id' => $request['campaign_id'],
                'user_id' => $userId,
                'amount' => $request['amount'],
                'status' => 0
            ]);

        return new TransactionResource($transaction);
    }

    /**
     * @param String $id
     * @return JsonResponse
     */
    public function verify(String $id): JsonResponse
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
