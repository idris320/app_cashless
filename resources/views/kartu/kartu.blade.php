@include('template.head')
@include('template.sidebar')
@include('template.topbar')

<div class="container-fluid pt-4 px-4"> 
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
    <div class="card bg-light text-dark">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
          <h5>Data Kartu Santri</h5>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">                    
            <button class="btn btn-success mr-2" data-bs-toggle="modal" data-bs-target="#tambahkartu"><i class="fas fa-plus"></i> Data Kartu Santri</button>
          </div>
        </div>
        <div class="card-body "> 
          <div class="table-responsive">         
            <table class="table table-hover text-dark" id="tabelku">
                <thead>
                    <tr>
                    <th scope="col">#</th>                    
                    <th scope="col">Nama Santri</th>
                    <th scope="col">Saldo</th>                    
                    <th scope="col">Tanggal Aktivasi</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>                  
                    </tr>
                </thead>
                <tbody>
                  @foreach ($data as $index => $dk)
                  <tr>
                  <th scope="row">{{ $index + 1 }}</th>                                    
                  <td>{{ $dk->santri->nama_santri }}</td>                  
                  <td> Rp.{{ number_format($dk->saldo, 0, ',', '.') }}</td>
                  <td>{{ $dk->tanggal_aktivasi }}</td>                                
                  {{-- <td>{{ $dk->status }}</td>    --}}
                  <td>                    
                    <div class="form-check form-switch">
                      <input class="form-check-input status-toggle" type="checkbox" role="switch" data-id="{{ $dk->id }}" {{ $dk->status == 'aktif' ? 'checked' : '' }}>
                      <label class="form-check-label" for="flexSwitchCheckDefault">{{ $dk->status }}</label>
                    </div>
                  </td>   
                  <td>                    
                    <button type="button" class="btn btn-sm btn-success custom-btn" data-bs-toggle="modal" data-bs-target="#gantiKartu{{ $dk->id}}"><i class="fas fa-edit"></i></button>
                  </td>               
                </tr>
                @endforeach
                </tbody>
            </table> 
          </div>       
        </div>        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahkartu" tabindex="-1" aria-labelledby="tambahkartuLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tambahkartuLabel">Santri yang belum memiliki kartu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover text-dark" id="tabelku">
          <thead>
            <tr>
            <th scope="col">#</th>                    
            <th scope="col">Nama Santri</th>                                                        
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>                  
            </tr>
          </thead>
          <tbody>
            @foreach ($stk as $index => $st)
            <tr>
            <th scope="row">{{ $index + 1 }}</th>                                    
            <td>{{ $st->nama_santri }}</td>                                               
            <td>{{ $st->status }}</td>   
            <td>                    
              <button type="button" class="btn btn-sm btn-success custom-btn" data-bs-toggle="modal" data-bs-target="#daftarkartu{{ $st->id }}"><i class="fas fa-plus"></i></button>
            </td>               
          </tr>
          @endforeach
          </tbody>
      </table>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>
    </div>
  </div>
</div>


@foreach ($stk as $df)
<!-- Modal daftar kartu -->
<div class="modal fade" id="daftarkartu{{ $df->id }}" tabindex="-1" aria-labelledby="daftarkartuLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="daftarkartuLabel">Daftar Kartu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('kartu.store') }}" id="formKartu">
          @csrf
          <input type="hidden" name="id_kartu" value="{{ random_int(100000, 999999) }}">
          <input type="hidden" name="id_santri" value="{{ $df->id }}">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" aria-describedby="namaHelp" name="nama" disabled value="{{ $df->nama_santri }}">            
          </div>
          <div class="mb-3">
            <label for="no_kartu" class="form-label">No Kartu</label>
            <input type="text" class="form-control" id="no_kartu" autocomplete="off" aria-describedby="namaHelp" name="no_kartu" autocomplete="new-password">            
          </div>
          <div class="mb-3">
            <label for="pin" class="form-label">Password</label>
            <input type="password" class="form-control" id="isiPasswordKartudulu" name="pin" autocomplete="new-password">
          </div>          
          <div class="mb-3">
            <label for="datedaftar" class="form-label">Tanggal Aktivasi</label>
            <input type="date" class="form-control" id="datedaftar" name="tanggal_aktivasi" value="{{ date('Y-m-d') }}">
          </div>                        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>
      </form>
    </div>
  </div>
</div>  
@endforeach


{{-- form ganti kartu --}}
@foreach ($data as $gk)
<div class="modal fade" id="gantiKartu{{ $gk->id }}" tabindex="-1" aria-labelledby="gantiKartuLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="gantiKartuLabel">Edit Data Kartu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="kartuTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active text-success" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Ubah Password</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link text-success" id="hilang-tab" data-bs-toggle="tab" data-bs-target="#gantikartu" type="button" role="tab">Ganti Kartu</button>
          </li>        
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="kartuTabContent">
          <div class="tab-pane fade show active" id="password" role="tabpanel">
            <!-- Tabel atau konten kartu aktif -->
            <form method="POST" action="{{ route('kartu.update-password',$gk->id) }}" id="formKartu">
              @csrf
              <input type="hidden" name="id_kartu_lama" value="{{ $gk->id }}">
              <input type="hidden" name="id_santri" value="{{ $gk->id_santri }}">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" aria-describedby="namaHelp" name="nama" disabled value="{{ $gk->santri->nama_santri }}">            
              </div>
              <div class="mb-3">
                <label for="nama" class="form-label">No Kartu</label>
                <input type="text" class="form-control" id="no_kartu" aria-describedby="namaHelp" disabled name="no_kartu" autocomplete="off" value="{{ $gk->no_kartu }}">            
              </div>          
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="isiPassword" name="password" autocomplete="new-password">
              </div>     
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Keterangan</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="keterangan"></textarea>
              </div> 
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
            </form>
          </div>

          <!-- Tabel atau konten ganti Kartu -->
          <div class="tab-pane fade" id="gantikartu" role="tabpanel">
            <!-- Tabel atau konten ganti kartu -->
            <form method="POST" action="{{ route('kartu.gantikartu') }}" id="formKartuBaru">
              @csrf              
              <input type="hidden" name="id_kartu_lama" value="{{ $gk->id }}">
              <input type="hidden" name="id_santri" value="{{ $gk->id_santri }}">
              <input type="hidden" name="id_pegawai" value="{{ auth()->user()->IdPegawai }}">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" aria-describedby="namaHelp" name="nama" disabled value="{{ $gk->santri->nama_santri }}">            
              </div>
              <div class="mb-3">
                <label for="saldo" class="form-label">Saldo</label>
                <input type="text" class="form-control" id="saldo" aria-describedby="namaHelp" disabled name="saldo" autocomplete="off" value="{{ number_format($dk->saldo, 0, ',', '.') }}">            
              </div>   
              <div class="mb-3">
                <label for="nama" class="form-label">No Kartu Lama</label>
                <input type="text" class="form-control" id="no_kartu_lama" aria-describedby="namaHelp" disabled name="no_kartu" autocomplete="off" value="{{ $gk->no_kartu }}">            
              </div>   
              <div class="mb-3">
                <label for="kartu_baru" class="form-label">No Kartu Baru</label>
                <input type="text" class="form-control" id="kartu_baru" aria-describedby="namaHelp" name="kartu_baru" autocomplete="off">            
              </div>          
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="isiPasswordKartubaru" name="password" autocomplete="new-password">
              </div>   
              <div class="mb-3">
                <label for="datedaftar" class="form-label">Tanggal Aktivasi</label>
                <input type="date" class="form-control" id="datedaftar" name="tanggal_aktivasi" value="{{ date('Y-m-d') }}">
              </div>   
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Keterangan</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="keterangan" placeholder="Contoh : Pengganti kartu hilang"></textarea>
              </div> 
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
            </form>
          </div>          
        </div>
      </div>
                              
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>         --}}
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>      
    </div>
  </div>
</div>  
  
@endforeach


@include('template.footer')
<script>
  document.getElementById('formKartu').addEventListener('keydown', function(e) {
    // Cegah submit jika Enter ditekan dan password belum diisi
    if (e.key === 'Enter') {
      const password = document.getElementById('isiPasswordKartudulu').value;
      if (!password) {
        e.preventDefault(); // Blok submit
      }
    }
  });
</script>

<script>
  document.getElementById('formKartuBaru').addEventListener('keydown', function(e) {
    // Cegah submit jika Enter ditekan dan password belum diisi
    if (e.key === 'Enter') {
      const password = document.getElementById('isiPasswordKartubaru').value;
      if (!password) {
        e.preventDefault(); // Blok submit
      }
    }
  });
</script>

<script>
$(document).ready(function () {
  $('.status-toggle').on('change', function () {
    let kartuId = $(this).data('id');
    let newStatus = $(this).is(':checked') ? 'aktif' : 'tidak aktif'; // atau 'nonaktif', tergantung logikamu

    $.ajax({
      url: '{{ route("kartu.update-status") }}',
      method: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        id: kartuId,
        status: newStatus
      },
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Status diperbarui ke: ' + newStatus,
          timer: 1000,
          showConfirmButton: false
        }).then(() => {
          location.reload();
        });
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: 'Status tidak berhasil diperbarui.',
        });
      }
    });
  });
});
</script>