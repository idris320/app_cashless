@include('template.head')
@include('template.sidebar')
@include('template.topbar')

<div class="container-fluid pt-4 px-4"> 
        @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
        @elseif (session('error'))
        <script>
            Swal.fire({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        @endif

        <div class="card bg-light text-dark">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h5>Data Pegawai</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahdatapegawai"><i class="fas fa-plus"></i> Tamabah Data</button>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
</div>

@include('template.footer')