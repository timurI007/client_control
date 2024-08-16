<div>
    <form wire:submit.prevent="sendCode">
        <fieldset>
            <legend>Select a method to send confirmation code:</legend>
            @foreach($methods as $method)
                <label for="{{ $method }}">{{ $method }}</label>
                <input type="radio" id="{{ $method }}" name="method" value="{{ $method }}" wire:model="selectedMethod" />
                <br>
            @endforeach
        </fieldset>
        <br>
        <input type="submit" value="Send Code">
    </form>
</div>
