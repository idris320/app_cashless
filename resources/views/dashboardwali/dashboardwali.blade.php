@include('template.head')
@include('template.sidebarwali')
@include('template.topbar')


<!-- Menu -->
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    @foreach ($data as $ds)
                    <div class="col-md-6 mb-4">
                        <div class="card text-white shadow-sm border-0 rounded-3" style="width: 18rem; background: linear-gradient(135deg, #52cf6f, #07f33a);">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-light">{{ $ds->nama_santri }}</h5>
                                <p class="card-text">
                                    Saldo <span class="fw-semibold">Rp.{{ number_format($ds->kartu->saldo, 0, ',', '.') }}</span>
                                </p>
                                <div class="d-flex justify-content-end">
                                    <a href="#" class="btn btn-light btn-sm">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    @endforeach                                                      
                </div>
            </div>
            <!-- Sale & Revenue End -->
@include('template.footer')