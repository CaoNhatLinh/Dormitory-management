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
            @if(count($billEquiments) > 0)
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
                                        <th>Device name</th>
                                        <th>Status</th>
                                        <th>Origin Price</th>
                                        <th>Rental price</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($billEquiments as $billEquipment)
                                        @foreach($billEquipment->rentalDetails as $detail)
                                        <tr>
                                            <td>
                                                <div><strong>{{$detail->device->device_name}}</strong></div>
                                            <td>{{$detail->status}}</td>
                                            <td>{{number_format($detail->device->original_price, 0, ',', '.')}} VNĐ</td>
                                            <td>{{number_format($detail->rental_price, 0, ',', '.')}} VNĐ</td>
                                            <td>@if($detail->status!='good') {{number_format($detail->device->original_price + $detail->rental_price, 0, ',', '.')}} VNĐ
                                                @else {{number_format($detail->rental_price, 0, ',', '.')}} VNĐ
                                                @endif  
                                            </td> 
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        <table class="table invoice-total">
                            <tbody>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <?php
                                    $totalEquipmentBill = 0;

                                    foreach($billEquiments as $billEquipment) {
                                        $totalEquipmentBill += $billEquipment->total_rental_price;
                                    }
                                    ?>
                                    <td>{{number_format($totalEquipmentBill, 0, ',', '.')}} VNĐ</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="text-right">
                            <a href="{{ route('bill.equipmentPay',$billEquiments->first()->room_id) }}"><button class="btn btn-primary"><i class="fa fa-dollar"></i>Make payment and continue renting </button></a>
                            <a href="{{ route('bill.equipmentPayCancel',$billEquiments->first()->room_id) }}"><button class="btn btn-primary"><i class="fa fa-dollar"></i>Make A Payment and cancel</button></a>
                        </div>
                    </div>
                </div>
                @else
                <div class="well m-t"><strong>Comments:</strong>
                <label class="text-success">This room has paid equiments bills!</label>
            </div>
            @endif
            </div>
        </div>
</div>