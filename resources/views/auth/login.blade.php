<html>

<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>Sign in</title>

    <style>
    body {
        background-color: #F3EBF6;
        font-family: 'Ubuntu', sans-serif;
        background-image: url("{{ url(env('APP_BACKGROUND_IMAGE')) }}");
        background-size: cover;
    }

    .main {
        background-color: #FFFFFF;
        width: 400px;
        height: 400px;
        margin: 7em auto;
        border-radius: 1.5em;
        box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
    }

    .sign {
        padding-top: 40px;
        color: #8C55AA;
        font-family: 'Ubuntu', sans-serif;
        font-weight: bold;
        font-size: 23px;
    }

    .un {
        width: 76%;
        color: rgb(38, 50, 56);
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        background: rgba(136, 126, 126, 0.04);
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        outline: none;
        box-sizing: border-box;
        border: 2px solid rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
        margin-left: 46px;
        text-align: center;
        margin-bottom: 27px;
        font-family: 'Ubuntu', sans-serif;
    }

    form.form1 {
        padding-top: 40px;
    }

    .pass {
        width: 76%;
        color: rgb(38, 50, 56);
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        background: rgba(136, 126, 126, 0.04);
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        outline: none;
        box-sizing: border-box;
        border: 2px solid rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
        margin-left: 46px;
        text-align: center;
        margin-bottom: 27px;
        font-family: 'Ubuntu', sans-serif;
    }


    .un:focus,
    .pass:focus {
        border: 2px solid rgba(0, 0, 0, 0.18) !important;

    }

    .submit {
        cursor: pointer;
        border-radius: 5em;
        color: #fff;
        background: linear-gradient(to right, #9C27B0, #E040FB);
        border: 0;
        padding-left: 40px;
        padding-right: 40px;
        padding-bottom: 10px;
        padding-top: 10px;
        font-family: 'Ubuntu', sans-serif;
        margin-left: 35%;
        font-size: 13px;
        box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
    }

    .forgot {
        text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
        color: #E1BEE7;
        padding-top: 15px;
    }

    a {
        text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
        color: #E1BEE7;
        text-decoration: none
    }

    @media (max-width: 600px) {
        .main {
            border-radius: 0px;
        }

    }
    </style>
</head>

<body>
    <div class="main">
        
        <p class="sign" align="center" style="color: #CB8D50;">Login</p>

        <form method="POST" action="{{ route('login_manual') }}">
            @csrf
            <x-jet-input id="email" class="un block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Email"/>
            
            <x-jet-input id="password" class="pass block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Password"/>
            
            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="submit ml-4" style="background: #CB8D50;">
                    {{ __('Login') }}
                </x-jet-button>
            </div>

            @if(session()->has("error"))
                <div class="alert alert-danger text-danger" role="alert" style='text-align: center; color: red; weight: bolder; margin-top: 20px;'>
                    {{ session()->get("error") }}
                </div>
            @endif
        </form>
    </div>
</body>

</html>