<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\SendCode\SendCodeServiceInterface;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SendCode extends Component
{
    public string $selectedMethod;

    private User $user;
    private SendCodeServiceInterface $sendCodeService;

    public function boot(SendCodeServiceInterface $sendCodeService)
    {
        $this->sendCodeService = $sendCodeService;
        $this->user = Auth::user();
    }

    public function mount()
    {
        $this->selectedMethod = $this->sendCodeService::SMS_METHOD;
    }    

    public function rules(): array
    {
        return [
            'selectedMethod' => 'required|string|in:' . implode(',', $this->sendCodeService->getAvailableMethods())
        ];
    }

    public function render()
    {
        return view('livewire.send-code')->with([
            'methods' => $this->sendCodeService->getAvailableMethods(),
        ]);
    }

    public function sendCode()
    {
        $this->validate();

        $destination = '';
        switch ($this->selectedMethod) {
            case $this->sendCodeService::SMS_METHOD:
                $destination = $this->user->phone;
                break;
            case $this->sendCodeService::MAIL_METHOD:
                $destination = $this->user->email;
                break;
            case $this->sendCodeService::TELEGRAM_METHOD:
                $destination = $this->user->telegram;
                break;
        }
        
        $result = $this->sendCodeService->sendCode($destination, $this->selectedMethod);
        
        $this->js('alert("' . $result['message'] . '")');
    }
}

