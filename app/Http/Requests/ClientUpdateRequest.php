<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule', 'array<mixed>', 'string>
     */
    public function rules(): array
    {
        $clientId = $this->route('id');
        return [
            'name' => ['required', 'string', 'max:100', 'min:2'],
            'lastname' => ['required', 'string', 'max:100', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email,' . $clientId],
            'phone' => ['required', 'string', 'max:25', 'min:5', 'unique:clients,phone,' . $clientId],
            'birthdate' => ['required', 'date', 'before:2024-01-01'],
            'confirmation_code' => ['required', 'numeric']
        ];
    }
}
