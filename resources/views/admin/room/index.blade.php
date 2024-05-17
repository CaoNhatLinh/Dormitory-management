
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
