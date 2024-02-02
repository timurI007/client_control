<?php

namespace App\Classes;

class ConfirmCode
{
    const CODE_MIN = 1000;
    const CODE_MAX = 9999;

    const EXPIRATION = 3; // min

    public function send_sms($phone_number){
        $session_expires = $this->get_code_expires();
        $result = new CodeResult();
        // checking time expires
        if(!empty($session_expires) && now()->lessThan($session_expires)){
            $result->setCode($this->get_code());
            $result->setIsError();
            $result->setTimeLeft(abs(time() - strtotime($session_expires)));
            $result->setText('Wait ' . $result->getTimeLeft() . ' seconds to send code again!');
            return $result;
        }
        $code = $this->generateCode();

        // code sent successfully
        // ...

        $this->save_code($code);
        $this->save_type('sms'); // For future to fix which method used
        $result->setCode($code);
        $result->setText('Code sent to phone number ' . $phone_number);
        $result->setTimeLeft(self::EXPIRATION * 60);
        return $result;
    }

    public function send_email($email){
        $session_expires = $this->get_code_expires();
        $result = new CodeResult();
        if(!empty($session_expires) && now()->lessThan($session_expires)){
            $result->setCode($this->get_code());
            $result->setIsError();
            $result->setTimeLeft(abs(time() - strtotime($session_expires)));
            $result->setText('Wait ' . $result->getTimeLeft() . ' seconds to send code again!');
            return $result;
        }
        $code = $this->generateCode();

        // code sent successfully
        // ...

        $this->save_code($code);
        $this->save_type('email'); // For future to fix which method used
        $result->setCode($code);
        $result->setText('Code sent to email ' . $email);
        $result->setTimeLeft(self::EXPIRATION * 60);
        return $result;
    }

    public function send_tg($tg_link){
        $session_expires = $this->get_code_expires();
        $result = new CodeResult();
        if(!empty($session_expires) && now()->lessThan($session_expires)){
            $result->setCode($this->get_code());
            $result->setIsError();
            $result->setTimeLeft(abs(time() - strtotime($session_expires)));
            $result->setText('Wait ' . $result->getTimeLeft() . ' seconds to send code again!');
            return $result;
        }
        $code = $this->generateCode();

        // code sent successfully
        // ...

        $this->save_code($code);
        $this->save_type('tg'); // For future to fix which method used
        $result->setCode($code);
        $result->setText('Code sent to telegram account @' . $tg_link);
        $result->setTimeLeft(self::EXPIRATION * 60);
        return $result;
    }

    public function clear_session(){
        session()->forget('confirm_code');
        session()->forget('code_expires');
        session()->forget('send_code_type');
    }

    public function check_code($code){
        return $this->get_code() == $code;
    }

    private function generateCode(){
        return rand(self::CODE_MIN, self::CODE_MAX);
    }

    private function save_code($code){
        session()->put('confirm_code', $code);
        session()->put('code_expires', now()->addMinutes(self::EXPIRATION));
    }

    private function get_code_expires(){
        return session()->get('code_expires');
    }

    private function get_code(){
        return session()->get('confirm_code');
    }

    // For future to fix which method used
    private function save_type($type){
        session()->put('send_code_type', $type);
    }

    // For future to fix which method used
    private function get_type($type){
        return session()->get('send_code_type');
    }
}

class CodeResult
{
    private $code;
    private $text;
    private $is_error = false;
    private $time_left; // in seconds

    public function getCode(){
        return $this->code;
    }
    public function setCode($code){
        $this->code = $code;
    }

    public function getText(){
        return $this->text;
    }
    public function setText($text){
        $this->text = $text;
    }

    public function isError(){
        return $this->is_error;
    }
    public function setIsError($is_error = true){
        $this->is_error = $is_error;
    }

    public function getTimeLeft(){
        return $this->time_left;
    }
    public function setTimeLeft($time_left){
        $this->time_left = $time_left;
    }
}