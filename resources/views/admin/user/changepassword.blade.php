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
                <form method="POST" action="{{ route('user.changepassword', $user->user_id) }}" class="form-horizontal">
                    @csrf
                    <div class="form-group"><label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" id="password" placeholder="password" class="form-control" required>
                            @if ($errors->has('password'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('password') }}</span>
                        @endif
                        </div>
                       
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Re-enter Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="repassword" id="repassword" placeholder="repassword" class="form-control" required>
                            @if ($errors->has('repassword'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('repassword') }}</span>
                        @endif
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white btn-outline btn-link"><a href="{{route('user.profileView')}}">Cancel</a></button>
                            <button class="btn btn-primary" type="submit">Change password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>