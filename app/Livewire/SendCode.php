<?php

namespace App\Livewire;

use App\Enums\CodeSenderType;
use App\Exceptions\SendCodeException;
use App\Models\User;
use App\Services\SendConfirmationCode\SendCodeService;
use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SendCode extends Component
{
    public string $selectedMethod;

    private User $user;
    private SendCodeService $sendCodeService;

    public function boot(SendCodeService $sendCodeService)
    {
        $this->user = Auth::user();
        $this->sendCodeService = $sendCodeService;
    }

    public function mount()
    {
        $this->selectedMethod = CodeSenderType::SMS->value;
    }    

    public function rules(): array
    {
        return [
            'selectedMethod' => ['required', 'string', Rule::enum(CodeSenderType::class)]
        ];
    }

    public function render()
    {
        return view('livewire.send-code')->with([
            'methods' => array_map(fn($case) => $case->value, CodeSenderType::cases()),
        ]);
    }

    public function sendCode()
    {
        $this->validate();
        
        $method = CodeSenderType::from($this->selectedMethod);

        $destination = '';
        switch ($method) {
            case CodeSenderType::SMS:
                $destination = $this->user->phone;
                break;
            case CodeSenderType::EMAIL:
                $destination = $this->user->email;
                break;
            case CodeSenderType::TELEGRAM:
                $destination = $this->user->telegram;
                break;
        }
        
        $message = '';
        try{
            $this->sendCodeService->sendCode($destination, $method);
            $message = "Code was successfully sent to $destination!";
        } catch (SendCodeException $exception) {
            $message = $exception->getMessage();
        } catch (Exception $exception) {
            $message = 'Somethinge went wrong :(';
        }
        
        $this->js('alert("' . $message . '")');
    }
}

