<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        CampaignImage::factory()
            ->count(10)
            ->create();
    }
}
