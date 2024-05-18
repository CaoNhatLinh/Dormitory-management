<div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thêm loại thiết bị</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('deviceType.create') }}">
                            @csrf
                            <div class="form-group">
                                <label for="device_type_name">Tên loại thiết bị</label>
                                <input type="text" id="device_type_name" name="device_type_name" class="form-control">
    
                                @if ($errors->has('device_type_name'))
                                    <span class="tw-text-red-500">{{ $errors->first('device_type_name') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm loại thiết bị</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
