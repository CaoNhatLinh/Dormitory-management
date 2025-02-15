<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<nav style="position:fixed;z-index:1; top:0; bottom:0;overflow:auto; height: 100vh" class="scroll navbar-default navbar-static-side" role="navigation">
    <div  class="sidebar-collapse ">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" width="50px" height="50px" src="{{ asset('uploads/avatars/'. $employee->avatar) }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"> {{ $employee->name }}</strong>
                            </span> <span class="text-muted text-xs block">{{ $position_name }} <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{route('user.profileView')}}">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{route('auth.logout')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    NHOM3
                </div>
            </li>
            <li class="active">
                <a href="{{route('dashboard.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> </a>
            </li>

            <li>
                <a href="#"><i class="fa fa-file-signature"></i> <span class="nav-label">Contracts</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('contract.index')}}">Contracts list</a></li>
                    <li><a href="{{route('student.index')}}">Students list</a></li>
                    <li><a href="{{route('student.createView')}}">New student</a></li> 
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-bed"></i> <span class="nav-label">Rooms</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('room.index')}}">Rooms list</a></li>
                    <li><a href="{{route('room.createView')}}">New room</a></li>
                    <li><a href="{{route('roomType.index')}}">Room types list</a></li>
                    <li><a href="{{route('roomType.createView')}}">New room type</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-lightbulb"></i> <span class="nav-label">Devices</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('device.index')}}">Devices list</a></li>
                    <li><a href="{{route('device.createView')}}">New device</a></li>
                    <li><a href="{{route('deviceType.index')}}">Device types list</a></li>
                    <li><a href="{{route('deviceType.createView')}}">New device type</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-file-invoice-dollar"></i> <span class="nav-label">Invoices</span><span class="fa arrow"></span></a>

                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('bill.index')}}">Invoices list</a></li>
                    <li><a href="{{route('bill.createView')}}">New invoice </a></li>
                    <li><a href="#">Payment Reminder</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class="fa fa-money-check-dollar"></i> <span class="nav-label">Costs</span><span class="fa arrow"></span></a>

                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="#">Electricity and water<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{route('bill.room.index')}}">List of E & W costs</a>
                            </li>
                            <li>
                                <a href="{{route('bill.room.createView')}}">New costs</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">equipment rental<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="{{route('deviceRental.index')}}">List of equipment rental costs</a>
                            </li>
                            <li>
                                <a href="{{route('deviceRental.createDeviceRental')}}">New costs</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @if($user->permission_id<=2)
            <li>
                <a href="#"><i class="fa fa-user-tag"></i> <span class="nav-label">Employees</span><span class="fa arrow"></span></a>

                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('employee.index')}}">Employees list</a></li>
                    <li><a href="{{route('employee.createView')}}">New employee</a></li>
                    <li><a href="{{route('position.index')}}">Positions list</a></li>
                    <li><a href="{{route('position.createView')}}">New position</a></li>
                </ul>
            </li>
            @if($user->permission_id==1)
            <li>
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Users</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('user.index')}}">Users list</a></li>
                    <li><a href="{{route('user.createView')}}">New user</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-user-shield"></i> <span class="nav-label">Permission</span><span class="fa arrow"></span></a>

                <ul class="nav nav-second-level collapse">
                    <li><a href="{{route('permission.index')}}">Permission list</a></li>
                    <li><a href="{{route('permission.createView')}}">New Permission</a></li>
                </ul>
            </li>
            @endif
           @endif
        </ul>

    </div>
</nav>