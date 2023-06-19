<?php

namespace App\Models;

use App\Enums\BillingType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasUuids;

    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'address',
        'address_number',
        'complement',
        'province',
        'city',
        'uf',
        'cep',
        'addressable_id',
        'addressable_type',
    ];
    protected $casts = [
        'billing_type' => BillingType::class,
        'value' => 'float',
        'due_date' => 'datetime:Y-m-d H:i:s',
    ];
}
