<?php

namespace Database\Seeders;

use App\Model\Members;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Members::factory()->count(30)->create();
    }
}
