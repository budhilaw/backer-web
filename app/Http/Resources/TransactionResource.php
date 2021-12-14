<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'campaign_id' => $this->campaign_id,
            'date_transaction' => $this->created_at,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ];
    }
}
