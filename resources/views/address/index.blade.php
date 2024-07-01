@extends('layout.main')
@section('head-css-script')
    <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .custom-specific-table {
            margin-bottom: 0px;
        }

        .card-footer {
            padding-top: 5px;
        }

        .custom-specific-table td {
            padding: 5px;
            border-top: 0px solid;
        }

        .custom-specific-table .total_amt {
            border-top: 1px solid #dee2e6;
        }
    </style>
@endsection
@section('content')


    @php
        $ware_houses = App\Models\Warehouse::where('is_deleted', 0)->get();
        $delivery_area = App\Models\DeliveryArea::where('is_deleted', 0)->get();
    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold" style="font-size: 30px">Address List</h3>
                            {{-- <a href="{{ route('user.create') }}" class="btn btn-success float-right">Create Order</a> --}}
                        </div>

                        <div class="card-body">

                            <table id="address_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>User</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip Code</th>
                                        <th>Type</th>
                                        <th>Warehouse</th>
                                        <th>Local Area</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="add_warehouse_details">
        <form id="warehouse_details_form">
            <div class="modal-dialog ">
                <input type="hidden" name="user_address_id" id="user_address_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Warehouse</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="area_zone" name="area_zone" value="">

                            <div class="col-12 warehouse-div">
                                <div class="form-group">
                                    <label for="warehouse_zone">Warehouse</label>
                                    <select class="form-control" id="warehouse_zone" name="warehouse_zone">
                                        <option value="">Please Select Warehouse</option>
                                        @foreach ($ware_houses as $wrh)
                                            <option value="{{ $wrh->warehouse_id }}">{{ $wrh->warehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 local-area-div">
                                <div class="form-group">
                                    <label for="local_area_id">Local Area</label>
                                    {{-- <input type="text" class="form-control" id="local_area_id" name="local_area_id" placeholder="Enter Local Area Name"> --}}

                                    <select class="form-control" id="local_area_id" name="local_area_id">
                                        <option value="">Please Select Local Area</option>
                                        @foreach ($delivery_area as $local)
                                            <option value="{{ $local->delivery_area_id }}">{{ $local->delivery_area_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="submitButton" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('footer-script')
    <script src="{{ asset('asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        var url = "{{ route('address.index.data') }}"

        var address_list_table = jQuery("#address_list").DataTable({
            info: true,
            bSort: true,
            paging: true,
            searching: true,
            iDisplayLength: 10,
            bProcessing: true,
            responsive: true,
            aoColumns: [{
                    mDataProp: "id",
                },
                {
                    mDataProp: "user",
                },
                {
                    mDataProp: "address",
                },
                {
                    mDataProp: "city",
                },
                {
                    mDataProp: "state",
                },
                {
                    mDataProp: "zip_code",
                },
                {
                    mDataProp: "address_type",
                },
                {
                    mDataProp: "warehouse",
                },
                {
                    mDataProp: "local_area",
                },
                {
                    bSortable: false,
                    mDataProp: "action",
                },
            ],

            serverSide: true,
            sAjaxSource: url,
            deferRender: true,
            oLanguage: {
                sEmptyTable: "No Address in the List.",
                sZeroRecords: "No User added Address",
                sProcessing: "Loading...",
            },
            fnPreDrawCallback: function(oSettings) {},
            fnServerParams: function(aoData) {
                //filter and extra filter can be added here
            },
        });

        $(document).on('click', '.edit_warehouse_details', function() {
            var user_address_id = $(this).data('user_address_id');

            $('#warehouse_details_form')[0].reset();

            $.ajax({
                url: '{!! route('address.warehouse.edit') !!}',
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
                },
                data: {
                    user_address_id: user_address_id,
                },
                success: function(response) {
                    var responseObject = JSON.parse(response);
                    $("#user_address_id").val(user_address_id);
                    $("#area_zone").val(responseObject.area_zone);
                    $("#warehouse_zone").val(responseObject.warehouse_zone);
                    $("#local_area_id").val(responseObject.local_area_id);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $(document).on('click', '#submitButton', function() {
            var user_address_id = $('#user_address_id').val();
            var area_zone = $("#area_zone").val();
            var warehouse_zone = $("#warehouse_zone").val();
            var local_area_id = $("#local_area_id").val();

            $.ajax({
                url: '{!! route('address.warehouse.update') !!}',
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
                },
                data: {
                    user_address_id: user_address_id,
                    area_zone: area_zone,
                    local_area_id: local_area_id,
                    warehouse_zone: warehouse_zone,
                },
                success: function(response) {
                    $('#add_warehouse_details').modal('hide');
                    $('#warehouse_details_form')[0].reset();
                    address_list_table.draw();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

    </script>
@endsection
