<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>The list of Position</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <button class="btn btn-primary dim btn-sm" data-toggle="modal" data-target="#modalCreate">
                        New Positon
                    </button>
                    <input type="text" class="form-control input-sm m-b-xs " id="filter" placeholder="Search in table">
                </div>

                <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                    <thead>
                        <tr>
                            <th>Position ID</th>
                            <th>Position name</th>
                            <th >Total Employees</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['positions'] as $position)
                        <tr class="gradeA">
                            <td>{{ $position->position_id }}</td>
                            <td>{{ $position->position_name }}</td>
                            <td class="center">{{ $position->employees_count }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary dim btn-sm" data-toggle="modal" data-target="#myModal" data-id="{{ $position->position_id }}" data-name="{{ $position->position_name }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('position.edit')}}" method="post">
                            @csrf
                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Edit Position</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Position Name</label>
                                        <input type="text" placeholder="Position Name" class="form-control" name="position_name">
                                        @if ($errors->has('position_name'))
                                        <span class="help-block m-b-none label label-warning" label label-warning>{{ $errors->first('position_name') }}</span>
                                        @endif
                                        <input type="hidden" name="position_id" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="modal inmodal" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('position.create')}}" method="post">
                            @csrf
                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Create Position</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Position Name</label>
                                        <input type="text" placeholder="Position Name" class="form-control" name="position_name">
                                        @if ($errors->has('position_name'))
                                        <span class="help-block m-b-none label label-warning" label label-warning>{{ $errors->first('position_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>