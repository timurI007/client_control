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
        $clients = Client::select('id', 'name', 'lastname', 'email', 'phone', 'birthdate')->paginate(25);
        return view('admin.clients.all', [
            'clients' => $clients
        ]);
    }

    public function view(int $id): View
    {
        $client = Client::where('id', $id)->firstOrFail();
        return view('admin.clients.view', [
            'client' => $client
        ]);
    }

    public function updatePage(int $id): View
    {
        $client = Client::select('id', 'name', 'lastname', 'email', 'phone', 'birthdate')
            ->where('id', $id)
            ->firstOrFail();
        return view('admin.clients.update', [
            'client' => $client
        ]);
    }

    public function deletePage(int $id): View
    {
        $client = Client::select('id', 'name')
            ->where('id', $id)
            ->firstOrFail();
        return view('admin.clients.delete', [
            'client' => $client
        ]);
    }

    public function update(ClientUpdateRequest $request, int $id, SendCodeServiceInterface $sendCodeService): RedirectResponse
    {
        if (!$sendCodeService->checkConfirmationCode($request->input('confirmation_code'))) {
            return back()->withErrors([
                'confirmation_code' => 'Confirmation code is incorrect!'
            ]);
        }

        $client = Client::select('id')->where('id', $id)->firstOrFail();
        $client->update($request->safe()->except(['confirmation_code']));

        return redirect()->route('clients.view', ['id' => $id])->with('success', 'Client updated successfully.');
    }

    public function delete(ClientDeleteRequest $request, int $id, SendCodeServiceInterface $sendCodeService): RedirectResponse
    {
        if (!$sendCodeService->checkConfirmationCode($request->input('confirmation_code'))) {
            return back()->withErrors([
                'confirmation_code' => 'Confirmation code is incorrect!'
            ]);
        }

        $client = Client::select('id')->where('id', $id)->firstOrFail();
        $client->delete();

        return redirect()->route('clients.all');
    }
}
