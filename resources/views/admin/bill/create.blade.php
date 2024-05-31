<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{$title}}</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <h2>
                        From payment
                    </h2>
                    <p>
                        Complete all steps to make payment
                    </p>
                    <form id="form" action="#" class="wizard-big">
                        <h1>Room</h1>
                        <fieldset>
                            <h2>Select room</h2>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <select class="form-control m-b" name="room_id" data-placeholder="Choose a room">
                                                @foreach($rooms as $room)
                                                <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('room_id'))
                                            <span class="help-block m-b-none label label-warning">{{ $errors->first('room_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-center">
                                        <div style="margin-top: 20px">
                                            <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <h1>Profile</h1>
                        <fieldset>
                            <h2>Profile Information</h2>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>First name *</label>
                                        <input id="name" name="name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label>Last name *</label>
                                        <input id="surname" name="surname" type="text" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input id="email" name="email" type="text" class="form-control required email">
                                    </div>
                                    <div class="form-group">
                                        <label>Address *</label>
                                        <input id="address" name="address" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <h1>Warning</h1>
                        <fieldset>
                            <div class="text-center" style="margin-top: 120px">
                                <h2>You did it Man :-)</h2>
                            </div>
                        </fieldset>

                        <h1>Finish</h1>
                        <fieldset>
                            <h2>Terms and Conditions</h2>
                            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>