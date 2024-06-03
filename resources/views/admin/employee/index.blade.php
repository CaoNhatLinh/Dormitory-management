<div class="wrapper wrapper-content animated fadeInRight ecommerce">
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
                    <a class="btn-link font-bold" href="{{ route('employee.createView') }}">
                        <button class="btn btn-primary btn-sm dim">
                            New Employee
                        </button>
                    </a>
                    <table class="footable table table-stripped toggle-arrow-tiny dataTables-example" data-page-size="15">
                        <thead>
                            <tr>
                                <th data-toggle="true">Employee ID</th>
                                <th data-hide="phone">Name</th>
                                <th data-hide="phone">Position</th>
                                <th data-hide="phone">Status</th>
                                <th data-hide="all">Person ID</th>
                                <th data-hide="all">Gender</th>
                                <th data-hide="all">Address</th>
                                <th data-hide="all">Date</th>
                                <th data-hide="all">Nationality</th>
                                <th data-sort-ignore="true">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if($data['employees']!=null)
                            @foreach ($data['employees'] as $employee)
                            <tr>
                                <td>{{ $employee->employee_id }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position->position_name ?? 'null'}}</td>

                                <td>
                                    @if ($employee->status == 'Working' )
                                    <label class="label label-primary">{{ $employee->status }}</label>
                                    @elseif ($employee->status == 'Terminated' )
                                    <label class="label label-danger">{{ $employee->status }}</label>
                                    @elseif ($employee->status == 'On Leave' )
                                    <label class="label label-warning">{{ $employee->status }}</label>
                                    @endif
                                </td>
                                <td>{{ $employee->person_id }}</td>
                                <td>{{ $employee->gender }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>{{ $employee->date_of_birth }}</td>
                                <td>{{ $employee->nationality }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="me-2" href="{{route('employee.detailView', $employee->employee_id)}}">
                                            <button class="btn btn-outline btn-primary dim btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                        <a class=" me-2" href="{{route('employee.editView', $employee->employee_id)}}">
                                            <button class="btn btn-outline btn-primary dim btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>