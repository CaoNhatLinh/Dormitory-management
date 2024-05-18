<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex justify-content-between align-items-center">
                    <h5>Danh sách thiết bị</h5>
                    <div class="search-container">
                        <form class="search-bar" action="{{ route('device.search') }}" method="GET">
                            <input type="text" name="keyword" class="form-control"
                                placeholder="Tìm kiếm thiết bị...">
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
                                    <th onclick="sortTable(0)">Mã thiết bị <i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(1)">Tên thiết bị <i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(2)">Số lượng <i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(3)">Giá gốc <i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(4)">Loại thiết bị <i class="fa fa-sort"></i></th>
                                    <th onclick="sortTable(5)">Số lượng cho thuê <i class="fa fa-sort"></i></th>
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
                                    <td>ddddđ</td>
                                    <td>
                                        <a class="text-size-lg me-2"
                                            href="{{route('device.editView', $device->device_id)}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="text-size-lg me-2"
                                            href="{{ route('device.delete', $device->device_id) }}"
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
