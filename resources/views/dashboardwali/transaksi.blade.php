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
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#218838'
                });
            </script>
            @endforeach
        @endif
        <div class="card bg-light text-dark">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h5>Data Transaksi {{ $data->nama_santri }}</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahdatapegawai"><i class="fas fa-plus"></i> Tambah Data</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">  
                    <table class="table table-hover text-dark" id="tabelku">
                        <thead>
                            <tr>
                            <th scope="col">#</th>                        
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Transaksi</th>                      
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal Transaksi</th>
                            <th scope="col">Aksi</th>                  
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->transaksi as $d)
                            <tr>
                            <th scope="row">{{ $loop->iteration }}</th>                      
                            <td>{{ $data->nama_santri }}</td>
                            <td>{{ $d->jenis}}</td>                            
                            <td class="{{ strtolower($d->jenis) === 'topup' ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($d->total, 0, ',', '.') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($d->tanggal_transaksi)->format('d/m/Y H:i') }}</td>                            
                            <td>                                
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $d->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                            </tr>                            
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
</div>


{{-- detail transaksi --}}
@foreach ($data->transaksi as $dt)
    <!-- Modal -->
<div class="modal fade" id="modal-detail-{{ $dt->id }}" tabindex="-1" aria-labelledby="modalDetailLabel-{{ $dt->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalDetailLabel-{{ $dt->id }}">
            Detail Transaksi - {{ \Carbon\Carbon::parse($dt->tanggal_transaksi)->format('d/m/Y') }}
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Nama Santri:</strong> {{ $data->nama_santri }}<br>
                <strong>Jenis Transaksi:</strong> {{ $dt->jenis }}<br>
                <strong>Total Transaksi:</strong> Rp{{ number_format($dt->total, 0, ',', '.') }}
            </div>
            <div class="col-md-6">
                <strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($dt->tanggal_transaksi)->format('d/m/Y H:i') }}<br>
                <strong>Saldo Awal:</strong> Rp{{ number_format($dt->saldo_awal, 0, ',', '.') }}<br>
                <strong>Saldo Akhir:</strong> Rp{{ number_format($dt->saldo_akhir, 0, ',', '.') }}
            </div>
        </div>
        
        <div class="table-responsive">  
            <table class="table table-hover">
                <thead class="table-success">
                    <tr>
                        <th scope="col">#</th>                        
                        <th scope="col">Nama Barang</th>                      
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Sub Total</th>                                    
                    </tr>
                </thead>
                <tbody>                   
                    @forelse ($dt->detail as $i => $item)
                        <tr>
                            <th scope="row">{{ $i + 1 }}</th>                            
                            <td>{{ $item->barang->nama_barang ?? 'N/A' }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($item->sub_total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada detail transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($dt->detail->count() > 0)
                <tfoot>
                    <tr class="table-success">
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td><strong>Rp{{ number_format($dt->total, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endforeach

@include('template.footer')