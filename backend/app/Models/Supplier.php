<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identification',
        'email',
        'phone',
        'street',
        'number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'complement',
        'situation',
        'situation_date',
        'type',
        'legal_nature',
        'situation_reason',
        'opening_date',
    ];

}
