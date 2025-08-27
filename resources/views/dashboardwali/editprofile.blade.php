@include('template.head')
@include('template.sidebarwali')
@include('template.topbar')

<div class="container-fluid pt-4 px-4">     

    @if ($errors->any())
            @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                    title: 'Error',
                    text: '{{ $error }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
            @endforeach
        @endif
    <div class="card bg-light text-dark">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h5>Edit Profile</h5>            
        </div>
        <div class="card-body ">      
            @foreach ($data as $d)                
            <form method="POST" action="{{ route('dashboardwali.update', $d->id) }}">
                @csrf
                @method('PUT')
                <input type="hidden" class="form-control" id="id_wali" name="id_wali" value="{{ $d->id }}">
                <input type="hidden" name="role" value="wali">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_wali" required value="{{ $d->nama_wali }}" name="nama_wali">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" required value="{{ $d->alamat }}" name="alamat">
                </div>        
                <div class="mb-3">
                    <label for="noTelp" class="form-label">No Telp</label>
                    <input type="text" class="form-control" id="noTelp" required value="{{ $d->no_telp }}" name="no_telp">
                </div>        
                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="email" class="form-control" id="email" required value="{{ $d->email }}" name="email">
                </div> 
                <div class="mb-3">
                    <label for="password" class="form-label">password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div> 
                <div class="mb-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                        <button class="btn btn-primary" type="submit"> Simpan Data</button>
                        <a class="btn btn-danger mr-2" href="{{ route('walisantri.index') }}"> Kembali</a>
                    </div>
                </div>                              
            </form>     
            @endforeach   
        </div>        
    </div>
</div>

@include('template.footer')