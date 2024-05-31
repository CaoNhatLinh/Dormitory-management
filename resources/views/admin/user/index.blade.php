<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>The list of users</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <a href="{{ route('user.createView') }}"><button class="btn btn-primary dim btn-sm">
                            New User
                        </button></a>

                    <input type="text" class="form-control input-sm m-b-xs " id="filter" placeholder="Search in table">
                </div>

                <table class="footable table table-stripped dataTables-example" data-page-size="8" data-filter=#filter>
                    <thead>
                        <tr>
                            <th>User ID </th>
                            <th>Email</th>
                            <th>Full name</th>
                            <th>Permission name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['users'] as $user)
                        <tr class="gradeA">
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->email }}</td>
                            <td> {{ $user->employee->name }}</td>
                            <td>{{ $user->permission->permission_name }}</td>
                            <td>
                                <div class="btn-group">
                                   
                                    <a href="{{ route('user.editView',$user->user_id) }}"><button class="btn btn-primary dim btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('user.delete', $user->user_id) }}" onclick="return confirm('Are you sure you want to delete this user?');" ><button class="btn btn-danger dim btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('user.resetpassword', $user->user_id) }}" onclick="return confirm('Accept password reset for this account! The default password is \'123456\'?');" ><button class="btn btn-info dim btn-sm">
                                            reset password
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

            </div>
        </div>
    </div>
</div>