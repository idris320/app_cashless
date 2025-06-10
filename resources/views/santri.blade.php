@include('template.head')
@include('template.sidebar')
@include('template.topbar')

<div class="container-fluid pt-4 px-4"> 
    <div class="card bg-light">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
          <span>Data Santri</span>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">          
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahwalisantri"><i class="fas fa-plus"></i> Data Wali Santri</button>
            <button class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#tambahsantri"><i class="fas fa-plus"></i> Data Santri</button>
          </div>
        </div>
        <div class="card-body ">        
            <table class="table table-hover" id="mytable">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tempat Tanggal Lahir</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>                  
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    {{-- {{<td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                    <td>@mdo</td>}} --}}
                    </tr>
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
                <div class="row">                 

                  {{-- rigth --}}
                  <div class="col">
                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="nama" aria-describedby="nama" name="nama">
                    </div>
                    <div class="mb-3">
                      <label for="ttl" class="form-label">Tempat Lahir</label>
                      <input type="text" class="form-control" id="ttl" name="tempatLahir">
                    </div>
                    <div class="mb-3">
                      <label for="kartu" class="form-label">Id Kartu</label>
                      <input type="text" class="form-control" id="kartu" name="idKartu">
                    </div>  
                  </div>

                  {{-- left --}}
                  <div class="col">
                    <div class="mb-3">
                      <label for="ttl" class="form-label">Tanggal Lahir</label>
                      <input type="date" class="form-control" id="ttl" name="ttl">
                    </div>                            
                    <div class="mb-3">
                      <label for="jk" class="form-label">Jenis Kelamin</label>
                      <select id="jk" class="form-select" name="jk">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('walisantri.store') }}">
          @csrf
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama">
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


@include('template.footer')