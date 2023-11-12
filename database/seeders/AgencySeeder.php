<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Agency::where('name', 'PARENT AGENCY')->first()) {
            return;
        }

        Agency::create([
            'name' => 'PARENT AGENCY',
        ]);
    }
}
