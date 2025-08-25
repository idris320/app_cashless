<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pondok Pesantren Al-Furqon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    @if (session('successLogout'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('successLogout') }}',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        </script>
    @endif
    
        @if($errors->any())            
            <script>
                Swal.fire({
                    title: 'Error',
                    text: '{{ $errors->first() }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                });
            </script>                            
        @endif
    <div class="login-container">
        <div class="logo-section">
            <div class="logo-placeholder">
                <img class="rounded-circle" src="{{ asset('image/logoPonpes.png') }}" alt=""  style="width: 150px; height: 150px;">
            </div>
            <h1 class="logo-title">PONDOK PESANTREN</h1>
            <h2 class="logo-subtitle">AL-FURQON</h2>
            <p class="visisub">Menumbuhkan Generasi Qur'ani yang Berakhlak Mulia</p>
            <p class="quote">"Sebaik-baik kalian adalah yang mempelajari Al-Qur'an dan mengajarkannya"</p>
        </div>
        
        <div class="form-section">
            <h2 class="form-title">Login Sistem</h2>
            
            <form method="POST" action="{{'login'}}">
             @csrf
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                        <label for="username">Username</label>
                    </div>
                </div>
                
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        <label for="password">Password</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>

                {{-- <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div> --}}
                
                
                {{-- <a href="#" class="forgot-link">Lupa password?</a>
                
                <div class="divider">
                    <span>Atau</span>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-secondary">
                        <i class="fas fa-user-plus me-2"></i>Daftar Akun Baru
                    </button>
                </div> --}}
            </form>
            
            <p class="copyright">© 2023 Pondok Pesantren Al-Furqon. All rights reserved.</p>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>