@extends('layouts.admin')

@section('title', 'Delete ' . $client->name)

@section('supportStyles')
    @livewireStyles
@endsection

@section('content')
    <h3>Deleting client <span class="underline">{{ $client->name }}</span></h3>
    <form action="{{ route('clients.delete', ['client' => $client]) }}" method="post">
        @csrf
        <label for="confirmation_code">Confirmation code:</label>
        <input id="confirmation_code" name="confirmation_code" placeholder="Enter confirmation code" type="number" />
        <br>
        <input type="submit" value="Delete">
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