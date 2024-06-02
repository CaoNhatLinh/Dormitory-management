<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex justify-content-between align-items-center">
                    <h5>Device rental list</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="deviceTable"
                            class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                            <thead>
                                <tr class="title">
                                    <th>Device rental ID</i></th>
                                    <th>Rented room</i></th>
                                    <th>Total rental price</th>
                                    <th>Quantity</i></th>
                                    <th>Status</i></th>
                                    <th>Date device rental</i></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['deviceRentals'] as $deviceRental)
                                <tr>
                                    <td>{{ $deviceRental->device_rental_id }}</td>
                                    <td>{{ $deviceRental->room->room_name }}</td>
                                    <td>{{ $deviceRental->total_rental_price }}</td>
                                    <td>{{ $deviceRental->quantity }}</td>  
                                    <td>{{ $deviceRental->status }}</td>
                                    <td>{{ \Carbon\Carbon::parse($deviceRental->date_device_rental)->format('d-m-Y') }}</td>
                                    <td>
                                        <a class="text-size-lg me-2"
                                            href="{{route('deviceRental.editView', $deviceRental->device_rental_id)}}">
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