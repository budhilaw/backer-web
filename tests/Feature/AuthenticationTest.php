<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Test success: user can register
     *
     * @return void
     */
    public function test_can_register(): void
    {
        $userData = [
            "avatar" => "default",
            "name" => $this->faker->name(),
            "occupation" => $this->faker->word(),
            "email" => $this->faker->email(),
            "password" => "kaizen123",
            "password_confirmation" => "kaizen123"
        ];

        $this->withHeaders(['Accept', 'application/json'])
            ->json("POST", route('register'), $userData)
            ->assertStatus(201)
            ->assertJsonStructure($this->successJsonStructure());
    }

    /**
     * Test fail: user cannot register (validation error)
     *
     * @return void
     */
    public function test_failed_register_validation(): void
    {
        // test with empty value
        $userData = [
            "avatar" => "",
            "name" => "",
            "occupation" => "",
            "email" => "",
            "password" => "",
            "password_confirmation" => ""
        ];

        $this->withHeaders(['Accept', 'application/json'])
            ->json("POST", route('register'), $userData)
            ->assertStatus(422)
            ->assertJsonStructure($this->failJsonStructure());
    }

    /**
     * Test fail: user cannot register (email is exist)
     *
     * @return void
     */
    public function test_failed_register_email_exist(): void
    {
        // create first user
        User::factory()->count(1)->create([
            "email" => "kai@gmail.com",
        ]);

        // test with empty value
        $userData = [
            "avatar" => "default",
            "name" => $this->faker->name(),
            "occupation" => $this->faker->word(),
            "email" => "kai@gmail.com",
            "password" => "kaizen123",
            "password_confirmation" => "kaizen123"
        ];

        $this->withHeaders(['Accept', 'application/json'])
            ->json("POST", route('register'), $userData)
            ->assertStatus(422)
            ->assertJsonStructure($this->failJsonStructure());
    }

    /**
     * Test success: user can login
     *
     * @return void
     */
    public function test_can_login(): void
    {
        // create first user
        User::factory()->count(1)->create([
            "email" => "kai@gmail.com",
            "password" => bcrypt("kaizen123")
        ]);

        // test login
        $userData = [
            "email" => "kai@gmail.com",
            "password" => "kaizen123",
        ];

        $this->withHeaders(['Accept', 'application/json'])
            ->json("POST", route('login'), $userData)
            ->assertStatus(200)
            ->assertJsonStructure($this->successJsonStructure());
    }

    /**
     * Test fail: user cannot login (username/password invalid
     *
     * @return void
     */
    public function test_failed_login_wrong_data(): void
    {
        // test login
        $userData = [
            "email" => "kai@gmail.com",
            "password" => "kaizen123",
        ];

        $this->withHeaders(['Accept', 'application/json'])
            ->json("POST", route('login'), $userData)
            ->assertStatus(401)
            ->assertJsonStructure($this->unauthenticatedJsonStructure());
    }

    /**
     * Test fail: user cannot login (validation error)
     *
     * @return void
     */
    public function test_failed_login_validation(): void
    {
        // test login
        $userData = [
            "email" => "",
            "password" => "",
        ];

        $this->withHeaders(['Accept', 'application/json'])
            ->json("POST", route('login'), $userData)
            ->assertStatus(422)
            ->assertJsonStructure($this->failJsonStructure());
    }

    public function successJsonStructure(): array
    {
        return [
            "user" => [
                "id",
                "name",
                "occupation",
                "email",
                "created_at",
                "updated_at"
            ]
        ];
    }

    public function failJsonStructure(): array
    {
        return [
            "message",
            "errors"
        ];
    }

    public function unauthenticatedJsonStructure(): array
    {
        return [
            "error"
        ];
    }

}
