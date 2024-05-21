<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Student list</h5>
                <div class="ibox-tools">
                    
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            
            <div class="ibox-content">
                <div class=" tw-my-4">
                    <a href="{{route('student.createView')}}" class="btn btn-primary">Create student</a>
                </div>  
                <div class="table-responsive">
                    <table id="studentTable" class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                        <thead>
                            <tr>
                                <th data-toggle="true">Student ID</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Class</th>
    
                                <th data-hide="all">Date of Birth</th>
                                <th data-hide="all">Gender</th>
                                <th data-hide="all">ID Card</th>
                                <th data-hide="all">Phone Number</th>
                                <th>Action</th>
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
</div>