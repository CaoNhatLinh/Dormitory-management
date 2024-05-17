
    <div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Danh sách các loại phòng</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Loại phòng</th>
                                        <th>Giá tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data["roomTypes"] as $roomType)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $roomType->room_type_name }}</td>
                                            <td>{{ number_format($roomType->room_type_price, 0, ',', '.') }} VNĐ</td>
                                            <td>
                                                <a class="text-size-lg me-2" href="{{route('roomType.editView', $roomType->room_type_id)}}">
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
