
<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Import by Excel</h5>
                </div>
                
                <div class="ibox-content">
                    <form class="tw-mt-5 tw-mb-10" action="{{route('bill.room.loadExcel')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="excel_room_bill">Upload excel file</label>
                            <div class="tw-flex tw-items-center">
                                <input accept=".xlsx, .xls, .csv" type="file" name="excel_room_bill" class="tw-flex-1 form-control">
                                <button type="submit" class="btn btn-primary">Load excel</button>
                            </div>
                        </div>
                        
                    </form>
                    @if(!empty($excel_room_bills)) 
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th>Room</th>
                                    <th>Date</th>
                                    <th>Electricity Price</th>
                                    <th>Water Price</th>
                                    <th>Electricity Index</th>
                                    <th>Water Index</th>
                                    <th>Status</th>
                                    <th>Total Bill</th>
                                </thead>
                                <tbody>
                                    @foreach($excel_room_bills as $row)
                                        <tr>
                                            <td>{{ $row['room_id'] }}</td>
                                            <td>{{ \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['bill_date'])->format('Y-m-d') }}</td>
                                            <td>{{ number_format($row['electricity_price'], 0, ',', '.') }} VNĐ</td>
                                            <td>{{ number_format($row['water_price'], 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $row['electricity_index'] }}</td>
                                            <td>{{ $row['water_index'] }}</td>
                                            <td>{{ $row['status'] }}</td>
                                            <td>{{ number_format($row['total_room_bills'], 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
