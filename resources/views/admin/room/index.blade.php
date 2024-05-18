<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Danh sách phòng</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
                <table class=" dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                    <thead>
                        <tr>
                            <th>Mã phòng</th>
                            <th>Tên phòng</th>
                            <th>Số lượng</th>
                            <th>Sức chứa</th>
                            <th>Loại phòng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>


                            {{-- <th data-toggle="true">Mã sinh viên</th>
                            <th>Họ và tên</th>
                            <th>Lớp</th>

                            <th data-hide="all">Avatar</th>
                            <th data-hide="all">Ngày sinh</th>
                            <th data-hide="all">Giới tính</th>
                            <th data-hide="all">CMND</th>
                            <th data-hide="all">Số điện thoại</th>
                            <th>Thao tác</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['rooms'] as $room)
                            <tr>
                                <td>{{ $room->room_id }}</td>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ $room->quantity }}</td>
                                <td>{{ $room->occupancy }}</td>
                                <td>{{ $room->roomType->room_type_name }}</td>
                                <td>{{ $room->status }}</td>
                                <td>
                                    <a class="text-size-lg me-2" href="{{route('room.editView', $room->room_id)}}">
                                        <i class="fa fa-edit"></i>
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
<div class="row">
    <div class="col-lg-12">
        <div class="tw-flex tw-justify-end">
            <a href="{{route('room.createView')}}" class="btn btn-primary">Thêm phòng</a>
        </div>
    </div>
</div>



{{--     
    
    <div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Danh sách phòng</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mã phòng</th>
                                        <th>Tên phòng</th>
                                        <th>Số lượng</th>
                                        <th>Sức chứa</th>
                                        <th>Loại phòng</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['rooms'] as $room)
                                        <tr>
                                            <td>{{ $room->room_id }}</td>
                                            <td>{{ $room->room_name }}</td>
                                            <td>{{ $room->quantity }}</td>
                                            <td>{{ $room->occupancy }}</td>
                                            <td>{{ $room->roomType->room_type_name }}</td>
                                            <td>{{ $room->status }}</td>
                                            <td>
                                                <a class="text-size-lg me-2" href="{{route('room.editView', $room->room_id)}}">
                                                    <i class="fa fa-edit"></i>
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
    </div>

 --}}
