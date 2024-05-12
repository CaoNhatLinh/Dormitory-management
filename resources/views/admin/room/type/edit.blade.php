<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false, // Set preflight to false to disable default styles
            },
        }
      </script>
    <title>Document</title>
</head>
<body>
    <div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Tạo loại phòng</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('roomType.edit', $roomType->room_type_id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="room_type_name">Tên loại phòng</label>
                                <input value="{{$roomType->room_type_name}}" type="text" id="room_type_name" name="room_type_name" class="form-control">
    
                                @if ($errors->has('room_type_name'))
                                    <span class="tw-text-red-500">{{ $errors->first('room_type_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="room_type_price">Giá tiền</label>
                                <input value="{{$roomType->room_type_price}}" type="text" id="room_type_price" name="room_type_price" class="form-control">
                                @if ($errors->has('room_type_price'))
                                    <span class="tw-text-red-500">{{ $errors->first('room_type_price') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa loại phòng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>