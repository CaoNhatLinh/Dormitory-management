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
    <title>Danh sách sinh viên</title>
</head>
<body>
    

<div class="tw-flex tw-items-center tw-justify-between tw-my-4">
    <h3>Danh sách sinh viên</h3>
    <a href="{{route('student.createView')}}" class="tw-bg-[#1ab394] tw-text-white tw-p-3 tw-rounded-lg tw-border-none">Thêm sinh viên</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Mã sinh viên</th>
            <th>Họ và tên</th>
            <th>Lớp</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>CMND</th>
            <th>Số điện thoại</th>
            <th>Avatar</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['students'] as $student) 
            <tr>
                <td style="vertical-align: middle;">{{ $student->student_id }}</td> 
                <td style="vertical-align: middle;">{{ $student->name }}</td>
                <td style="vertical-align: middle;">{{ $student->class }}</td>
                <td style="vertical-align: middle;">{{ $student->date_of_birth }}</td> 
                <td style="vertical-align: middle;">{{ $student->gender }}</td> 
                <td style="vertical-align: middle;">{{ $student->person_id }}</td> 
                <td style="vertical-align: middle;">{{ $student->phone_number }}</td> 
                <td style="vertical-align: middle;">
                    <img style="width: 50px; height: 50px;" class="rounded-circle" src="{{ asset('uploads/avatars/'. $student->avatar) }}" alt="">
                    {{-- <img style="width: 50px; height: 50px;" class="rounded-circle" src="{{ $student->avatar }}" alt=""> --}}
                </td> 
                <td style="vertical-align: middle;">
                    <a class="text-size-lg me-2" href="{{route('student.detailView', $student->student_id)}}">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="text-size-lg me-2" href="{{route('student.editView', $student->student_id)}}">
                        <i class="fa fa-edit"></i>
                    </a>
                    {{-- <a class="text-size-lg" href="">
                        <i class="fa fa-trash"></i>
                    </a> --}}
                </td> 
                
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>