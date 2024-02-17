<x-layouts>
    <div class="col-12" id="app">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Buat Kurikulum Baru</h1>
        </div>

        @if ($errors->any())
        <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
        @endif

        @if ($message = Session::get('success'))
        <x-alert :type="$message['type']" :message="$message['message']" />
        @endif

        <div class="col-lg-8 col-sm-12 col-md-12 mb-4 mx-auto">
            <div class="card mb-3">
                <div class="card-header mb-0">
                    <div class="d-flex mb-0 mx-2 mt-2 justify-content-between font-weight-bold">
                        <span>Kurikulum</span>
                        <br>
                        <span>Buat Kurikulum Kurikulum</span>
                    </div>
                </div>
                <hr class="navbar-divider">
                <div class="card-body">
                    <div class="mx-4 mt-4">
                        <form action="{{ url('kurikulum/buat-kurikulum-baru') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-3 d-flex align-items-center">
                                    <label for="nama-kurikulum" class="font-weight-bold my-auto">Nama</label>
                                </div>
                                <div class="form-group col-9">
                                    <input type="text" class="form-control col-6" id="nama-kurikulum"
                                        name="nama_kurikulum">
                                    <small>*contoh penamaan : kurikulum 2010</small>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-3">
                                    <label class="font-weight-bold">Mata Kuliah</label>
                                </div>
                                <div class="form-group col-9">
                                    @foreach ($data as $softskill)
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input"
                                            value="{{ $softskill['id_praktikum'] }}"
                                            id="{{ $softskill['id_praktikum'] }}" name="id_praktikum[]">
                                        <label class="form-check-label" for="{{ $softskill['id_praktikum'] }}">
                                            {{ $softskill['nama'] }}
                                        </label>
                                    </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts>
