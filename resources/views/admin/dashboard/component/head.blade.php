<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{$title}}</title>

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{asset('js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">

    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
<<<<<<< HEAD
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
=======
    @foreach($config['css'] as $key => $value) 
    
      <link href="{{asset($value)}}"rel="stylesheet" >
    @endforeach 
>>>>>>> a84e6e4f67a86168b9a37ef42e8a3fe8d4c09aa8
