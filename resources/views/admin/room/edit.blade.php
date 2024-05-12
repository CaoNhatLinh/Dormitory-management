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
                        <h5>Chỉnh sửa phòng</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" action="{{ route('room.edit', $room->room_id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="room_name">Tên phòng</label>
                                <input value="{{$room->room_name}}" type="text" id="room_name" name="room_name" class="form-control">
                                @if ($errors->has('room_name'))
                                    <span class="tw-text-red-500">{{ $errors->first('room_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="occupancy">Sức chứa</label>
                                <input value="{{$room->occupancy}}" type="number" id="occupancy" name="occupancy" class="form-control">
                                @if ($errors->has('occupancy'))
                                    <span class="tw-text-red-500">{{ $errors->first('occupancy') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input value="{{$room->quantity}}" type="number" id="quantity" name="quantity" class="form-control">
                                @if ($errors->has('quantity'))
                                    <span class="tw-text-red-500">{{ $errors->first('quantity') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="room_type_id">Loại phòng</label>
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
                                <label for="status">Trạng thái</label>
                                <input value="{{$room->status}}"  type="text" id="status" name="status" class="form-control">
                                @if ($errors->has('status'))
                                    <span class="tw-text-red-500">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa phòng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>