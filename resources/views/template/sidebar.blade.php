
<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>AL-FURQON</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('') }}/bootstrap/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">IDRIS</h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">            
            <a href="{{ route('dashboard') }}" class="nav-item nav-link">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a href="{{ route('santri.index') }}" class="nav-item nav-link">
                <i class="fas fa-user-graduate me-2"></i>Santri
            </a>
            <a href="{{ route('walisantri.index') }}" class="nav-item nav-link">
                <i class="fa fa-user me-2"></i>Wali Santri
            </a>
            <a href="{{ route('topup.index') }}" class="nav-item nav-link">
                <i class="fa fa-plus me-2"></i>Top Up
            </a>
            <a href="{{ route('petugaskantin.index') }}" class="nav-item nav-link">
                <i class="fa fa-cash-register me-2"></i>Petugas Kantin
            </a>
            <a href="{{ route('tatausaha.index') }}" class="nav-item nav-link">
                <i class="fa fa-user-tie me-2"></i>Tata Usaha
            </a>
            
            <!-- all dropdown -->
            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="button.html" class="dropdown-item">Buttons</a>
                    <a href="typography.html" class="dropdown-item">Typography</a>
                    <a href="element.html" class="dropdown-item">Other Elements</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="signin.html" class="dropdown-item">Sign In</a>
                    <a href="signup.html" class="dropdown-item">Sign Up</a>
                    <a href="404.html" class="dropdown-item">404 Error</a>
                    <a href="blank.html" class="dropdown-item">Blank Page</a>
                </div>
            </div> --}}
        </div>
    </nav>
</div>
<div class="content">
<!-- Sidebar End -->