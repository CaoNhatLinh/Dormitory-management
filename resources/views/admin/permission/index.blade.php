<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>The list of Permission</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <button class="btn btn-primary dim btn-sm" data-toggle="modal" data-target="#modalCreate">
                        New Permission
                    </button>
                    <input type="text" class="form-control input-sm m-b-xs " id="filter" placeholder="Search in table">
                </div>

                <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                    <thead>
                        <tr>
                            <th>Permission ID</th>
                            <th>Permission name</th>
                            <th>Total User</th>
                            <th data-sort-ignore="true">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['permissions'] as $permission)
                        <tr class="gradeA">
                            <td>{{ $permission->permission_id }}</td>
                            <td>{{ $permission->permission_name }}</td>
                            <td class="center">{{ $permission->users_count }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary dim btn-sm" data-toggle="modal" data-target="#myModal" data-id="{{ $permission->permission_id }}" data-name="{{ $permission->permission_name }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="{{ route('permission.delete', $permission->permission_id) }}" onclick="return confirm('Are you sure you want to delete this permission?');">
                                        <button class="btn btn-danger dim btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('permission.edit')}}" method="post">
                            @csrf
                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Edit permission</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>permission Name</label>
                                        <input type="text" placeholder="permission Name" class="form-control" name="permission_name">
                                        @if ($errors->has('permission_name'))
                                        <span class="help-block m-b-none label label-warning" label label-warning>{{ $errors->first('permission_name') }}</span>
                                        @endif
                                        <input type="hidden" name="permission_id" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="modal inmodal" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('permission.create')}}" method="post">
                            @csrf
                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Create Permission</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Permission Name</label>
                                        <input type="text" placeholder="Permission Name" class="form-control" name="permission_name">
                                        @if ($errors->has('permission_name'))
                                        <span class="help-block m-b-none label label-warning" label label-warning>{{ $errors->first('permission_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>