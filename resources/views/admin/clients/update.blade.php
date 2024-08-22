@extends('layouts.admin')

@section('title', 'Update ' . $client->name)

@section('supportStyles')
    @livewireStyles
@endsection

@section('content')
    <h3>Updating client <span class="underline">{{ $client->name }}</span></h3>
    <form action="{{ route('clients.update', ['id' => $client->id]) }}" method="post">
        @csrf
        <label for="name">Name:</label>
        <input id="name" name="name" type="text" value="{{ old('name', $client->name) }}" />
        <br>
        <label for="lastname">Last Name:</label>
        <input id="lastname" name="lastname" type="text" value="{{ old('lastname', $client->lastname) }}" />
        <br>
        <label for="email">Email:</label>
        <input id="email" name="email" type="email" value="{{ old('email', $client->email) }}" />
        <br>
        <label for="phone">Phone:</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $client->phone) }}" />
        <br>
        <label for="birthdate">Birthdate:</label>
        <input id="birthdate" name="birthdate" type="datetime"
            value="{{ old('birthdate', $client->birthdate) }}" />
        <br>
        <label for="confirmation_code">Confirmation code:</label>
        <input id="confirmation_code" name="confirmation_code" placeholder="Enter confirmation code" type="number" />
        <br>
        <input type="submit" value="Update">
    </form>
    <br>
    <livewire:send-code />
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    <x-alert type="error" :message="$error" />
                </li>
            @endforeach
        </ul>
    @endif
@endsection

@section('supportScripts')
    @livewireScripts
@endsection