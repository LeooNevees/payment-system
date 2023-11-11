<?php

namespace App\Repository;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Collection;

class AgencyRepository
{
    public static function findAll(): Collection
    {
        return Agency::all();
    }

    public static function findBy(array $condition): Collection
    {
        return Agency::where($condition)->get();
    }
}
