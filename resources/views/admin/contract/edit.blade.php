
<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Chỉnh sửa hợp đồng</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('contract.edit', $contract->contract_id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="student_id">Mã sinh viên</label>
                            <input value="{{$contract->student_id}}" disabled type="text" id="student_id" name="student_id" class="form-control">
                            @if ($errors->has('student_id'))
                                <span class="tw-text-red-500">{{ $errors->first('student_id') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Phòng hiện tại</label>
                                    <input class="form-control" type="text" value="{{ $contract->room->room_name }} - {{ number_format($contract->room->roomType->room_type_price, 0, ',', '.') }} VNĐ" disabled id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="room_id">Đổi phòng mới</label>
                                    @if ($contract->status == "renting")
                                        <select id="room_id" name="room_id" class="form-control">
                                            <option value="">Chọn phòng</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->room_id }}">{{ $room->room_name }} - {{ number_format($room->roomType->room_type_price, 0, ',', '.') }} VNĐ</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select id="room_id" name="room_id" class="form-control" disabled>
                                            <option value="">Chọn phòng</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->room_id }}">{{ $room->room_name }} - {{ number_format($room->roomType->room_type_price, 0, ',', '.') }} VNĐ</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            @if ($errors->has('room_id'))
                                <span class="tw-text-red-500">{{ $errors->first('room_id') }}</span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="start_date">Ngày bắt đầu</label>
                            <input disabled value="{{$contract->start_date}}" type="date" class="form-control" id="start_date" name="start_date">
                            @if ($errors->has('start_date'))
                                <span class="tw-text-red-500">{{ $errors->first('start_date') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="end_date">Ngày kết thúc</label>
                            <input disabled value="{{$contract->end_date}}" type="date" class="form-control" id="end_date" name="end_date">
                            @if ($errors->has('end_date'))
                                <span class="tw-text-red-500">{{ $errors->first('end_date') }}</span>
                            @endif
                        </div>
                       
                        
                        <div class="tw-flex tw-items-center tw-justify-between">
                            @if ($contract->status == "renting")
                                <button type="submit" class="btn btn-primary" value="edit" name="action">Chỉnh sửa hợp đồng</button>
                                <button type="submit" class="btn btn-danger tw-mt-3" value="cancel" name="action">Hủy hợp đồng</button>
                            @endif

                            @if ($contract->status != "renting")
                                <button type="button" class="btn btn-primary"  disabled>Chỉnh sửa hợp đồng</button>
                                <button type="button" class="btn btn-danger tw-mt-3" disabled>Hủy hợp đồng</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
