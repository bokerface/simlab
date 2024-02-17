<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profil Dosen</h1>
        </div>

        <div class="row">
            <div class="col-lg-7 col-md-10 col-sm-12 mb-4 mx-auto mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row px-2 mb-3">
                            <div>
                                <img src="https://rdironworks.com/wp-content/uploads/2017/12/dummy-200x200.png"
                                    class="rounded float-left" style="max-height: 100px" alt="..." />
                            </div>
                            <div class="d-flex ml-4">
                                <div class="align-self-center">
                                    <h5 class="font-weight-bold">{{ $data['nama'] }}</h5>
                                    <span>{{ $data['nik'] }}</span>
                                    <br>
                                    {{-- <span>sakir.ridho@umy.ac.id</span> --}}
                                </div>
                            </div>
                        </div>
                        <hr class="sidebar-divider">
                        <div>
                            <form action="{{ url('/edit_dosen') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id_pegawai" value="{{ $data['id_pegawai'] }}">
                                <input type="hidden" name="id_rekening" value="{{ $data['rekening']['id'] ?? '' }}">
                                <h5 class="font-weight-bold">Pembayaran</h5>
                                <br>
                                <div class="form-group row">
                                    <label for="norek" class="col-sm-3 col-form-label">No Rekening</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="rekening" id="norek" class="form-control"
                                            placeholder="No Rekening" value="{{ $data['rekening']['no_rek'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bank" class="col-sm-3 col-form-label">Bank</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="bank" class="form-control" id="bank"
                                            placeholder="Nama Bank" value="{{ $data['rekening']['bank'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cabang" class="col-sm-3 col-form-label">Cabang</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="cabang" class="form-control" id="cabang"
                                            placeholder="Cabang" value="{{ $data['rekening']['cabang'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="pemegang_rekening" class="form-control" id="nama"
                                            placeholder="Nama Pemegang Rekening"
                                            value="{{ $data['rekening']['nama_rekening'] ?? '' }}">
                                    </div>
                                </div>
                                <br>
                                <h5 class="font-weight-bold">Kontak</h5>
                                <br>
                                <div class="form-group row">
                                    <label for="telepon" class="col-sm-3 col-form-label">Telepon</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_telp" class="form-control" id="telepon"
                                            placeholder="No Telepon" value="{{ $data['rekening']['telepon'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="whatsapp" class="col-sm-3 col-form-label">Whatsapp</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_wa" class="form-control" id="whatsapp"
                                            placeholder="No Whatsapp" value="{{ $data['rekening']['whatsapp'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-lg btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')

    @endpush
</x-layouts>