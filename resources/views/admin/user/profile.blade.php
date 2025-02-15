<div class="container">
    <div class="row">
        <div class="col-md-6 ">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>User Profile</h4>
                </div>
                <div class="panel-body">
                    <div class="box box-info">

                        <div class="box-body">
                            <div class="col-sm-6">
                                <div align="center"> <img alt="User Pic" src="{{ asset('uploads/avatars/'. $employee->avatar) }}" id="profile-image1" class="img-circle img-responsive">
                                </div>
                                <br>
                            </div>
                            <div class="col-sm-6">
                                <h4 style="color:#00b1b1;">{{ $employee->name }} </h4></span>
                                <span>
                                    <p>{{ $position_name}}</p>
                                </span>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="margin:5px 0 5px 0;">

                            <div class="col-sm-5 col-xs-6 tital ">Mail:</div>
                            <div class="col-sm-7">{{ $user->email }}</div>
                            <div class="clearfix"></div>
                            <div class="bot-border"></div>
                            <div class="col-sm-5 col-xs-6 tital ">Gender:</div>
                            <div class="col-sm-7">{{ $employee->gender }}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">Date Of Birth:</div>
                            <div class="col-sm-7">{{ $employee->date_of_birth }}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">Address:</div>
                            <div class="col-sm-7">{{ $employee->address }}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>

                            <div class="col-sm-5 col-xs-6 tital ">Nationality:</div>
                            <div class="col-sm-7">{{ $employee->nationality }}</div>

                            <div class="clearfix"></div>
                            <div class="bot-border"></div>


                            <!-- /.box-body -->
                        </div>


                    </div>


                </div>
            </div>
            <a class="btn-link font-bold" href="{{route('employee.editView', $employee->employee_id)}}">
                <button class="btn btn-primary btn-sm dim">
                    Edit info
                </button>
            </a>
            <a class="btn-link font-bold" href="{{ route('user.editView',$user->user_id) }}">
                <button class="btn btn-primary btn-sm dim">
                Edit account
                </button>
            </a>
            <a class="btn-link font-bold" href="{{ route('user.changepasswordView') }}">
                <button class="btn btn-primary btn-sm dim">
                Change password
                </button>
            </a>
        </div>

    </div>
</div>