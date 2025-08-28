@include('template.head')
@include('template.sidebar')
@include('template.topbar')

<div class="container-fluid pt-4 px-4">         

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
                <h5>Data Pegawai</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahbarang"><i class="fas fa-plus"></i> Tamabah Barang</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">  
                    <table class="table table-hover text-dark" id="tabelku">
                        <thead>
                            <tr>
                            <th scope="col">#</th>                        
                            <th scope="col">Nama Barang</th>                       
                            <th scope="col">Harga</th>                            
                            <th scope="col">Aksi</th>                  
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $d)
                            <tr>
                            <th scope="row">{{ $index + 1 }}</th>                        
                            <td>{{ $d->nama_barang }}</td>
                            <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                            <td>                                
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-edit{{ $d->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-destroy{{ $d->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                            </tr>                            
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
</div>


<!-- Modal Tambah Barang-->
<div class="modal fade" id="tambahbarang" tabindex="-1" aria-labelledby="topUpLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="topUpLabel">Tambah Barang</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('barang.store') }}" id="formKartu">
          @csrf
          <input type="hidden" name="id_barang" value="{{ random_int(100000, 999999) }}">                  
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama_barang" aria-describedby="namaHelp" name="nama_barang" >            
          </div>
          <div class="mb-3">                                      
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga" aria-describedby="namaHelp" name="harga">                        
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

{{-- edit barang --}}
@foreach ($data as $da)
<div class="modal fade" id="modal-edit{{ $da->id}}" tabindex="-1" aria-labelledby="topUpLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="topUpLabel">Edit Barang</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('barang.update', $da->id) }}" id="formKartu">
          @csrf
          <input type="hidden" name="id_barang" value="{{ $da->id }}">                  
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama_barang" aria-describedby="namaHelp" name="nama_barang" value="{{ $da->nama_barang }}">            
          </div>
          <div class="mb-3">                                      
              <label for="harga" class="form-label">Harga</label>
              <input type="number" class="form-control" id="harga" aria-describedby="namaHelp" name="harga" value="{{ $da->harga }}">                        
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
            <b>Anda Yakin Ingin Menghapus Data <b>{{ $d->nama_barang }}</b>
        </div>
        <div class="modal-footer">
            <form action="{{ route('barang.destroy', $d->id ) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
            </form>
        </div>
        </div>
    </div>
</div>
@endforeach


@include('template.footer')