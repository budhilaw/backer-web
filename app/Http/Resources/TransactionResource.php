<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'rupiah_amount' => "Rp " . number_format($this->amount,2,',','.'),
            'campaign' => $this->campaign,
            'date_transaction' => Carbon::parse($this->date_transaction)->format("d F Y"),
            'user' => $this->user,
            'status' => $this->status,
        ];
    }
}
