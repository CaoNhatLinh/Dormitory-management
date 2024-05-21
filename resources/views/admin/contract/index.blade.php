<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Contract list</h5>
                <div class="ibox-tools">
                    
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            
            <div class="ibox-content">
                <div class="table-responsive">
                    <table id="contractTable" class="dataTables_wrapper footable table table-stripped toggle-arrow-tiny dataTables-example">
                        <thead>
                            <tr>
                                <th>Contract ID</th>
                                <th>Room</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contracts as $contract)
                            <tr>
                                <td>{{ $contract->contract_id }}</td>
                                <td>{{ $contract->room->room_name }}</td>
                                <td>{{ $contract->start_date }}</td>
                                <td>{{ $contract->end_date }}</td>
                                <td>
                                    @if ($contract->status == 'renting')
                                        <label class="label label-primary">{{ $contract->status }}</label>
                                    @elseif ($contract->status == 'expired')
                                        <label class="label label-warning">{{ $contract->status }}</label>
                                    @else 
                                        <label class="label label-danger">{{ $contract->status }}</label>
                                    @endif
                                </td>
                                <td>
                                    <a class="text-size-lg me-2" href="{{route('contract.editView', $contract->contract_id)}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
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