<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        {{-- <img src="{{ asset('images/logo.png') }}" alt="H2On Logo" class="brand-image"> --}}
        <span class="font-weight-bold">H2On</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('driver.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-id-card"></i>
                        <p>
                            Driver
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Order
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
