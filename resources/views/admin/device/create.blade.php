<div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thêm thiết bị</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('device.create') }}">
                            @csrf
                            <div class="form-group">
                                <label for="device_name">Tên thiết bị</label>
                                <input type="text" id="device_name" name="device_name" class="form-control">
                                @if ($errors->has('device_name'))
                                    <span class="tw-text-red-500">{{ $errors->first('device_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" min=1>
                                @if ($errors->has('quantity'))
                                    <span class="tw-text-red-500">{{ $errors->first('quantity') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="original_price">Giá gốc</label>
                                <input type="number" id="original_price" name="original_price" class="form-control" min =0>
                                @if ($errors->has('original_price'))
                                    <span class="tw-text-red-500">{{ $errors->first('original_price') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="device_type_id">Loại thiết bị</label>
                                <select id="device_type_id" name="device_type_id" class="form-control">
                                    @foreach($deviceTypes as $deviceType)
                                        <option value="{{ $deviceType->device_type_id }}">{{ $deviceType->device_type_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('device_type_id'))
                                    <span class="tw-text-red-500">{{ $errors->first('device_type_id') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm thiết bị</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function hidePlaceholder() {
        var placeholder = document.querySelector('#device_type_id option[value=""]');
        if (placeholder) {
            placeholder.style.display = 'none';
        }
    }
</script>