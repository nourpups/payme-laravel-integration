<?php

namespace App\Http\Controllers;

use App\Services\Payme\Payme;
use Illuminate\Http\Request;

class PaymeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Payme $payme)
    {
        $transactionMethod = $request['method'];
        return $payme->{$transactionMethod}();
    }
}
