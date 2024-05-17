
    <div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tạo phòng</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('room.create') }}">
                            @csrf
                            <div class="form-group">
                                <label for="room_name">Tên phòng</label>
                                <input type="text" id="room_name" name="room_name" class="form-control">
                                @if ($errors->has('room_name'))
                                    <span class="tw-text-red-500">{{ $errors->first('room_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="occupancy">Sức chứa</label>
                                <input type="number" id="occupancy" name="occupancy" class="form-control">
                                @if ($errors->has('occupancy'))
                                    <span class="tw-text-red-500">{{ $errors->first('occupancy') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input type="number" id="quantity" name="quantity" class="form-control">
                                @if ($errors->has('quantity'))
                                    <span class="tw-text-red-500">{{ $errors->first('quantity') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="room_type_id">Loại phòng</label>
                                <select id="room_type_id" name="room_type_id" class="form-control">
                                    @foreach($roomTypes as $roomType)
                                        <option value="{{ $roomType->room_type_id }}">{{ $roomType->room_type_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('room_type_id'))
                                    <span class="tw-text-red-500">{{ $errors->first('room_type_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Trạng thái</label>
                                <select id="status" name="status" class="form-control">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}">
                                            {{ $status }}
                                        </option>
                                    @endforeach 
                                </select>
                                {{-- <input type="text" id="status" name="status" class="form-control"> --}}
                                @if ($errors->has('status'))
                                    <span class="tw-text-red-500">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Tạo phòng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
