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
                            <h3 class="card-title font-weight-bold" style="font-size: 30px">Delivery Area List</h3>
                            <a href="{{ route('delivery.area.create') }}" class="btn btn-success float-right">Create Delivery Area</a>
                        </div>

                        <div class="card-body">
                            <table id="delivery_area_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Area</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($delivery_areas as $area)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $area->delivery_area_name }}</td>
                                            <td>
                                                <a href="{{ route('delivery.area.edit', ['id' => $area->delivery_area_id]) }}" class="btn btn-success">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                @if ($area->is_deleted)
                                                    <a href="{{ route('delivery.area.destroy', ['id' => $area->delivery_area_id]) }}" class="btn btn-info">
                                                        <i class="fa fa-undo"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('delivery.area.destroy', ['id' => $area->delivery_area_id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this delivery area?');">
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
            $("#delivery_area_list").DataTable({
                "responsive": true,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#delivery_area_list_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
