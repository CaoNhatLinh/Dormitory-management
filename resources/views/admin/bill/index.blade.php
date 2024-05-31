<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>The list of bills</h5>

                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <button class="btn btn-primary dim btn-sm" data-toggle="modal" data-target="#modalCreate">
                        New Bill
                    </button>
                    <input type="text" class="form-control input-sm m-b-xs " id="filter" placeholder="Search in table">
                </div>

                <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                    <thead>
                        <tr>
                            <th>Bill ID</th>
                            <th>Room</th>
                            <th>cashier</th>
                            <th>Total bill</th>
                            <th>Date bill</th>
                            <th data-sort-ignore="true">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['bills'] as $bill)
                        <tr class="gradeA">
                            <td>{{ $bill->bill_id }}</td>
                            <td>{{ $bill->room->room_name }}</td>
                            <td>{{ $bill->employee->name }}</td>

                            <td class="center">{{ number_format($bill->total_bill, 0, ',', '.') }} VNĐ</td>
                            <td class="center">{{ $bill->date_bill }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary dim btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="#" onclick="return confirm('Bạn có chắc chắn muốn xóa chức vụ này không?');">
                                        <button class="btn btn-danger dim btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
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
            </div>
        </div>
    </div>
</div>