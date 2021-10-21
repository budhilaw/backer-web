<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->sentence();
        $slug = Str::slug($title, '-');

        return [
            'user_id' => function() {
                return self::factoryForModel(User::class, 1)->create();
            },
            'name' => $title,
            'slug' => $slug,
            'excerpt' => $this->faker->text(100),
            'description' => $this->faker->text(400),
            'perks' => 'perk 1, perk 2, perk 3',
            'backer_count' => 0,
            'current_amount' => 0,
            'goal_amount' => 1000000,
        ];
    }
}
