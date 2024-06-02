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
                
                <form method="POST" action="{{route('auth.sendResetLinkEmail')}}">
                @csrf
                    <input type="text" name="email" placeholder="email" required="required" />
                    <button type="submit" class="btn btn-primary btn-block btn-large">Sending OTP</button>
                </form>
            </div>
    <!-- Mainly scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>

</body>

</html>