<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::orderBy('id', 'desc')->paginate(15);
        return view('logs.index', compact('logs'));
    }
}
