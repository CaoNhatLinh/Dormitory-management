<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex justify-content-between align-items-center">
                    <h5>Danh sách thiết bị</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <div class="tw-my-4">
                            <a href="{{route('device.createView')}}" class="btn btn-primary">Create device</a>
                            <a href="{{route('device.createExcelView')}}" class="btn btn-primary">Import by excel</a>
                        </div>
                        <table id="deviceTable"
                            class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                            <thead>
                                <tr class="title">
                                    <th>Device ID</i></th>
                                    <th>Device Name</i></th>
                                    <th>Quantity</th>
                                    <th>Original Price</i></th>
                                    <th>Device Type</i></th>
                                    <th>Quantity Rented</i></th>
                                    <th>Action</th>
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
                                    <td>{{ $device->rental_quantity }}</td>
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