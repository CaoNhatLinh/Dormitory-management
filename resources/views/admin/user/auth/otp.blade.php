<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý ký túc xá</title>

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/login.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div style="color: white;">
            <div >
                <h1 class="logo-name">Dormitory management</h1>
            </div>
            <h3 class="fst-italic">Welcome to the dormitory management system</h3>
            
         
            <div class="login">
                
                <form method="POST" role="form" action="{{ route('password.verify') }}}">
                    <input type="text" name="otp" placeholder="enter OTP" required="required" />
                    <input type="text" name="email" value="{{ $email }}">
                    @if ($errors->has('otp'))
                    <span class="error-message">*{{$errors->first('otp')}}</span>
                    @endif
                   
                    <button type="submit" class="btn btn-primary btn-block btn-large">Sending OTP</button>
                </form>
            </div>
    <!-- Mainly scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>

</body>

</html>