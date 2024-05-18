
<div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Chỉnh sửa thiết bị</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('device.edit', $device->device_id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="device_name">Tên thiết bị</label>
                                <input value="{{$device->device_name}}" type="text" id="device_name" name="device_name" class="form-control">
                                @if ($errors->has('device_name'))
                                    <span class="tw-text-red-500">{{ $errors->first('device_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="occupancy">Số lượng</label>
                                <input value="{{$device->quantity}}" type="number" id="quantity" name="quantity" class="form-control" min=0>
                                @if ($errors->has('quantity'))
                                    <span class="tw-text-red-500">{{ $errors->first('occupancy') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="original_price">Giá gốc</label>
                                <input value="{{$device->original_price}}" type="number" id="original_price" name="original_price" class="form-control">
                                @if ($errors->has('original_price'))
                                    <span class="tw-text-red-500">{{ $errors->first('original_price') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="device_type_id">Loại thiết bị</label>
                                <select id="device_type_id" name="device_type_id" class="form-control">
                                    @foreach($deviceTypes as $deviceType)
                                        <option value="{{ $deviceType->device_type_id }}" {{ $deviceType->device_type_id == $device->device_type_id ? 'selected' : '' }}>
                                            {{ $deviceType->device_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('device_type_id'))
                                    <span class="tw-text-red-500">{{ $errors->first('device_type_id') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa thiết bị</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
