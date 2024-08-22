@extends('layouts.admin')

@section('title', 'Clients')

@section('content')
    <h3>OUR CLIENTS:</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date Of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->lastname }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->birthdateFormatted }}</td>
                    <td>
                        <a href="{{ route('clients.view', ['id' => $client->id]) }}">view</a>
                        ||
                        <a href="{{ route('clients.update', ['id' => $client->id]) }}">update</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->links('pagination.default') }}
@endsection
