<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex justify-content-between align-items-center">
                    <h5>Danh sách thiết bị</h5>
                    <div class="search-container">
                        <form class="search-bar" action="{{ route('device.search') }}" method="GET">
                            <input type="text" name="keyword" class="form-control"
                                placeholder="Search user...">
                            <button type="submit" class="search-icon fa fa-search"></button>
                        </form>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="deviceTable"
                            class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                            <thead>
                                <tr class="title">
                                    <th onclick="sortTable(0)">User ID <i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(1)">Email <i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(2)">Full name<i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(3)">Permission name <i class="fa fa-sort"></i></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['users'] as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->employee->name }}</td>
                                    <td>{{ $user->permission->permission_name }}</td>
                                    <td>
                                        <a class="text-size-lg me-2"
                                            href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="text-size-lg me-2"
                                            href="#"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa thiết bị này không?');">
                                            <i class="fa  fa-trash"></i>
                                        </a>
                                        <a class="text-size-lg me-2" href="#">
                                            <img style="width:24px;height:24px;margin-bottom:8px"
                                                src="{{ asset('images/rent.png') }}" alt="">
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
