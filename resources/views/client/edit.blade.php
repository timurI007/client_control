<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Client</title>
    <style>
        p{
            margin:0;
        }
        .fields{
            margin-bottom: 15px;
            width: 300px;
        }
        .fields .field-block{
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 5px;
        }
        .code-form{
            margin: 15px 0;
        }
        .errors{
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @include('app.header', ['dashboard' => true])
    <form method="post" action="/client/update">
        @csrf
        <p style="margin-top:15px;">Updating Client ID: <b>{{ $client->id }}</b></p>
        <input name="id" type="hidden" value="{{ $client->id }}">
        <div class="fields">
            <div class="field-block">
                <p>Name:</p>
                <input name="name" type="text" required value="{{ old('name', $client->name) }}">
            </div>
            <div class="field-block">
                <p>Last Name:</p>
                <input name="lastname" type="text" required value="{{ old('lastname', $client->lastname) }}">
            </div>
            <div class="field-block">
                <p>Email:</p>
                <input name="email" type="email" required value="{{ old('email', $client->email) }}">
            </div>
            <div class="field-block">
                <p>Phone:</p>
                <input name="phone" type="text" required value="{{ old('phone', $client->phone) }}">
            </div>
            <div class="field-block">
                <p>Date Of Birth:</p>
                <input name="birthdate" type="date" value="{{ date_create(old('birthdate', $client->birthdate))->format('Y-m-d') }}">
            </div>
        </div>
        <div class="code-form">
            <p>
                <span style="color:#ff0000;">Confirm Update!</span>
                <br>
                Send code via:
            </p>
            <div>
                <input type="radio" name="confirm_type" checked id="sms" value="sms"/>
                <label for="sms">sms</label>
            </div>
            <div>
                <input type="radio" name="confirm_type" id="email" value="email"/>
                <label for="email">email</label>
            </div>
            <div>
                <input type="radio" name="confirm_type" id="telegram" value="telegram"/>
                <label for="telegram">telegram</label>
            </div>
            <input type="text" name="code" required placeholder="Enter code">
            <button id="btn-send-code" type="button" onclick="send_code();">
                Send Code
                <span id="seconds" style="color:#ff0000;font-weight:bold;"></span>
            </button>
            <div id="sent_code"></div>
        </div>
        <input style="padding: 5px 10px;" type="submit" value="Update">
        <div class="errors">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

        var timer_left = 0;
        var seconds = document.getElementById("seconds");
        var send_code_btn = document.getElementById("btn-send-code");

        function send_code(){
            if(timer_left != 0){
                alert("Wait " + timer_left + " seconds!");
                return false;
            }
            var send_type = document.querySelector('input[name="confirm_type"]:checked').value;
            if(!send_type){
                alert("Choose method to send code.");
                return false;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: '/client/code',
                data: {
                    'send_type': send_type
                },
                dataType: "json",
                success: function(result_data) {
                    if(result_data.time_left){
                        timer_left = result_data.time_left;
                        send_code_btn.disabled = true;
                        timer();
                    }
                    // For imitation like code sent
                    if(result_data.code){
                        document.getElementById("sent_code").innerHTML = result_data.code;
                    }
                    if (result_data.success) {
                        // For future - style widget success
                        alert(result_data.message);
                    } else {
                        // For future - style widget danger
                        alert(result_data.message);
                    }
                }
            });
        }

        function timer(){
            timer_left--;
            seconds.innerHTML = "Wait " + timer_left + " seconds";
            if(timer_left > 0){
                setTimeout(timer, 1000);
            } else {
                send_code_btn.disabled = false;
                seconds.innerHTML = "";
            }
        }

    </script>
</body>
</html>