<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        return view('admin.dashboard', [
            'currentUserFullName' => $user->name . ' ' . $user->lastname,
            'clientCount' => Client::count()
        ]);
    }
}
