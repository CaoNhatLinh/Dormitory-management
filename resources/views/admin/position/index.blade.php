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
                <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">

                <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                    <thead>
                        <tr>
                            <th>Position ID</th>
                            <th>Position name</th>
                            <th data-hide="phone,tablet">Total Employees</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['positions'] as $position)
                        <tr class="gradeA">
                            <td>{{ $position->position_id }}</td>
                            <td>{{ $position->position_name }}</td>
                            <td class="center">{{ $position->employees_count }}</td>
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
            </div>
        </div>
    </div>
</div>