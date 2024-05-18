
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Employee details</h2>
                                <img class="tw-w-[100px] tw-h-[100px] tw-rounded-full tw-my-3" src="{{ asset('uploads/avatars/'. $employee->avatar) }}" alt="" class="img-thumbnail">
                                <dl class="dl-horizontal [&>*]:!tw-text-start [&>*]:tw-py-3">
                                    <dt>Employee ID:</dt>
                                    <dd>{{ $employee->student_id }}</dd>
                                    <dt>Full name:</dt>
                                    <dd>{{ $employee->name }}</dd>
                                    <dt>Position:</dt>
                                    <dd>{{ $employee->position->position_name }}</dd>
                                    <dt>Date of birth</dt>
                                    <dd>{{ $employee->date_of_birth }}</dd>
                                    <dt>Giới tính:</dt>
                                    <dd>{{ $employee->gender }}</dd>
                                    <dt>Person ID:</dt>
                                    <dd>{{ $employee->person_id }}</dd>
                                    <dt>Nationality:</dt>
                                    <dd>{{ $employee->nationality }}</dd>
                                    <dt>Address:</dt>
                                    <dd>{{ $employee->address }}</dd>
                                </dl>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
