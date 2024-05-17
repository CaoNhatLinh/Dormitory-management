<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" width="50px" height="50px" src="{{ asset('uploads/avatars/'. $employee->avatar) }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"> {{ $employee->name }}</strong>
                            </span> <span class="text-muted text-xs block">{{ $position_name }} <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{route('user.index')}}">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="active">
                <a href="{{route('dashboard.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>
            </li>

            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Contracts</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="graph_flot.html">New contract</a></li>
                    <li><a href="{{route('student.index')}}">Students list</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Rooms</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('room.index')}}">Rooms list</a></li>
                    <li><a href="{{route('room.createView')}}">New room</a></li>
                    <li><a href="{{route('roomType.index')}}">Room types list</a></li>
                    <li><a href="{{route('roomType.createView')}}">New room type</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Devices</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="form_basic.html">Devices list</a></li>
                    <li><a href="form_advanced.html">New device</a></li>
                    <li><a href="graph_morris.html">Device types list</a></li>
                    <li><a href="graph_morris.html">New device type</a></li>

                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">Invoices</span><span class="fa arrow"></span></a>

                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#">New invoice <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">New invoice electric and water</a>
                            </li>
                            <li>
                                <a href="#">New invoice equiment</a>
                            </li>
                        </ul>
                    <li><a href="contacts.html">Invoices list</a></li>
                    <li><a href="contacts_2.html">Equipment invoice list</a></li>
                    <li><a href="profile_2.html">Send invoice payment notification</a></li>

                </ul>
            </li>


            <li>
                <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Employees</span><span class="fa arrow"></span></a>

                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('employee.index')}}">Employees list</a></li>
                    <li><a href="{{route('employee.createView')}}">New employee</a></li>
                    <li><a href="agile_board.html">Positions list</a></li>
                    <li><a href="timeline_2.html">New position</a></li>

                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">Users</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="typography.html">Users list</a></li>
                    <li><a href="icons.html">New user</a></li>
                </ul>
            </li>
            <li>
                <a href="css_animation.html"><i class="fa fa-edit"></i> <span class="nav-label">Setting </span></a>
            </li>



            <li class="landing_link">
                <a target="_blank" href="landing.html"><i class="fa fa-star"></i> <span class="nav-label">Landing Page</span> <span class="label label-warning pull-right">NEW</span></a>
            </li>

        </ul>

    </div>
</nav>