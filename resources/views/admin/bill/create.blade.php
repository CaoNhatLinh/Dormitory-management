<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <form method="POST" action="{{ route('bill.create') }}" class="row">
            @csrf
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class=" control-label">Room</label>
                        <select class="form-control m-b" name="room_id" data-placeholder="Choose a room">
                            @foreach($rooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('room_id'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('room_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Payment for:</label>
                        <select class="form-control m-b" name="typePayment" data-placeholder="Choose a type payment">
                            <option value="billroom">Room</option>
                            <option value="EaW">Electricity & Water</option>
                            <option value="equipment">Equipment</option>
                        </select>
                        @if ($errors->has('typePayment'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('typePayment') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4" id="studentDropdownContainer" style="display: none;">
                    <div class="form-group">
                        <label class="control-label">Select Student:</label>
                        <select class="form-control m-b" name="student_id" data-placeholder="Choose a student">
                        </select>
                        <span id="studentErrorBlock" class="help-block m-b-none label label-warning"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Showbill</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>