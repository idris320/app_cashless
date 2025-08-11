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
                <h5>Update Data Pegawai</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">                          
                </div>
            </div>
            <div class="card-body">
                @foreach ($data as $d)
                <form method="POST" action="{{ route('pegawai.update',$d->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $d->id }}">                    
                    <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" required name="nama" value=" {{ $d->nama_pegawai }}">
                    </div>        
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No Telp</label>
                        <input type="text" class="form-control" id="no_telp" required name="no_telp" value=" {{ $d->no_telp }}">
                    </div>        
                    <div class="mb-3">
                        <label for="email" class="form-label">email</label>
                        <input type="email" class="form-control" id="email" required name="email"  value="{{ $d->email }}">
                    </div>        
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" required name="alamat" value="{{ $d->alamat }}">
                    </div>        
                    <div class="mb-3">
                        <label for="posisi" class="form-label">Posisi</label>
                        <select id="posisi" class="form-select" name="posisi">
                            <option value="">Pilih Posisi</option>                            
                            <option value="admin" {{ $d->posisi == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ $d->posisi == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                    </div>                                       
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                            <button class="btn btn-primary" type="submit"> Simpan Data</button>
                            <a class="btn btn-danger mr-2" href="{{ route('pegawai.index') }}"> Kembali</a>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>
        </div>
</div>


@include('template.footer')