<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    const PENDING_STATUS = 'P';
    const SUCCESS_STATUS = 'S';
    const CANCELED_STATUS = 'C';

    protected $fillable = [
        'bank_account_id',
        'transaction_id',
    ];
}
