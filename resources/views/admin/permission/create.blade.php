<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Add new permission </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
                <form method="POST" action="{{ route('permission.create') }}" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Permission name</label>
                        <div class="col-sm-10"><input type="text" name="permission_name" id="permission_name" placeholder="Permission name" class="form-control" required>
                            @if ($errors->has('permission_name'))
                            <span class="help-block m-b-none label label-warning">{{ $errors->first('permission_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary dim btn-sm" type="submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>