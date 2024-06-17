@extends('layout.main')

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Number of User</span>
                            <span class="info-box-number">{{ $user_count }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box shadow-lg">
                        <span class="info-box-icon bg-info"><i class="fa fa-id-card"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Number of Drivers</span>
                            <span class="info-box-number">{{ $driver_count }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
