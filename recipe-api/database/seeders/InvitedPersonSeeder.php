<?php

namespace Database\Seeders;

use App\Models\InvitedPerson;
use Illuminate\Database\Seeder;

class InvitedPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvitedPerson::factory()->times(100)->create();
    }
}
