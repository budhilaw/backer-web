<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Config;
use App\Http\Resources\TransactionResource;
use Carbon\Carbon;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $limit = config('app.configApp.limitPaginate');
        $transactions = Transaction::paginate($limit);
        return TransactionResource::collection($transactions);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $dateNow = Carbon::now()->toDateString();
        $userId =  auth()->user()->id;
        if ($request->validated()){
            $transaction = Transaction::query()
                ->create([
                    'campaign_id' => $request->campaign_id,
                    'user_id' => $userId,
                    'amount' => $request->amount,
                    'status' => 1
                ]);
            $getCurrentAmount = Campaign::query()
                ->where('id', $request->campaign_id)
                ->select('current_amount')
                ->first();
            $finalAmount = $getCurrentAmount->current_amount + $request->amount;
            $campaign = Campaign::query()
                ->where('id', $request->campaign_id)
                ->update([
                    'current_amount' => $finalAmount
                ]);

            return new TransactionResource($transaction);
        }
        return response()->json($request->errors(), 422);

    }

    public function changeStatus(Request $request)
    {
        $transaction = Transaction::find($request->campaign_id);
        $transaction = Transaction::query()
                ->update([
                    'status' => 1
                ]);
  
        return response()->json(['success'=>'transaction status change successfully.']);
    }
}
