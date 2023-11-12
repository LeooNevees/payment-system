<?php

namespace App\Repository;

use App\Models\AutomatedTellerMachine;
use Illuminate\Database\Eloquent\Collection;

class AutomatedTellerMachineRepository
{
    public static function findAll(): Collection
    {
        return AutomatedTellerMachine::all();
    }

    public static function findBy(array $condition): Collection
    {
        return AutomatedTellerMachine::where($condition)->get();
    }
}
