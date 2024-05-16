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
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Thông tin sinh viên</h2>
                                <img class="tw-w-[100px] tw-h-[100px] tw-rounded-full tw-my-3" src="{{ asset('uploads/avatars/'. $student->avatar) }}" alt="" class="img-thumbnail">
                                <dl class="dl-horizontal [&>*]:!tw-text-start [&>*]:tw-py-3">
                                    <dt>Mã sinh viên:</dt>
                                    <dd>{{ $student->student_id }}</dd>
                                    <dt>Tên sinh viên:</dt>
                                    <dd>{{ $student->name }}</dd>
                                    <dt>Lớp:</dt>
                                    <dd>{{ $student->class }}</dd>
                                    <dt>Ngày sinh:</dt>
                                    <dd>{{ $student->date_of_birth }}</dd>
                                    <dt>Giới tính:</dt>
                                    <dd>{{ $student->gender }}</dd>
                                    <dt>CMND:</dt>
                                    <dd>{{ $student->person_id }}</dd>
                                    <dt>Số điện thoại:</dt>
                                    <dd>{{ $student->phone_number }}</dd>
                                </dl>
                            </div>
                        </div>
    
                        <div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-mb-3">
                                <h2>Danh sách hợp đồng</h2>
                                <a href="{{route('contract.createView', $student->student_id)}}" class="btn btn-primary">Tạo hợp đồng</a>
                               
                            </div>
                            <div class="table-responsive tw-mt-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mã hợp đồng</th>
                                            {{-- <th>Phòng</th> --}}
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contracts as $contract)
                                            <tr>
                                                <td>{{ $contract->contract_id }}</td>
                                                {{-- <td>{{ $contract->room->room_name }}</td> --}}
                                                <td>{{ $contract->start_date }}</td>
                                                <td>{{ $contract->end_date }}</td>
                                                <td>{{ $contract->status }}</td>
                                                <td>
                                                    <a class="text-size-lg me-2" href="">
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
            </div>
        </div>
    </div>
</body>
</html>