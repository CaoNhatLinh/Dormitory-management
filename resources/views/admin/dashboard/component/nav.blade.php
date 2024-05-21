<div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome to dormitory management system.</span>
                        </li>


                        <li>
                            <a href="{{route('auth.logout')}}">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                        
                    </ul>

                </nav>
</div>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> {{$title}}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('dashboard.index')}}">Home</a>
            </li>
           
            <li class="active">
                <strong>{{$title}}</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>