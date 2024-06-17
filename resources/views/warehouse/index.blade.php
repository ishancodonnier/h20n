@extends('layout.main')
@section('head-css-script')
    <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold" style="font-size: 30px">Warehouses List</h3>
                            <a href="{{ route('warehouse.create') }}" class="btn btn-success float-right">Create Warehouse</a>
                        </div>

                        <div class="card-body">
                            <table id="warehouse_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Area</th>
                                        <th>Zip Code</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouses as $wh)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $wh->warehouse_name }}</td>
                                            <td>{{ $wh->warehouse_area }}</td>
                                            <td>{{ $wh->warehouse_zip_code }}</td>
                                            <td>{{ Str::length($wh->warehouse_address_line1) > 40 ? Str::limit($wh->warehouse_address_line1, 40, '...') : $wh->warehouse_address_line1 }}</td>
                                            <td>
                                                <a href="{{ route('warehouse.edit', ['id' => $wh->warehouse_id]) }}" class="btn btn-success">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                @if ($wh->is_deleted)
                                                    <a href="{{ route('warehouse.destroy', ['id' => $wh->warehouse_id]) }}" class="btn btn-info">
                                                        <i class="fa fa-undo"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('warehouse.destroy', ['id' => $wh->warehouse_id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this warehouse?');">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                @endif
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
    </section>
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
        $(function() {
            $("#warehouse_list").DataTable({
                "responsive": true,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#warehouse_list_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
