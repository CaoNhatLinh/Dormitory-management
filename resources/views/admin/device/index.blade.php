
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
                                        <th>Mã thiết bị</th>
                                        <th>Tên thiết bị</th>
                                        <th>Số lượng</th>
                                        <th>Giá gốc</th>
                                        <th>Loại thiết bị</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['devices'] as $device)
                                        <tr>
                                            <td>{{ $device->device_id }}</td>
                                            <td>{{ $device->device_name }}</td>
                                            <td>{{ $device->quantity }}</td>
                                            <td>{{ number_format($device->original_price, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $device->deviceType->device_type_name }}</td>
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
