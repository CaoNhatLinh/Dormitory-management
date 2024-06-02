<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Danh sách thiết bị</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="deviceTable"
                            class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                            <thead>
                                <tr class="title">
                                    <th>Device ID</th>
                                    <th>Device Name</th>
                                    <th>Quantity</th>
                                    <th>Original Price</th>
                                    <th>Device Type</th>
                                    <th>Quantity Rented</th>
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
                                        <a class="text-size-lg me-2 rent-btn" data-device-id="{{ $device->device_id }}"
                                            href="#">
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
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Thiết bị cho thuê</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <form id="rentalForm" action="{{route('device.rent')}}" method="POST">
                            @csrf
                            <table id="cartTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Device Name</th>
                                        <th>Quantity</th>
                                        <th>Sale Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cartBody">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                                        <td id="totalAmount">0 VNĐ</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="form-inline-end">
                                Select room: <select id="roomSelect" name="room_id" class="form-control me-2"></select>
                                <button type="submit" id="rentButton" class="btn btn-primary">Rent</button>
                                <input type="hidden" id="room_id" name="room_id">
                                <input type="hidden" id="totalAmountInput" name="total_amount"> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>