<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Kuliah Lapangan</h1>
        </div>

        @if ($errors->any())
        <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
        @endif

        <div class="card mx-auto col-lg-8 col-md-8 col-sm-12 mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">{{ $praktikum->name_of_course }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('/jadwal-praktikum/tambah-jadwal-kuliah-lapangan') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_praktikum" value="{{ $praktikum->COURSE_ID }}">
                    <input type="hidden" name="tahun_ajaran" value="{{ $praktikum->THAJARANID }}">
                    <input type="hidden" name="semester" value="{{ $praktikum->TERMID }}">

                    <div class="form-group">
                        <label for="acara">Acara</label>
                        <input type="text" class="form-control {{ $errors->has('acara')?'is-invalid':'' }}" id="acara"
                            name="acara" placeholder="Nama Acara" value="{{ old(" acara") }}">
                        <div class="invalid-feedback">
                            {{ $errors->first('acara') }}
                        </div>
                    </div>
                    {{-- <div class="form-group"> --}}
                        {{-- <label for="tempat">Tempat</label> --}}
                        {{-- <input type="text" class="form-control {{ $errors->has('tempat')?'is-invalid':'' }}"
                            id="tempat" name="tempat" placeholder="Nama Gedung/Tempat Acara" value="{{ old(" tempat")
                            }}"> --}}
                        {{-- <div class="invalid-feedback"> --}}
                            {{-- {{ $errors->first('tempat') }} --}}
                            {{-- </div> --}}
                        {{-- </div> --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Mulai</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('tanggal_mulai')?'is-invalid':'' }}"
                                    id="tanggal_mulai" name="tanggal_mulai" placeholder="Tanggal Mulai" value="{{ old("
                                    tanggal_mulai") }}">
                                <div class="invalid-feedback">
                                    {{ $errors->first('tanggal_mulai') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Selesai</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('tanggal_selesai')?'is-invalid':'' }}"
                                    id="tanggal_selesai" name="tanggal_selesai" placeholder="Tanggal Selesai"
                                    value="{{ old(" tanggal_selesai") }}">
                                <div class="invalid-feedback">
                                    {{ $errors->first('tanggal_selesai') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-6">
                            <label for="tahun_ajaran">Tahun Ajaran</label>
                            <input type="number" class="form-control {{ $errors->has('tahun_ajaran')?'is-invalid':'' }}"
                                name="tahun_ajaran" id="tahun_ajaran" placeholder="Tahun Ajaran" value="{{ old("
                                tahun_ajaran") }}">
                            <div class="invalid-feedback">
                                {{ $errors->first('tahun_ajaran') }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="semester">Semester</label>
                                <input type="number" min="1" max="6"
                                    class="form-control {{ $errors->has('semester')?'is-invalid':'' }}" id="semester"
                                    name="semester" placeholder="Semester" value="{{ old(" semester") }}">
                                <div class="invalid-feedback">
                                    {{ $errors->first('semester') }}
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label for="instansi">Instansi/Lembaga</label>
                        <input type="text" class="form-control {{ $errors->has('instansi')?'is-invalid':'' }}"
                            id="instansi" name="instansi" placeholder="Nama Instansi/Lembaga Penyelenggara"
                            value="{{ old(" instansi") }}">
                        <div class="invalid-feedback">
                            {{ $errors->first('instansi') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tema">Tema</label>
                        <input type="text" class="form-control {{ $errors->has('tema')?'is-invalid':'' }}" id="tema"
                            name="tema" placeholder="Tema Kuliah Lapangan" value="{{ old(" tema") }}">
                        <div class="invalid-feedback">
                            {{ $errors->first('tema') }}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    @push('css')
    <link rel="stylesheet" href="{{asset('vendor/xdsoft-datetimepicker/jquery.datetimepicker.min.css')}}">
    @endpush

    @push('js')
    <script type="text/javascript" src="{{asset('vendor/xdsoft-datetimepicker/jquery.datetimepicker.full.min.js')}}">
    </script>

    <script>
        jQuery('#tanggal_mulai').datetimepicker();
        jQuery('#tanggal_selesai').datetimepicker();
    </script>
    @endpush

</x-layouts>