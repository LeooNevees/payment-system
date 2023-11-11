<?php

namespace Database\Seeders;

use App\Models\AutomatedTellerMachine;
use Illuminate\Database\Seeder;

class AutomatedTellerMachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(AutomatedTellerMachine::where('agency_id', 1)->first()){
            return;
        }

        AutomatedTellerMachine::create([
            'agency_id' => 1,
        ]);
    }
}
