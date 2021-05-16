<?php

namespace Database\Factories;

use App\Models\InvitedPerson;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvitedPersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvitedPerson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invitation_id' => rand(1,50),
            'user_id' => rand(1,25)
        ];
    }
}
