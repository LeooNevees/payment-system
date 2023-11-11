<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    const PERSON = 1;
    const SHOPKEEPER = 2;

    protected $fillable = [
        'description',
    ];
}
