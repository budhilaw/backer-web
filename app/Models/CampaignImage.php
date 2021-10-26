<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignImage extends Model
{
    use HasFactory;

    protected $fillable = [ 'campaign_id','file_name', 'is_primary' ];

    /**
     * Get the campaign for the campaign_images.
     */
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
