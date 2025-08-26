@include('template.head')
@include('template.sidebar')
@include('template.topbar')

<div class="container-fluid pt-4 px-4">         

        {{-- error input --}}
        @if ($errors->any())
            @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                    title: 'Error',
                    text: '{{ $error }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#218838'
                });
            </script>
            @endforeach
        @endif

        <div class="card bg-light text-dark">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h5>Data Wali Santri</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahwalisantri"><i class="fas fa-plus"></i> Tamabah Data</button>
                </div>
            </div>
            <div class="card-body ">        
                <div class="table-responsive">  
                    <table class="table table-hover text-dark" id="tabelku">
                        <thead>
                            <tr>
                            <th scope="col">#</th>                        
                            <th scope="col">Nama</th>                       
                            <th scope="col">Alamat</th>
                            <th scope="col">No Telpon</th>
                            <th scope="col">Email</th>
                            <th scope="col">Aksi</th>                  
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $ws)
                            <tr>
                            <th scope="row">{{ $index + 1 }}</th>                        
                            <td>{{ $ws->nama_wali }}</td>
                            <td>{{ $ws->alamat }}</td>
                            <td>{{ $ws->no_telp }}</td>
                            <td>{{ $ws->email }}</td>
                            <td>
                                <a href="{{ route('walisantri.edit', $ws->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-destroy{{ $ws->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                            </tr>                            
                            @endforeach
                        </tbody>
                    </table>   
                </div>     
            </div>        
        </div>
    </div>



    <!--Modal Tambah Data Wali Santri baru-->  
<div class="modal fade" id="tambahwalisantri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah data wali santri</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('walisantri.store') }}">
                @csrf
                <input type="hidden" class="form-control" id="id_user" name="id_user" value="{{ random_int(100000, 999999) }}">
                <input type="hidden" class="form-control" id="id_wali" name="id_wali" value="{{ random_int(100000, 999999) }}">
                <input type="hidden" name="role" value="wali">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" required name="nama">
                </div>        
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" required name="alamat">
                </div>        
                <div class="mb-3">
                    <label for="noTelp" class="form-label">No Telp</label>
                    <input type="text" class="form-control" id="no_telp" required name="no_telp">
                    <div class="text-danger">
                        *No telpon sekaligus menjadi username untuk orang tua login
                    </div>
                </div>        
                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="email" class="form-control" id="email" required name="email">
                </div>        
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" autocomplete="new-password" required name="password">
                </div>        
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@foreach ($data as $d)                           
<!-- Modal Hapus-->
<div class="modal fade" id="modal-destroy{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Data</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Anda Yakin Ingin Menghapus Data <b>{{ $d->nama_wali }}</b>
        </div>
        <div class="modal-footer">
            <form action="{{ route('walisantri.destroy', $d->id ) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
            </form>
        </div>
        </div>
    </div>
</div>
@endforeach

@include('template.footer')