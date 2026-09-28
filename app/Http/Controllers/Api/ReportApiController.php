<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportApiController extends Controller
{
    public function index(Request $request)
    {
        // TODO: kembalikan ringkasan laporan (booking, pendapatan) untuk tenant terkait.
        return response()->json([]);
    }
}
