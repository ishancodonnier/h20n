<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        {{-- <img src="{{ asset('images/logo-black.png') }}" alt="AdminLTE Logo" class="brand-image"
            style="opacity: .8"> --}}
        <span class="font-weight-bold"></span>
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
            </ul>
        </nav>
    </div>
</aside>
