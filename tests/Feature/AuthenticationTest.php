<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    public function test_can_register() {
        $userData = [
            "avatar" => "default",
            "name" => $this->faker->name(),
            "occupation" => $this->faker->word(),
            "email" => $this->faker->email(),
            "password" => "kaizen123",
            "password_confirmation" => "kaizen123"
        ];

        $this->post(route('user.add'), $userData)
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "avatar",
                    "name",
                    "occupation",
                    "email",
                    "created_at",
                    "updated_at"
                ]
            ]);
    }
}
