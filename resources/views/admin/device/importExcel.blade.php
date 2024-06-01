
<div class="tw-mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Import by Excel</h5>
                </div>

                <div class="ibox-content">
                    <form class="tw-mt-5 tw-mb-10" action="{{ route('device.loadExcel') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="excel_device">Upload excel file</label>
                            <div class="tw-flex tw-items-center">
                                <input accept=".xlsx, .xls, .csv" type="file" name="excel_device"
                                    class="tw-flex-1 form-control">
                                <button type="submit" class="btn btn-primary">Load excel</button>
                            </div>
                        </div>
                    </form>
                    <div>
                        @if(!empty($excel_devices))
                        <div class="table-responsive">
                            <table id="table_list_1"></table>
                            <div id="pager_list_1"></div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('device.createExcel') }}">
                                @csrf
                                <input type="hidden" name="excel_file_path" value="{{ $excel_file_path }}">
                                <button type="submit" class="btn btn-primary tw-w-full">Import</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>