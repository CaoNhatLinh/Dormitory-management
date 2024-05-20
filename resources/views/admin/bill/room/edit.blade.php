<div class="row tw-mt-5">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Cập nhật hóa đơn phòng</h5>
            </div>
            <div class="ibox-content">
                <form action="{{ route('bill.room.edit', $roomBill->room_bill_id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="room_id">Phòng</label>
                        <select id="room_id" name="room_id" class="form-control">

                            @foreach($rooms as $room)
                                <option value="{{ $room->room_id }}" {{ $room->room_id == $roomBill->room_id ? 'selected' : '' }}>
                                    {{ $room->room_name }} - {{ number_format($room->roomType->room_type_price, 0, ',', '.') }} VNĐ
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('room_id'))
                            <span class="tw-text-red-500">{{ $errors->first('room_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="electricity_price">Giá điện</label>
                        <input value="{{$roomBill->electricity_price}}" type="number" name="electricity_price" class="form-control">
                        @if ($errors->has('electricity_price'))
                            <span class="tw-text-red-500">{{ $errors->first('electricity_price') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="water_price">Giá nước</label>
                        <input value="{{$roomBill->water_price}}" type="number" name="water_price" class="form-control">
                        @if ($errors->has('water_price'))
                            <span class="tw-text-red-500">{{ $errors->first('water_price') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select id="status" name="status" class="form-control">
                            @foreach($statuses as $key => $status)
                                <option value="{{ $key }}" {{ $key == $roomBill->status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach 
                        </select>
                        @if ($errors->has('status'))
                            <span class="tw-text-red-500">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="water_index">Chỉ số nước</label>
                        <input value="{{$roomBill->water_index}}" type="number" name="water_index" class="form-control">
                        @if ($errors->has('water_index'))
                            <span class="tw-text-red-500">{{ $errors->first('water_index') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="electricity_index">Chỉ số điện</label>
                        <input value="{{$roomBill->electricity_index}}" type="number" name="electricity_index" class="form-control">
                        @if ($errors->has('electricity_index'))
                            <span class="tw-text-red-500">{{ $errors->first('electricity_index') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa hóa đơn phòng</button>
                </form>
            </div>
        </div>
    </div>
</div>