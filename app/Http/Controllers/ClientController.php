<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientDeleteRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use App\Services\SendConfirmationCode\ConfirmationCodeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function showAll(): View
    {
        $clients = Client::select('id', 'name', 'lastname', 'email', 'phone', 'birthdate')->paginate(25);
        return view('admin.clients.all', compact('clients'));
    }

    public function view(int $id): View
    {
        $client = $this->findClientOrFail($id);
        return view('admin.clients.view', compact('client'));
    }

    public function updatePage(int $id): View
    {
        $client = $this->findClientOrFail($id, ['id', 'name', 'lastname', 'email', 'phone', 'birthdate']);
        return view('admin.clients.update', compact('client'));
    }

    public function deletePage(int $id): View
    {
        $client = $this->findClientOrFail($id, ['id', 'name']);
        return view('admin.clients.delete', compact('client'));
    }

    public function update(ClientUpdateRequest $request, int $id, ConfirmationCodeService $confirmationCodeService): RedirectResponse
    {
        if (!$confirmationCodeService->checkConfirmationCode($request->input('confirmation_code'))) {
            return back()->withErrors([
                'confirmation_code' => 'Confirmation code is incorrect!'
            ]);
        }

        $client = $this->findClientOrFail($id, ['id']);
        $client->update($request->safe()->except(['confirmation_code']));

        return redirect()->route('clients.view', ['id' => $id])->with('success', 'Client updated successfully.');
    }

    public function delete(ClientDeleteRequest $request, int $id, ConfirmationCodeService $confirmationCodeService): RedirectResponse
    {
        if (!$confirmationCodeService->checkConfirmationCode($request->input('confirmation_code'))) {
            return back()->withErrors([
                'confirmation_code' => 'Confirmation code is incorrect!'
            ]);
        }

        $client = $this->findClientOrFail($id, ['id']);
        $client->delete();

        return redirect()->route('clients.all');
    }

    private function findClientOrFail(int $id, array $columns = ['*']): Client
    {
        return Client::select($columns)->where('id', $id)->firstOrFail();
    }
}
