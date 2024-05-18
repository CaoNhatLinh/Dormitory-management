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
                            <th>Status</th>
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
                            <td>{{ $employee->position->position_name }}</td>
                            <td>{{ $employee->status }}</td>
                            <td>{{ $employee->person_id }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->date_of_birth }}</td>
                            <td>{{ $employee->nationality }}</td>
                            <td>
                                <a class="text-size-lg me-2" href="{{route('employee.editView', $employee->employee_id)}}"><i class="fa  fa fa-eye"></i></a>
                                <a class="text-size-lg me-2" href="#"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>
                                                                        </div>