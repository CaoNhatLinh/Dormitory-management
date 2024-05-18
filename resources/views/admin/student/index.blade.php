<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Danh sách sinh viên</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
                <table class=" dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                    <thead>
                        <tr>
                            {{-- <th data-toggle="true">Employee ID</th>
                            <th>Name</th>

                            <th>Position</th>
                            <th>Status</th>
                            <th data-hide="all">Person ID</th>
                            <th data-hide="all">Gender</th>
                            <th data-hide="all">Address</th>
                            <th data-hide="all">Date</th>
                            <th data-hide="all">Nationality</th>
                            <th>Action</th> --}}


                            <th data-toggle="true">Mã sinh viên</th>
                            <th>Avatar</th>
                            <th>Họ và tên</th>
                            <th>Lớp</th>

                            <th data-hide="all">Ngày sinh</th>
                            <th data-hide="all">Giới tính</th>
                            <th data-hide="all">CMND</th>
                            <th data-hide="all">Số điện thoại</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['students'] as $student) 
                            <tr>
                                <td style="vertical-align: middle;">{{ $student->student_id }}</td> 
                                <td style="vertical-align: middle;">
                                    <img style="width: 50px; height: 50px;" class="rounded-circle" src="{{ asset('uploads/avatars/'. $student->avatar) }}" alt="">
                                   
                                </td> 
                                <td style="vertical-align: middle;">{{ $student->name }}</td>
                                <td style="vertical-align: middle;">{{ $student->class }}</td>
                                <td style="vertical-align: middle;">{{ $student->date_of_birth }}</td> 
                                <td style="vertical-align: middle;">{{ $student->gender }}</td> 
                                <td style="vertical-align: middle;">{{ $student->person_id }}</td> 
                                <td style="vertical-align: middle;">{{ $student->phone_number }}</td> 
                               
                                <td style="vertical-align: middle;">
                                    <a class="text-size-lg me-2" href="{{route('student.detailView', $student->student_id)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="text-size-lg me-2" href="{{route('student.editView', $student->student_id)}}">
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
<div class="row">
    <div class="col-lg-12">
        <div class="tw-flex tw-justify-end">
            <a href="{{route('student.createView')}}" class="btn btn-primary">Thêm sinh viên</a>
        </div>
    </div>
</div>

    