<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasUuids;

    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $fillable = [
        'saas_client_id',
        'name',
        'email',
        'phone',
        'mobile_phone',
        'cpf',
    ];
}
