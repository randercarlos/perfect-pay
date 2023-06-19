<?php

namespace App\Repositories;

use App\Models\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepository extends BaseRepository
{
    public function model()
    {
        return Client::class;
    }
}
