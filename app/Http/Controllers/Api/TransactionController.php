<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
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
        $user = Auth::user();
        $limit = config('app.configApp.limitPaginate');

        // if user is an Admin
        if($user->role == 1) {
            $transaction = Transaction::paginate($limit);
            return TransactionResource::collection($transaction);
        }

        $transaction = User::find($user->id)->transactions()->paginate($limit);
        return TransactionResource::collection($transaction);
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
}
