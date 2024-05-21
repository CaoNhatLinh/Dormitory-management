<div class="row tw-mt-5">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Room bill list</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
                <table class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Electricity Price</th>
                            <th>Water Price</th>
                            <th>Electricity Index</th>
                            <th>Water Index</th>
                            <th>Status</th>
                            <th>Total Bill</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roomBills as $roomBill)
                            <tr>
                                <td>{{ $roomBill->room->room_name }}</td>
                                <td>{{ $roomBill->bill_date }}</td>
                                <td>{{ number_format($roomBill->electricity_price, 0, ',', '.') }} VNĐ</td>
                                <td>{{ number_format($roomBill->water_price, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $roomBill->electricity_index }}</td>
                                <td>{{ $roomBill->water_index }}</td>
                                <td>
                                    @if ($roomBill->status == 'unpaid')
                                        <label class="label label-danger">{{ $roomBill->status }}</label>
                                    @else 
                                        <label class="label label-primary">{{ $roomBill->status }}</label>
                                    @endif
                                </td>
                                <td>{{ number_format($roomBill->total_room_bills, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    <a class="text-size-lg me-2" href="{{ route('bill.room.editView',  $roomBill->room_bill_id) }}">
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
        <div class="tw-flex tw-items-center tw-justify-end">
            <a href="{{route('bill.room.createView')}}" class="btn btn-default tw-me-3">Create room bill</a>
            <a href="{{route('bill.room.createExcelView')}}" class="btn btn-primary">
                <i class="fa fa-file-excel-o"></i>
                &nbsp;
                Import Excel
            </a>
        </div>
    </div>
</div>
