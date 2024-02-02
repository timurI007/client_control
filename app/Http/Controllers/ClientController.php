<?php

namespace App\Http\Controllers;

use App\Classes\ConfirmCode;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class ClientController extends Controller
{
    public function view($id){
        $client = Client::find($id);
        if(empty($client)){
            return abort(404);
        }

        return view('client.view', [
            'client' => $client,
        ]);
    }

    public function edit_page($id){
        $client = Client::find($id);
        if(empty($client)){
            return abort(404);
        }

        return view('client.edit', [
            'client' => $client,
        ]);
    }

    public function update(Request $request){
        // Validation
        $request->validate([
            'id' => 'required',
            'name' => 'required|max:100',
            'lastname' => 'required|max:100',
            'birthdate' => 'required|before:today',
            'code' => 'required|numeric'
        ]);
        $data_for_validator = array(
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        );
        Validator::validate($data_for_validator, [
            'email' => [
                'required',
                'email',
                Rule::unique('clients')->ignore($request->input('id')),
            ],
            'phone' => [
                'required',
                Rule::unique('clients')->ignore($request->input('id')),
            ],
        ]);
        // Validation end

        $confirmCode = new ConfirmCode();
        if(!($confirmCode->check_code($request->input('code')))){
            return back()->withErrors([
                'code' => 'Invalid confirmation code.',
            ]);
        } else {
            $confirmCode->clear_session();
        }

        $client = Client::find($request->input('id'));
        if(empty($client)){
            return back()->withErrors([
                'id' => 'Client Not Found.',
            ]);
        }
        $client->name = $request->input('name');
        $client->lastname = $request->input('lastname');
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->birthdate = $request->input('birthdate');
        $client->save();

        return redirect('/client/' . $client->id);
    }

    public function send_code(Request $request){
        $send_type = $request->input('send_type');
        $result = array(
            'success' => 0,
            'message' => '',
        );
        if(empty($send_type)){
            $result['message'] = 'Choose method to send code.';
            return response()->json($result);
        }

        try{
            $confirmCode = new ConfirmCode();
            $send_result = null;
            switch($send_type){
                case 'sms':
                    $send_result = $confirmCode->send_sms(Auth::user()->phone);
                    break;
                case 'email':
                    $send_result = $confirmCode->send_email(Auth::user()->email);
                    break;
                case 'telegram':
                    $send_result = $confirmCode->send_tg(Auth::user()->tg_link);
                    break;
                default:
                    throw new Exception();
            }
            $result['code'] = $send_result->getCode(); // For imitation like code sent
            if($send_result->isError()){
                $result['success'] = 0;
            } else {
                $result['success'] = 1;
            }
            $result['message'] = $send_result->getText();
            $result['time_left'] = $send_result->getTimeLeft();
        } catch(Exception $ex){
            $result['success'] = 0;
            $result['message'] = $ex->getMessage();
        }
        return response()->json($result);
    }
}
