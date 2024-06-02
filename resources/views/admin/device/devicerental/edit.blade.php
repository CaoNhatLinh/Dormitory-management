<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Chỉnh sửa thiết bị thuê</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('deviceRental.edit', $deviceRental->device_rental_id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="room_id">Rented room</label>
                            <select id="room_id" name="room_id" class="form-control">
                                @foreach($rooms as $room)
                                    <option value="{{ $room->room_id }}" {{ $room->room_id == $deviceRental->room_id ? 'selected' : '' }}>
                                        {{ $room->room_name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('room_id'))
                                <span class="tw-text-red-500">{{ $errors->first('room_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="total_rental_price">Total rental price </label>
                            <input value="{{ $deviceRental->total_rental_price }}" type="number" id="total_rental_price" name="total_rental_price" class="form-control">
                            @if ($errors->has('total_rental_price'))
                                <span class="tw-text-red-500">{{ $errors->first('total_rental_price') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input value="{{ $deviceRental->quantity }}" type="number" id="quantity" name="quantity" class="form-control" min=0>
                            @if ($errors->has('quantity'))
                                <span class="tw-text-red-500">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input value="{{ $deviceRental->status }}" type="text" id="status" name="status" class="form-control">
                            @if ($errors->has('status'))
                                <span class="tw-text-red-500">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="date_device_rental">Date device rental </label>
                            <input value="{{ $deviceRental->date_device_rental }}" type="datetime-local" id="date_device_rental" name="date_device_rental" class="form-control">
                            @if ($errors->has('date_device_rental'))
                                <span class="tw-text-red-500">{{ $errors->first('date_device_rental') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Chỉnh sửa thiết bị thuê</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
