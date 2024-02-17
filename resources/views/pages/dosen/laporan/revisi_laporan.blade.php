<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Revisi Laporan Kuliah Lapangan</h1>
        </div>
        <p>Laporan praktikum yang akan direvisi</p>

        @if ($errors->any())
        <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
        {{ print_r($errors) }}
        @endif

        <div class="d-sm-flex align-items-center justify-content-between my-4">
            <h5 class="mx-auto">{{ $praktikum->name_of_course }}</h5>
        </div>

        <div class="card mx-auto col-lg-8 col-md-8 col-sm-12 mb-4">
            {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">Praktikum Selesai</h5>
            </div> --}}
            <div class="card-body">
                <form method="POST" action="{{ url('/jadwal-praktikum/revisi-laporan/'.$laporan->id) }}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id_praktikum" value="{{ $praktikum->course_id }}">
                    <input type="hidden" name="tahun_ajaran" value="{{ $laporan->tahun }}">
                    <input type="hidden" name="semester" value="{{ $laporan->semester }}">

                    <div class="form-group row">
                        <div class="col-3">
                            <label for="laporan_praktikum">Praktikum</label>
                            <br>
                            <a href=""><small>Download Template</small></a>
                        </div>
                        @if ($laporan->praktikum_selesai != 1 && !empty($laporan->catatan1))
                        <div class="custom-file col-9">
                            <input type="file" class="custom-file-input" id="laporan_praktikum" name="laporan_praktikum"
                                required>
                            <label class="custom-file-label" for="laporan_praktikum">pilih file</label>
                        </div>
                        @else
                        <label class="text-success">Laporan OK</label>
                        @endif
                    </div>
                    @if ($laporan->praktikum_selesai != 1 && !empty($laporan->catatan1))
                    <div class="row mb-5">
                        <div class="col-3">
                            <label for="">catatan</label>
                        </div>
                        <textarea class="form-control col-9" disabled rows="3">{{ $laporan->catatan1 }}</textarea>
                    </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="laporan_kuliah_umum">Kuliah Umum</label>
                            <br>
                            <a href=""><small>Download Template</small></a>
                        </div>
                        @if ($laporan->kuliah_umum_selesai != 1 && !empty($laporan->catatan2))
                        <div class="custom-file col-9">
                            <input type="file" class="custom-file-input" id="laporan_kuliah_umum"
                                name="laporan_kuliah_umum" required>
                            <label class="custom-file-label" for="laporan_kuliah_umum">pilih file</label>
                        </div>
                        @elseif($laporan->kuliah_umum_selesai != 1 && empty($laporan->catatan2))
                        <label class="text-success">Menunggu Evaluasi Admin</label>
                        @else
                        <label class="text-success">Laporan OK</label>
                        @endif
                    </div>
                    @if ($laporan->kuliah_umum_selesai != 1 && !empty($laporan->catatan2))
                    <div class="row mb-5">
                        <div class="col-3">
                            <label for="">catatan</label>
                        </div>
                        <textarea class="form-control col-9" disabled rows="3">{{ $laporan->catatan2 }}</textarea>
                    </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="laporan_kuliah_lapangan">Kuliah Lapangan</label>
                            <br>
                            <a href=""><small>Download Template</small></a>
                        </div>
                        @if ($laporan->kuliah_lapangan_selesai != 1 && !empty($laporan->catatan3))
                        <div class="custom-file col-9">
                            <input type="file" class="custom-file-input" id="laporan_kuliah_lapangan"
                                name="laporan_kuliah_lapangan" required>
                            <label class="custom-file-label" for="laporan_kuliah_lapangan">pilih file</label>
                        </div>
                        @elseif($laporan->kuliah_lapangan_selesai != 1 && empty($laporan->catatan3))
                        <label class="text-success">Menunggu Evaluasi Admin</label>
                        @else
                        <label class="text-success">Laporan OK</label>
                        @endif
                    </div>
                    @if ($laporan->kuliah_lapangan_selesai != 1 && !empty($laporan->catatan3))
                    <div class="row mb-5">
                        <div class="col-3">
                            <label for="">catatan</label>
                        </div>
                        <textarea class="form-control col-9" disabled rows="3">{{ $laporan->catatan3 }}</textarea>
                    </div>
                    @endif

                    @if ($laporan->praktikum_selesai != 1 || $laporan->kuliah_umum_selesai != 1 ||
                    $laporan->kuliah_lapangan_selesai != 1)
                    <div class="form-group row">
                        <div class="col-3">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    @endif

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