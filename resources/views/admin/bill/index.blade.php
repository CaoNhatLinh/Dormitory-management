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
                    <a href="{{ route('bill.createView')}}">
                        <button class="btn btn-primary dim btn-sm" >
                        New Bill
                    </button></a>
                </div>

                <table class="footable table table-stripped dataTables-example" data-page-size="8" data-filter=#filter>
                    <thead>
                        <tr>
                            <th>Bill ID</th>
                            <th>Room</th>
                            <th>cashier</th>
                            <th>Type payment</th>
                            <th>Total bill</th>
                            <th>Date bill</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['bills'] as $bill)
                        <tr >
                            <td>{{ $bill->bill_id }}</td>
                            <td>{{ $bill->room->room_name }}</td>
                            <td>{{ $bill->employee->name }}</td>
                            <td>{{ $bill->type_payment }}</td>
                            <td class="center">{{ number_format($bill->total_bill, 0, ',', '.') }} VNĐ</td>
                            <td class="center">{{ $bill->date_bill }}</td>
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