
    <div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tạo hợp đồng</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('contract.create', $student_id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="student_id">Mã sinh viên</label>
                                <input value="{{$student_id}}" disabled type="text" id="student_id" name="student_id" class="form-control">
                                @if ($errors->has('student_id'))
                                    <span class="tw-text-red-500">{{ $errors->first('student_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="room_id">Phòng</label>
                                <select id="room_id" name="room_id" class="form-control">
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->room_id }}">{{ $room->room_name }} - {{ number_format($room->roomType->room_type_price, 0, ',', '.') }} VNĐ</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('room_id'))
                                    <span class="tw-text-red-500">{{ $errors->first('room_id') }}</span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="start_date">Ngày bắt đầu</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                                @if ($errors->has('start_date'))
                                    <span class="tw-text-red-500">{{ $errors->first('start_date') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="end_date">Ngày kết thúc</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                                @if ($errors->has('end_date'))
                                    <span class="tw-text-red-500">{{ $errors->first('end_date') }}</span>
                                @endif
                            </div>
                           
                            
                            <button type="submit" class="btn btn-primary">Tạo hợp đồng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
