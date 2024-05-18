
<div class="tw-mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Danh sách các loại thiết bị</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Device type</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data["deviceTypes"] as $deviceType)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $deviceType->device_type_name }}</td>
                                                <!-- <td>
                                                    <a class="text-size-lg me-2" href="{{route('deviceType.editView', $deviceType->device_type_id)}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td> -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
