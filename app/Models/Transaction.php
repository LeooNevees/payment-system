<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const CREDIT_TYPE = 'C';
    const DEBIT_TYPE = 'D';

    protected $fillable = [
        'bank_account_id',
        'transfer_id',
        'type',
        'value',
    ];
}
