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
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @foreach($config['linkcss'] as $key => $value) 
    
    <link href="$value"rel="stylesheet" >
    @endforeach 
    @foreach($config['css'] as $key => $value) 
    
      <link href="{{asset($value)}}"rel="stylesheet" >
    @endforeach 

    <style>
    .metismenu .collapse.in {
  visibility: visible !important;
}
  </style>