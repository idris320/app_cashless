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
                <h5>Data Pegawai</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahdatapegawai"><i class="fas fa-plus"></i> Tamabah Data</button>
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
                            @foreach ($data as $index => $d)
                            <tr>
                            <th scope="row">{{ $index + 1 }}</th>                        
                            <td>{{ $d->santri->nama_santri }}</td>
                            <td>{{ $d->jenis}}</td>                            
                            <td class="{{ strtolower($d->jenis) === 'topup' ? 'text-success' : 'text-danger' }}">
                                {{ $d->total }}
                            </td>
                            <td>{{ $d->tanggal_transaksi }}</td>                            
                            <td>                                
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-detail{{ $d->id }}"><i class="fas fa-eye"></i></button>
                            </td>
                            </tr>                            
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
</div>

@include('template.footer')