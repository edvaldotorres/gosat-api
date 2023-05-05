<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_institution',
        'cpf_client',
        'name_offer',
        'code_offer',
        'qnt_parcels_min',
        'qnt_parcels_max',
        'value_min',
        'value_max',
        'value_fees_month'
    ];
}
