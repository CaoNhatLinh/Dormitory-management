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
                        <span class="help-block m-b-none">{{ $errors->first('person_id') }}</span>
                        @endif
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Full name</label>
                        <div class="col-sm-10">
                            <input value="{{ $employee->name }}" type="text" name="name" id="name" placeholder="Full name" class="form-control" required>
                            @if ($errors->has('name'))
                            <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">Gender</label>

                        <div class="col-sm-10">
                            <select class="form-control m-b" name="gender" required data-placeholder="Choose a gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>

                            </select>
                            @if ($errors->has('gender'))
                            <span class="help-block m-b-none">{{ $errors->first('gender') }}</span>
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
                                        echo '<option value="' . htmlspecialchars($countryName) . '">' . htmlspecialchars($countryName) . '</option>';
                                    }
                                    echo '</select>';
                                } else {
                                    echo 'Error retrieving country data';
                                }
                                ?>
                                @if ($errors->has('nationality'))
                                <span class="help-block m-b-none">{{ $errors->first('nationality') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10"><input value="{{ $employee->address }}" type="text" name="address" id="address" placeholder="Address" class="form-control" required>
                            @if ($errors->has('address'))
                            <span class="help-block m-b-none">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group" id="data_1">
                        <label class="col-sm-2 control-label">Date of Birth</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" name="date_of_birth" id="date_of_birth" required value="{{ $employee->date_of_birth }}">
                            </div>
                        </div>
                        @if ($errors->has('date_of_birth'))
                        <span class="help-block m-b-none">{{ $errors->first('date_of_birth') }}</span>
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
                            <span class="help-block m-b-none">{{ $errors->first('gender') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Avatar</label>
                        <div class="col-sm-10"><input type="file" name="avatar" id="avatar" placeholder="avatar" class="form-control" required>
                            @if ($errors->has('avatar'))
                            <span class="help-block m-b-none">{{ $errors->first('avatar') }}</span>
                            @endif
                        </div>
                    </div> -->
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>