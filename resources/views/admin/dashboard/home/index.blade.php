<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="app-body-main-content">
        <section class="service-section">
            <div class="tiles">
                <article class="tile">
                    <div class="tile-header">
                        <h3>
                            <span>{{ $totalContracts }}</span>
                            <span>Total Contracts</span>
                        </h3>
                        <i class="fa fa-file-signature"></i>
                    </div>
                    <a href="{{route('contract.index')}}">
                        <span>Go to Contracts</span>
                        <span class="icon-button">
                            <i class="fa fa-arrow-right"></i>
                        </span>
                    </a>
                </article>
                <article class="tile">
                    <div class="tile-header">

                        <h3>
                            <span>{{ $totalStudents }}</span>
                            <span>Total Students</span>
                        </h3>
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <a href="{{route('student.index')}}">
                        <span>Go to Students</span>
                        <span class="icon-button">
                            <i class="fa fa-arrow-right"></i>
                        </span>
                    </a>
                </article>
                <article class="tile">
                    <div class="tile-header">

                        <h3>
                            <span>{{ $totalRooms }}</span>
                            <span>Total Rooms</span>
                        </h3>
                        <i class="fa fa-house"></i>
                    </div>
                    <a href="{{route('room.index')}}">
                        <span>Go to rooms</span>
                        <span class="icon-button">
                            <i class="fa fa-arrow-right"></i>
                        </span>

                        </span>
                    </a>
                </article>
                <article class="tile">
                    <div class="tile-header">
                        <h3>
                            <span>{{ $totalDevices }}</span>
                            <span>Total Devices</span>
                        </h3>
                        <i class="fa fa-toolbox"></i>

                    </div>
                    <a href="{{route('device.index')}}">
                        <span>Go to Devices</span>
                        <span class="icon-button">
                            <i class="fa fa-arrow-right"></i>
                        </span>
                    </a>
                </article>
                <article class="tile">
                    <div class="tile-header">
                        <h3>
                            <span>{{ number_format($totalBills, 0, ',', '.') }} VNĐ </span>
                            <span>Total bills</span>
                        </h3>
                        <i class="fa fa-money-bill"></i>
                    </div>
                    <a href="{{route('bill.index')}}">
                        <span>Go to bills</span>
                        <span class="icon-button">
                            <i class="fa fa-arrow-right"></i>
                        </span>
                    </a>
                </article>
                @if($user->permission_id<=2) <article class="tile">
                    <div class="tile-header">
                        <h3>
                            <span>{{ $totalEmployees }}</span>
                            <span>Total Employee</span>
                        </h3>
                        <i class="fa fa-money-bill"></i>
                    </div>
                    <a href="{{route('employee.index')}}">
                        <span>Go to Employees</span>
                        <span class="icon-button">
                            <i class="fa fa-arrow-right"></i>
                        </span>
                    </a>
                    </article>
                    @endif
            </div>
        </section>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Bill</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>List of students who have not paid their room fees this month</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny dataTables-example" data-page-size="15">
                        <thead>
                            <tr>
                                <th data-toggle="true">Student ID</th>
                                <th data-hide="phone">Name</th>
                                <th data-hide="phone">Room</th>
                                <th data-hide="phone">Room type</th>
                                <th data-hide="all">Price</th>
                                <th data-sort-ignore="true">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(count($listStudentNotPaid)>0)
                            @foreach($listStudentNotPaid as $student)
                            <tr>
                                <td>{{ $student->student->student_id }}</td>
                                <td>{{ $student->student->name }}</td>
                                <td>{{ $student->room->room_name }}</td>                         
                                <td>{{ $student->room->roomType->room_type_name }}</td>
                                <td>{{number_format($student->room->roomType->room_type_price, 0, ',', '.')}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="me-2" href="{{route('bill.billroomView', ['id' => $student->room->room_id, 'student_id' => $student->student->student_id])}}">
                                            <button class="btn btn-outline btn-primary dim btn-sm">
                                            <i class="fa fa-money-bill"></i> Pay
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