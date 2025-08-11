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
<style>
  .custom-btn {
    padding: 2px 8px;
    font-size: 12px;
  }
</style>
    <div class="card bg-light text-dark">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
          <h>Data Santri</h>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahwalisantri"><i class="fas fa-plus"></i> Data Wali Santri</button>
            <button class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#tambahsantri"><i class="fas fa-plus"></i> Data Santri</button>
          </div>
        </div>
        <div class="card-body ">        
            <table class="table table-hover text-dark" id="tabelku">
                <thead>
                    <tr>
                    <th scope="col">#</th>                    
                    <th scope="col">Nama</th>
                    <th scope="col">Wali Santri</th>
                    <th scope="col">Tempat Lahir</th>
                    <th scope="col">Tempat Tanggal Lahir</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>                  
                    </tr>
                </thead>
                <tbody>
                  @foreach ($data as $index => $s)
                  <tr>
                  <th scope="row">{{ $index + 1 }}</th>
                  <td>{{ $s->nama_santri }}</td>                  
                  <td>{{ $s->wali->nama_wali }}</td>                  
                  <td>{{ $s->tempat_lahir }}</td>                  
                  <td>{{ $s->tanggal_lahir }}</td>                  
                  <td>{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}}</td>                  
                  <td>{{ $s->alamat }}</td>                  
                  <td>{{ $s->status }}</td>   
                  <td>
                    <a href="{{ route('santri.edit', $s->id) }}" class="btn btn-sm btn-primary custom-btn"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-sm btn-danger custom-btn" data-bs-toggle="modal" data-bs-target="#modal-destroy{{ $s->id }}"><i class="fas fa-trash"></i></button>
                  </td>               
                  </tr>                    
                  @endforeach
                </tbody>
            </table>        
        </div>        
    </div>
</div>

<!-- Modaltambah data santri-->
<div class="modal fade" id="tambahsantri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Input Data Santri Baru</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('santri.store') }}">
              @csrf
                <input type="hidden" class="form-control" id="id" aria-describedby="id" name="id" value="{{ random_int(100000, 999999) }}">
                <input type="hidden" name="role" value="santri">
                <div class="row">                 

                  {{-- rigth --}}
                  <div class="col">
                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="nama" aria-describedby="nama" name="nama">
                    </div>
                    <div class="mb-3">
                      <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                      <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                    </div>
                    <div class="mb-3">
                      <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                      <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                    </div>                            
                  </div>
                  
                  {{-- left --}}
                  <div class="col">                    
                    <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>                            
                    <div class="mb-3">
                      <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                      <select id="jenis_kelamin" class="form-select" name="jenis_kelamin">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                    </div>            
                    <div class="mb-3">
                      <label for="wali_santri" class="form-label">Wali Santri</label>
                      <select id="wali_santri" class="form-select" name="wali_santri">                                            
                        @foreach ($ws as $w)                                                
                        <option value="{{ $w->id }}">{{ $w->nama }} , {{ $w->alamat }}</option>                        
                        @endforeach                                    
                      </select>
                    </div>  
                  </div>
                </div>                                          
            </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!--Modal Tambah Data Wali Santri baru-->  
<div class="modal fade" id="tambahwalisantri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah data wali santri</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('santri.store') }}">
          @csrf
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
            <input type="text" class="form-control" id="noTelp" required name="no_telp">
          </div>        
          <div class="mb-3">
            <label for="email" class="form-label">email</label>
            <input type="email" class="form-control" id="email" required name="email">
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
            Anda Yakin Ingin Menghapus Data <b>{{ $d->nama }}</b>
        </div>
        <div class="modal-footer">
            <form action="{{ route('santri.destroy', $d->id ) }}" method="POST">
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