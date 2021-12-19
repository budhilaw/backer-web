<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'status',
        'excerpt',
        'description',
        'perks',
        'backer_count',
        'goal_amount',
        'current_amount'
    ];

    /**
     * Return a users that have a campaigns.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return a campaigns that have a image.
     *
     * @return HasMany
     */
    public function image(): HasMany
    {
        return $this->hasMany(CampaignImage::class);
    }
}
