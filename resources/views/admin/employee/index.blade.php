<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>The list of Employee</h5>
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
                                    <th data-toggle="true">Employee ID</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Avatar</th>
                                    <th data-hide="all">Person ID</th>
                                    <th data-hide="all">Gender</th>
                                    <th data-hide="all">Address</th>
                                    <th data-hide="all">Date</th>
                                    <th data-hide="all">Nationality</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data['employees'] as $employee) 
                                <tr>
                                    <td>{{ $employee->employee_id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->position_id }}</td>
                                    <td><img style="width: 50px; height: 50px;" class="rounded-circle" src="{{ asset('uploads/avatars/'. $employee->avatar) }}" alt="">
                    {{-- <img style="width: 50px; height: 50px;" class="rounded-circle" src="{{ $employee->avatar }}" alt=""> --}}</td>
                                    <td>{{ $employee->person_id }}</td>
                                    <td>{{ $employee->gender }}</td>
                                    <td>{{ $employee->address }}</td>
                                    <td>{{ $employee->date_of_birth }}</td>
                                    <td>{{ $employee->nationality }}</td>
                                    <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                                </tr>
                                
                                @endforeach
                                </tbody>
                                
                            </table>

                        </div>
        </div>
    </div>
</div>