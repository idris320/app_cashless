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
          confirmButtonText: 'OK',
          confirmButtonColor: '#218838'
      });
  </script>
@endif

{{-- notif form error --}}
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

<style>
  .custom-btn {
    padding: 2px 8px;
    font-size: 12px;
  }
</style>
    <div class="card bg-light text-dark">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
          <h5>Data Santri</h5>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahwalisantri"><i class="fas fa-plus"></i> Data Wali Santri</button>
            <button class="btn btn-success mr-2" data-bs-toggle="modal" data-bs-target="#tambahsantri"><i class="fas fa-plus"></i> Data Santri</button>
          </div>
        </div>
        <div class="card-body ">  
          <div class="table-responsive">      
            <table class="table table-hover text-dark" id="tabelku">
                <thead>
                    <tr>
                    <th scope="col">#</th>                    
                    <th scope="col">Nama</th>
                    <th scope="col">Wali Santri</th>
                    <th scope="col">No Kartu</th>
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
                  @if ($s->kartu)
                    <td>{{ $s->kartu->no_kartu }}</td>  
                  @else
                    <td>Belum punya kartu</td>
                  @endif                               
                  <td>{{ $s->tempat_lahir }}</td>                  
                  <td>{{ $s->tanggal_lahir }}</td>                  
                  <td>{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}}</td>                  
                  <td>{{ $s->alamat }}</td>                  
                  <td>{{ $s->status }}</td>   
                  <td>                    
                    <button type="button" class="btn btn-sm btn-success custom-btn" data-bs-toggle="modal" data-bs-target="#aksiModal{{ $s->id }}"><i class="fas fa-eye"></i></button>
                  </td>               
                  </tr>                    
                  @endforeach
                </tbody>
            </table>  
          </div>      
        </div>        
    </div>
</div>


@foreach ($data as $ak)
<!-- Modal Aksi -->
<div class="modal fade" id="aksiModal{{ $ak->id }}" tabindex="-1" aria-labelledby="aksiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="aksiModalLabel">Pilih Aksi {{ $ak->nama_s }}, 
          @if ($ak->kartu)
            Rp {{ number_format($ak->kartu->saldo, 0, ',', '.') }}
          @else
            Belum punya kartu            
          @endif    
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <!-- Baris 1 -->
          <div class="row mb-3">
            <div class="col-4">
              <a href="{{ route('santri.edit', $ak->id) }}" class="btn btn-outline-primary w-100"><i class="fas fa-edit"></i> Edit</a>              
            </div>
            <div class="col-4">
              @php
                $disabled = $ak->kartu ? '' : 'disabled';
              @endphp
              <button class="btn btn-outline-success w-100" type="button" data-bs-toggle="modal" data-bs-target="#topUp{{ $ak->id }}" {{ $disabled }}>Top Up</button>
            </div>
            <div class="col-4">
              <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#modal-destroy{{ $ak->id }}"><i class="fas fa-trash"></i></button>
            </div>
          </div>          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endforeach

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
                      <label for="id_wali" class="form-label">Wali Santri</label>
                      <select id="walisantriDropdown" class="form-select" name="id_wali">   
                        <option value="">Wali Santri</option>
                      @foreach ($ws as $w)                                                
                        <option value="{{ $w->id }}">{{ $w->nama_wali }} , {{ $w->no_telp }}</option>                        
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
                    <input type="password" class="form-control" id="password" required name="password">
                </div>        
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
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
            <b>Anda Yakin Ingin Menghapus Data <b>{{ $d->nama_santri }}</b>
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


@foreach ($data as $tu)
<!-- Modal Top up-->
<div class="modal fade" id="topUp{{ $tu->id }}" tabindex="-1" aria-labelledby="topUpLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="topUpLabel">Top Up Saldo {{ $tu->nama_santri }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('kartu.topup') }}" id="formKartu">
          @csrf
          @if ($tu->kartu)
          <input type="hidden" name="id_kartu" value="{{ $tu->kartu->id }}">
          @endif
          <input type="hidden" name="id_santri" value="{{ $tu->id }}">
          <input type="hidden" name="id_pegawai" value="{{ auth()->user()->IdPegawai }}">

          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" aria-describedby="namaHelp" name="nama" disabled value="{{ $tu->nama_santri }}">            
          </div>
          <div class="mb-3">
            @if ($tu->kartu)                            
              <label for="no_kartu" class="form-label">No Kartu</label>
              <input type="text" class="form-control" id="no_kartu" aria-describedby="namaHelp" name="no_kartu" disabled autocomplete="new-password" value="{{ $tu->kartu->no_kartu }}">            
            @endif 
          </div>

          @if ($ak->kartu)
          <div class="mb-3">
            <label for="saldo" class="form-label">Saldo</label>
            <input type="text" class="form-control" id="saldo" aria-describedby="saldoHelp" name="saldo" disabled value="{{ number_format($ak->kartu->saldo, 0, ',', '.') }}">            
          </div>                  
          @endif    

          <div class="mb-3">
            <label for="nominal" class="form-label">Nominal Top Up</label>
            <input type="number" class="form-control" id="nominal" name="nominal" autocomplete="new-password">
          </div>                                  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Proses</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> {{ route('kartu.topup') }} --}}
      </div>
      </form>
    </div>
  </div>
</div>
@endforeach


@include('template.footer')

<script>
  $('#tambahsantri').on('shown.bs.modal', function () {
  if (!$('#walisantriDropdown').hasClass("select2-hidden-accessible")) {
    $('#walisantriDropdown').select2({
      theme: 'bootstrap-5',
      dropdownParent: $('#tambahsantri'),
      placeholder: "Cari nama wali...",
      allowClear: true,
      width: '100%'
    });
  }
});

</script>