<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleApiController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user()->tenant;

        return $tenant->vehicles()->paginate();
    }
}
