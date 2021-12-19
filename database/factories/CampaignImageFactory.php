<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\CampaignImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CampaignImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->sentence();

        return [
            'campaign_id' => function() {
                return self::factoryForModel(Campaign::class, 1)->create();
            },
            'file_name' => $title,
            'is_primary' => false,
        ];
    }
}
