<?php

namespace App\Models;

use App\Enums\BillingType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasUuids;

    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'saas_payment_id',
        'client_id',
        'description',
        'billing_type',
        'value',
        'due_date',
    ];
    protected $casts = [
        'billing_type' => BillingType::class,
        'value' => 'float',
        'due_date' => 'datetime:Y-m-d H:i:s',
    ];
}
