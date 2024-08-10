<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        return view('admin.dashboard', [
            'clientCount' => Client::count()
        ]);
    }
}
