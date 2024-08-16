<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientDeleteRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Services\SendCode\SendCodeServiceInterface;
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

    public function deletePage(Client $client): View
    {
        return view('admin.clients.delete', [
            'client' => $client
        ]);
    }

    public function update(ClientUpdateRequest $request, Client $client, SendCodeServiceInterface $sendCodeService): RedirectResponse
    {
        if (!$sendCodeService->checkConfirmationCode($request->input('confirmation_code'))) {
            return back()->withErrors([
                'confirmation_code' => 'Confirmation code is incorrect!'
            ]);
        }

        $client->update($request->safe()->except(['confirmation_code']));

        return redirect()->route('clients.view', ['client' => $client])->with('success', 'Client updated successfully.');
    }

    public function delete(ClientDeleteRequest $request, Client $client, SendCodeServiceInterface $sendCodeService): RedirectResponse
    {
        if (!$sendCodeService->checkConfirmationCode($request->input('confirmation_code'))) {
            return back()->withErrors([
                'confirmation_code' => 'Confirmation code is incorrect!'
            ]);
        }

        $client->delete();

        return redirect()->route('clients.all');
    }
}
