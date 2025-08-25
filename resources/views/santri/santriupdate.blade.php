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
    @endif
        <div class="card bg-light text-dark">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h5>Data Santri</h5>            
            </div>
            <div class="card-body ">  
                @foreach ($data as $d)
                    
                <form method="POST" action="{{ route('santri.update', $d->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="form-control" id="id" aria-describedby="id" name="id" value="{{ $d->id }}">
                    <input type="hidden" name="role" value="santri">
                    <div class="row">                 
                        {{-- rigth --}}
                        <div class="col">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" aria-describedby="nama" name="nama" value="{{ $d->nama_santri }}">
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $d->tempat_lahir }}">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $d->tanggal_lahir }}">
                            </div>                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" class="form-select" name="status">
                                <option value="aktif" {{ $d->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif" {{ $d->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>                             
                        </div>
                        
                        {{-- left --}}
                        <div class="col">                    
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $d->alamat }}">
                        </div>                            
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select id="jenis_kelamin" class="form-select" name="jenis_kelamin">
                            <option value="L" {{ $d->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $d->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>            
                        <div class="mb-3">
                            <label for="wali_santri" class="form-label">Wali Santri</label>                            
                            <select id="wali_santri" class="form-select" name="wali_santri">
                            @foreach ($walis as $w)
                            <option value="{{ $w->id }}" {{ $d->id_wali == $w->id ? 'selected' : ''}}>{{ $w->nama_wali }}, {{ $w->no_telp }}</option>                                
                            @endforeach
                            {{-- <option value="{{ $walis->id }}">{{ $walis->nama }}</option> --}}         
                            </select>                                                           
                        </div>  
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                            <button class="btn btn-primary" type="submit"> Simpan Data</button>
                            <a class="btn btn-danger mr-2" href="{{ route('santri.index') }}"> Kembali</a>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>        
        </div>
</div>
@include('template.footer')
