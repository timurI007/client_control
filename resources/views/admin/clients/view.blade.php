@extends('layouts.admin')

@section('title', 'View ' . $client->name)

@section('content')
    <a href="{{ route('clients.update', ['client' => $client]) }}">Update</a>
    <p>
        <span class="bold">ID:</span> {{ $client->id }}
    </p>
    <p>
        <span class="bold">Name:</span> {{ $client->name }}
    </p>
    <p>
        <span class="bold">Last Name:</span> {{ $client->lastname }}
    </p>
    <p>
        <span class="bold">Email:</span> {{ $client->email }}
    </p>
    <p>
        <span class="bold">Phone:</span> {{ $client->phone }}
    </p>
    <p>
        <span class="bold">Birthdate:</span> {{ $client->birthdate }}
    </p>
    <p>
        <span class="bold">Updated At:</span> {{ $client->updated_at }}
    </p>
    <p>
        <span class="bold">Created At:</span> {{ $client->created_at }}
    </p>
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
@endsection
