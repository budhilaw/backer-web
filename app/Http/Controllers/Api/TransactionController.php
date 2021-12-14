<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Config;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $limit = config('app.configApp.limitPaginate');
        $transactions = Transaction::paginate($limit);
        return TransactionResource::collection($transactions);
    }
}
