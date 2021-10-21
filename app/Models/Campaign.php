<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'description',
        'perks',
        'backer_count',
        'goal_amount',
        'current_amount'
    ];

    /**
     * Get the users for the campaign.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
