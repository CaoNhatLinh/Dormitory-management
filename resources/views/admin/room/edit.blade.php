
<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Edit room</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('room.edit', $room->room_id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="room_name">Room name</label>
                            <input value="{{$room->room_name}}" type="text" id="room_name" name="room_name" class="form-control">
                            @if ($errors->has('room_name'))
                                <span class="tw-text-red-500">{{ $errors->first('room_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="occupancy">Occupancy</label>
                            <input value="{{$room->occupancy}}" type="number" id="occupancy" name="occupancy" class="form-control">
                            @if ($errors->has('occupancy'))
                                <span class="tw-text-red-500">{{ $errors->first('occupancy') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input value="{{$room->quantity}}" type="number" id="quantity" name="quantity" class="form-control">
                            @if ($errors->has('quantity'))
                                <span class="tw-text-red-500">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="room_type_id">Room type</label>
                            <select id="room_type_id" name="room_type_id" class="form-control">
                                @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->room_type_id }}" {{ $roomType->room_type_id == $room->room_type_id ? 'selected' : '' }}>
                                        {{ $roomType->room_type_name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('room_type_id'))
                                <span class="tw-text-red-500">{{ $errors->first('room_type_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            {{-- <input value="{{$room->status}}"  type="text" id="status" name="status" class="form-control"> --}}
                            <select id="status" name="status" class="form-control">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ $status == $room->status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach 
                             </select>
                            @if ($errors->has('status'))
                                <span class="tw-text-red-500">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Edit room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
