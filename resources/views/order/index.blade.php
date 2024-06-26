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
        $drivers = App\Models\Users::where('user_type', 'DRIVER')->get();
        // $ware_houses = App\Models\Warehouse::where('is_deleted', 0)->get();
        // $delivery_area = App\Models\DeliveryArea::where('is_deleted', 0)->get();
    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold" style="font-size: 30px">Orders List</h3>
                            {{-- <a href="{{ route('user.create') }}" class="btn btn-success float-right">Create Order</a> --}}
                        </div>

                        <div class="card-body">

                            <div class="row form-group" style="justify-content: right; gap: 10px;">

                                {{-- <div class="col-md-3">
                                    <select class="form-control" id="filter_area">
                                        <option value="">All</option>
                                        @foreach ($delivery_area as $local)
                                            <option value="{{ $local->delivery_area_id }}">{{ $local->delivery_area_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="col-md-2">
                                    <input type="date" id="filter_date" class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="time" id="filter_time" class="form-control">
                                </div>

                                {{-- <button class="btn btn-success mr-2" data-toggle="modal" data-target="#assign_to_driver_modal">Assign Driver</button> --}}

                            </div>

                            <table id="order_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th>User</th>
                                        <th>Address</th>
                                        <th>Contact Name</th>
                                        <th>Contact Number</th>
                                        <th>Warehouse</th>
                                        <th>Area</th>
                                        <th>Driver</th>
                                        <th>Delivery Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        {{-- <th>Assign</th> --}}
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

    <div class="modal fade" id="add_contact_details">
        <form id="contact_details_form">
            <div class="modal-dialog modal-xl">
                <input type="hidden" name="contact_order_id" id="contact_order_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_name">Contact Name</label>
                                    <input type="text" name="contact_name" class="form-control" id="contact_name" placeholder="Enter Contact Name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="number" name="contact_number" class="form-control" id="contact_number" placeholder="Enter Contact Number">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_assigned_driver">Assigned Driver</label>
                                    <select class="form-control" id="edit_assigned_driver" name="edit_assigned_driver">
                                        <option value="">Please Select Driver</option>
                                        @foreach ($drivers as $drv)
                                            <option value="{{ $drv->user_token }}">{{ $drv->first_name . ' ' . $drv->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="delivery_time">Delivery Date Time</label>
                                    <input class="form-control" type="datetime-local" name="delivery_time" id="delivery_time">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title font-weight-bold">Products</>
                                </div>
                                <div class="card-body" id="products_div">

                                </div>
                                <div class="card-footer">
                                    <div class="row float-right">
                                        <table class="table custom-specific-table">
                                            <tbody>
                                                <tr>
                                                    <td>Item Amount:</td>
                                                    <td id="item_amount"></td>
                                                </tr>
                                                <tr>
                                                    <td>Taxes:</td>
                                                    <td id="order_taxes"></td>
                                                </tr>
                                                <tr>
                                                    <td>Delivery Charges:</td>
                                                    <td id="delivery_charges"></td>
                                                </tr>
                                                <tr>
                                                    <td class="total_amt">Total Amount:</td>
                                                    <td class="total_amt" id="total_amount"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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

    {{-- <div class="modal fade" id="assign_to_driver_modal">
        <form id="assign_to_driver_form">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign Driver Dispatch Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="assign_driver">Assign Driver</label>
                                    <select class="form-control" id="assign_to_driver" name="assign_to_driver">
                                        <option value="">Please Select Driver</option>
                                        @foreach ($drivers as $drv)
                                            <option value="{{ $drv->user_token }}">{{ $drv->first_name . ' ' . $drv->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="assignDriverSubmitButton" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div> --}}

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
        var url = "{{ route('order.index.data') }}"

        var order_list_table = jQuery("#order_list").DataTable({
            info: true,
            bSort: true,
            paging: true,
            searching: true,
            iDisplayLength: 10,
            bProcessing: true,
            responsive: true,
            aoColumns: [{
                    mDataProp: "order_id",
                },
                {
                    mDataProp: "order_date",
                },
                {
                    mDataProp: "user",
                },
                {
                    mDataProp: "address",
                },
                {
                    mDataProp: "contact_name",
                },
                {
                    mDataProp: "contact_number",
                },
                {
                    mDataProp: "warehouse",
                },
                {
                    mDataProp: "local_area",
                },
                {
                    mDataProp: "driver",
                },
                {
                    mDataProp: "delivery_date",
                },
                {
                    mDataProp: "order_status",
                },
                {
                    bSortable: false,
                    mDataProp: "order_action",
                },
                // {
                //     bSortable: false,
                //     mDataProp: "driver_assign",
                // }
            ],

            serverSide: true,
            sAjaxSource: url,
            deferRender: true,
            oLanguage: {
                sEmptyTable: "No Order in the List.",
                sZeroRecords: "No Customer Order",
                sProcessing: "Loading...",
            },
            fnPreDrawCallback: function(oSettings) {},
            fnServerParams: function(aoData) {
                aoData.push({
                    name: "filter_area",
                    value: $('#filter_area').val(),
                });

                aoData.push({
                    name: "filter_date",
                    value: $('#filter_date').val(),
                });

                aoData.push({
                    name: "filter_time",
                    value: $('#filter_time').val(),
                });
            },
        });

        // $(document).on('change', '#filter_area', function() {
        //     order_list_table.draw();
        // });

        $(document).on('change', '#filter_date', function() {
            order_list_table.draw();
        });

        $(document).on('change', '#filter_time', function() {
            order_list_table.draw();
        });

        // $(document).on('change', '#area_zone', function() {
        //     var zone = $(this).val();
        //     if(zone == "") {
        //         $('.warehouse-div').css('display', 'none');
        //         $('.local-area-div').css('display', 'none');
        //     }else if(zone == 'Warehouse') {
        //         $('.warehouse-div').css('display', 'block');
        //         $('.local-area-div').css('display', 'none');
        //     } else {
        //         $('.local-area-div').css('display', 'block');
        //         $('.warehouse-div').css('display', 'none');
        //     }
        // });

        $(document).on('click', '.edit_contact_details', function() {
            var order_id = $(this).data('order_id');

            $('#contact_details_form')[0].reset();

            $.ajax({
                url: '{!! route('order.contact.edit') !!}',
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
                },
                data: {
                    order_id: order_id,
                },
                success: function(response) {
                    var responseObject = JSON.parse(response);
                    $("#contact_order_id").val(order_id);
                    $("#contact_name").val(responseObject.contact_name);
                    $("#contact_number").val(responseObject.contact_number);
                    $("#edit_assigned_driver").val(responseObject.driver_token);
                    $("#delivery_time").val(responseObject.delivery_time);

                    $("#item_amount").html('$ ' + responseObject.item_amount);
                    $("#order_taxes").html('$ ' + responseObject.taxes);
                    $("#delivery_charges").html('$ ' + responseObject.delivery_charge);
                    $("#total_amount").html('$ ' + responseObject.total_amount);

                    $('#products_div').html("");
                    var html = `<table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>`
                        if(responseObject.products) {
                            var products = responseObject.products;
                            if(products.length > 0) {
                                products.forEach(function(type, index) {
                                    html += `<tr>
                                        <td>${type.product_name}</td>
                                        <td>${truncateString(type.product_description, 40)}</td>
                                        <td>${type.category.product_category_name}</td>
                                        <td>${type.quantity}</td>
                                        <td>$ ${type.product_price}</td>
                                    </tr>`;
                                });
                            } else {
                                html += `<tr>
                                        <td colspan="5">
                                            No Products Found
                                        </td>
                                    </tr>`;
                            }
                        }
                    html += `</tbody></table>`;
                    $('#products_div').html(html);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        function truncateString(str, num) {
            return str.length > num ? str.slice(0, num) + '...' : str;
        }

        $(document).on('click', '#submitButton', function() {
            var contact_order_id = $('#contact_order_id').val();
            var contact_name = $("#contact_name").val();
            var contact_number = $("#contact_number").val();
            var delivery_time = $("#delivery_time").val();
            var assigned_driver = $("#edit_assigned_driver").val();

            $.ajax({
                url: '{!! route('order.contact.update') !!}',
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
                },
                data: {
                    contact_order_id: contact_order_id,
                    contact_name: contact_name,
                    contact_number: contact_number,
                    delivery_time: delivery_time,
                    assigned_driver: assigned_driver,
                },
                success: function(response) {
                    $('#add_contact_details').modal('hide');
                    $('#contact_details_form')[0].reset();
                    order_list_table.draw();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // $(document).on('click', '#assignDriverSubmitButton', function() {
        //     var checkedCheckboxes = $('.assign_to_driver_id:checked');
        //     var orderIds = [];
        //     checkedCheckboxes.each(function() {
        //         var orderId = $(this).data('order_id');
        //         orderIds.push(orderId);
        //     });
        //     var driver_id = $('#assign_to_driver').val();
        //     $.ajax({
        //         url: '{!! route('store.assign.to.driver') !!}',
        //         type: 'POST',
        //         headers: {
        //             "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
        //         },
        //         data: {
        //             orderIds: orderIds,
        //             driver_id: driver_id,
        //         },
        //         success: function(response) {
        //             $('#assign_to_driver_modal').modal('hide');
        //             $('#assign_to_driver_form')[0].reset();
        //             order_list_table.draw();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Something went wrong');
        //         }
        //     });
        // });

    </script>
@endsection
