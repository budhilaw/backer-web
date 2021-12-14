<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = [
        'campaign_id',
        'user_id',
        'amount',
        'status', 
    ];

    public function campaigns(): BelongsTo
    {
        return $this->belongsTo(campaigns::class,'campaign_id');
    }
}