<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Room list</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
                <div class="tw-my-4">
                    <a href="{{route('room.createView')}}" class="btn btn-primary">Create room</a>
                </div>
                <table class=" dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Room Name</th>
                            <th>Quantity</th>
                            <th>Occupancy</th>
                            <th>Room Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['rooms'] as $room)
                            <tr>
                                <td>{{ $room->room_id }}</td>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ $room->quantity }}</td>
                                <td>{{ $room->occupancy }}</td>
                                <td>{{ $room->roomType->room_type_name }}</td>
                                <td>
                                    @if ($room->status == 'active')
                                        <label class="label label-primary">{{ $room->status }}</label>
                                    @elseif ($room->status == 'repaired')
                                        <label class="label label-warning">{{ $room->status }}</label>
                                    @else 
                                        <label class="label label-danger">{{ $room->status }}</label>
                                    @endif
                                </td>
                                <td>
                                    <a class="text-size-lg me-2" href="{{route('room.editView', $room->room_id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                         @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>