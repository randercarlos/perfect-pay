<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class ThanksController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('thanks');
    }
}
