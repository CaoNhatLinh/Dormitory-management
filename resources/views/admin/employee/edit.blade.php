<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Edit employees </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
                <form method="POST" action="{{ route('employee.edit', $employee->employee_id) }}" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="form-group"><label class="col-sm-2 control-label">Person ID</label>

                        <div class="col-sm-10">
                            <input value="{{ $employee->person_id }}" type="text" name="person_id" id="person_id" placeholder="Person ID" class="form-control" required>
                        </div>
                        @if ($errors->has('person_id'))
                        <span class="help-block m-b-none label label-warning"label label-warning>{{ $errors->first('person_id') }}</span>
                        @endif
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Full name</label>
                        <div class="col-sm-10">
                            <input value="{{ $employee->name }}" type="text" name="name" id="name" placeholder="Full name" class="form-control" required>
                            @if ($errors->has('name'))
                            <span class="help-block m-b-none label label-warning">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Gender</label>

                        <div class="col-sm-10">
                            <select class="form-control m-b" name="gender" required data-placeholder="Choose a gender">
                                <option value="Male" {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female"{{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @if ($errors->has('gender'))
                            <span class="help-block m-b-none label label-warning">{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nationality</label>

                        <div class="col-sm-10">
                            <select class="form-control m-b chosen-select" tabindex="2" data-placeholder="Choose a nationality..." name="nationality">';
                                <option value="">Select</option>';
                                <?php
                                $apiUrl = "https://restcountries.com/v3.1/all";
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $response = curl_exec($ch);
                                curl_close($ch);
                                $countries = json_decode($response, true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    foreach ($countries as $country) {
                                        $countryName = $country['name']['common'];
                                        ?>
                                       <option value="{{ $countryName }}" {{$employee->nationality == $countryName ? 'selected' : ''}}  > {{htmlspecialchars($countryName) }}</option>
                                       <?php
                                    }
                                    echo '</select>';
                                } else {
                                    echo 'Error retrieving country data';
                                }
                                ?>
                                @if ($errors->has('nationality'))
                                <span class="help-block m-b-none label label-warning">{{ $errors->first('nationality') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10"><input value="{{ $employee->address }}" type="text" name="address" id="address" placeholder="Address" class="form-control" required>
                            @if ($errors->has('address'))
                            <span class="help-block m-b-none"label label-warning>{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group" id="data_1">
                        <label class="col-sm-2 control-label">Date of Birth</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="date_of_birth" id="date_of_birth" required value="<?php
                                $dateString = $employee->date_of_birth;
                                $date = new DateTime($dateString);
                                $formattedDate = $date->format('d/m/Y');
                                echo $formattedDate; 
                                ?>">
                            </div>
                        </div>
                        @if ($errors->has('date_of_birth'))
                        <span class="help-block m-b-none label label-warning">{{ $errors->first('date_of_birth') }}</span>
                        @endif
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Position</label>
                        <div class="col-sm-10">
                            <select class="form-control m-b" name="position_id" data-placeholder="Choose a position">
                                @foreach($positions as $position)
                                <option value="{{ $position->position_id }}" {{ $employee->position_id == '$position->position_id' ? 'selected' : '' }}>{{ $position->position_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('gender'))
                            <span class="help-block m-b-none label label-warning">{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Status</label>

                        <div class="col-sm-10">
                            <select class="form-control m-b" name="status" required data-placeholder="Choose a Status">
                                <option value="Working" {{ $employee->status == 'Working' ? 'selected' : '' }}>Working</option>
                                <option value="Terminated" {{ $employee->status == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                                <option value="On Leave" {{ $employee->status == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                            </select>
                            @if ($errors->has('status'))
                            <span class="help-block m-b-none label label-warning">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Avatar</label>
                        <div class="col-sm-10">
                            <div class="tw-flex tw-items-center tw-justify-between">
                                @if ($employee->avatar)
                                <img src="{{ asset('uploads/avatars/' . $employee->avatar) }}" alt="avatar" class="tw-w-[80px] tw-h-[80px] tw-rounded-full tw-me-3 tw-mb-4">
                                @endif
                                <div class="fileinput max-w-96 fileinput-new input-group" style="width:90%" data-provides="fileinput">
                                    <div class="form-control " data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-success btn-file">
                                        <span class="fileinput-new">Change</span>
                                        <span class="fileinput-exists"><i class="fa fa-upload"></i> Change</span>
                                        <input type="file" name="avatar" />
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                                @if ($errors->has('avatar'))
                                <span class="help-block m-b-none label label-warning">{{ $errors->first('avatar') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white btn-outline btn-link"><a href="{{route('employee.index')}}">Cancel</a></button>
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>