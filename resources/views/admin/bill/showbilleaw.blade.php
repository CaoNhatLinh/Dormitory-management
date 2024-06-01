<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <form method="POST" action="{{ route('bill.create') }}" class="row">
            @csrf
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class=" control-label">Room</label>
                        <select class="form-control m-b" name="room_id" data-placeholder="Choose a room">
                            @foreach($rooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('room_id'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('room_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Payment for:</label>
                        <select class="form-control m-b" name="typePayment" data-placeholder="Choose a type payment">
                            <option value="billroom">Room</option>
                            <option value="EaW">Electricity & Water</option>
                            <option value="equipment">Equipment</option>
                        </select>
                        @if ($errors->has('typePayment'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('typePayment') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4" id="studentDropdownContainer" style="display: none;">
                    <div class="form-group">
                        <label class="control-label">Select Student:</label>
                        <select class="form-control m-b" name="student_id" data-placeholder="Choose a student">
                        </select>
                        <span id="studentErrorBlock" class="help-block m-b-none label label-warning"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Showbill</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
    <div class="row">
        <div class="col-lg-12">
            @if(count($billEaWs) > 0)
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="ibox-content p-xl">
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>Kí Túc Xá Trường ĐH Công Nghiệp Thực Phẩm TP.HCM</strong><br>
                                102-104-106, Nguyễn Quý Anh<br>
                                Tân Sơn Nhì, Tân Phú, Thành phố Hồ Chí Minh<br>
                                <abbr title="Phone"><i class="fa fa-phone"></i></abbr> (028) 3810 6015
                            </address>
                        </div>

                        <div class="col-sm-6 text-right">
                            <p>
                                <span><strong>Invoice Date:</strong> Marh 18, 2014</span><br />
                                <span><strong>Due Date:</strong> March 24, 2014</span>
                            </p>
                        </div>
                    </div>

                    <div class="table-responsive m-t">
                        <table class="table invoice-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Electricity index</th>
                                    <th>Electricity price</th>
                                    <th>Water index</th>
                                    <th>Water Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($billEaWs as $billEaW)
                                <tr>
                                    <td>{{$billEaW->bill_date}}
                                    <td>{{$billEaW->electricity_index}}</td>
                                    <td>{{number_format($billEaW->electricity_price, 0, ',', '.')}} VNĐ</td>
                                    <td>{{$billEaW->water_index}}</td>{{number_format($billEaW->water_price, 0, ',', '.')}}
                                    <td>{{number_format($billEaW->water_price, 0, ',', '.')}} VNĐ</td>
                                    <td>{{number_format($billEaW->total_room_bills, 0, ',', '.')}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <table class="table invoice-total">
                        <tbody>
                            <tr>
                                <td><strong>TOTAL :</strong></td>
                                <td>
                                    <?php
                                    $totalRoomBills = 0;

                                    foreach ($billEaWs as $billEaW) {
                                        $totalRoomBills += $billEaW->total_room_bills;
                                    }
                                    ?>
                                    {{number_format($totalRoomBills, 0, ',', '.')}} VNĐ
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <a href="{{ route('bill.eawPay',$billEaWs->first()->room_id) }}"><button class="btn btn-primary"><i class="fa fa-dollar"></i>Make A Payment</button></a>
                    </div>
                </div>
            </div>
            @else <div class="well m-t"><strong>Comments:</strong>
                <label class="text-success">This room has paid electricity and water bills!</label>
            </div>
            @endif
        </div>
    </div>
</div>