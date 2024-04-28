<h1>Danh sách sinh viên</h1>

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
                
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student) 
                <tr>
                    <td>{{ $student->student_id }}</td> 
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->date_of_birth }}</td> 
                    <td>{{ $student->gender }}</td> 
                    <td>{{ $student->person_id }}</td> 
                    <td>{{ $student->phone_number }}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>