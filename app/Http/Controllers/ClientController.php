<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function showAll(): View
    {
        return view('admin.clients.all', [
            'clients' => Client::paginate(25)
        ]);
    }

    public function view(Client $client): View
    {
        return view('admin.clients.view', [
            'client' => $client
        ]);
    }

    public function updatePage(Client $client): View
    {
        return view('admin.clients.update', [
            'client' => $client
        ]);
    }

    public function update(Client $client)
    {
        
    }
}
