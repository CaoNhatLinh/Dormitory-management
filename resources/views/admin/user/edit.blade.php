<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Edit User </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
                <form method="POST" action="{{ route('user.edit', $user->user_id) }}" enctype="multipart/form-data" class="form-horizontal">
                    @csrf 
                    <div class="form-group"><label class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10"><input value="{{ $user->email }}" type="email" name="email" id="email" placeholder="Email" class="form-control" required></div>
                        @if ($errors->has('email'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                   
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Permission</label>

                        <div class="col-sm-10">
                            <select class="form-control m-b" name="permission_id" data-placeholder="Choose a permission">
                                @foreach($permissions as $permission)
                                <option value="{{ $permission->permission_id }}" {{ $permission->permission_id == '$permission->permission_id' ? 'selected' : '' }}>{{ $permission->permission_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('permission_id'))
                            <span class="help-block m-b-none label label-warning">{{ $errors->first('permission_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Employee</label>

                        <div class="col-sm-10">
                            <select class="form-control m-b" name="employee_id" data-placeholder="Choose a permission">
                                @foreach($employees as $employee)
                                <option value="{{ $employee->employee_id }}" {{ $employee->employee_id == '$employee->employee_id' ? 'selected' : '' }}>{{ $employee->employee_id }}-{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('employee_id'))
                            <span class="help-block m-b-none label label-warning">{{ $errors->first('employee_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white btn-outline btn-link"><a href="{{route('user.index')}}">Cancel</a></button>
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>