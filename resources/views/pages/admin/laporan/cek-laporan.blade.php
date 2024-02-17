<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cek Praktikum Selesai</h1>
        </div>
        <p>Pelaporan praktikum yang akan dinyatakan selesai</p>

        @if ($errors->any())
        <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
        @endif

        <div class="d-sm-flex align-items-center justify-content-between my-4">
            <h5 class="mx-auto">{{ $praktikum->name_of_course }}</h5>
        </div>

        <div class="card mx-auto col-lg-6 col-md-6 col-sm-12 mb-4">
            <div class="card-body">
                <div id="app">
                    <form method="POST" action="{{ url('cek-laporan/'.$laporan->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id_praktikum" value="{{ $laporan->id }}">
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="laporan_praktikum">Praktikum</label>
                                <br>
                                <a href="{{ url('laporan-praktikum/'.$laporan->laporan_praktikum) }}">
                                    <small>
                                        Download Laporan
                                    </small>
                                </a>
                            </div>
                            <div class="col-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" {{ $laporan->praktikum_selesai == 1 ?
                                    'checked' : '' }} name="laporan_praktikum"
                                    id="laporan_praktikum_ok" value="ok" @change="changeLaporanPraktikum($event)">
                                    <label class="form-check-label" for="laporan_praktikum_ok">OK</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laporan_praktikum"
                                        id="laporan_praktikum_revisi" {{ !empty($laporan->catatan1) &&
                                    empty($laporan->praktikum_selesai) ? 'checked' : ''}} value="revisi"
                                    @change="changeLaporanPraktikum($event)">
                                    <label class="form-check-label" for="laporan_praktikum_revisi">Revisi</label>
                                </div>
                                <textarea class="form-control" id="catatan_revisi_praktikum"
                                    name="catatan_revisi_praktikum" rows="3" v-if="laporan_praktikum == 'revisi'">{{
                                    !empty($laporan->catatan1) ? $laporan->catatan1 : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="laporan_kuliah_umum">Kuliah Umum</label>
                                <br>
                                <a href="{{ url('laporan-kuliah-umum/'.$laporan->laporan_kuliah_umum) }}">
                                    <small>
                                        Download Laporan
                                    </small>
                                </a>
                            </div>
                            <div class="col-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" {{ $laporan->kuliah_umum_selesai == 1
                                    && empty($laporan->catatan2) ?
                                    'checked' : '' }} name="laporan_kuliah_umum"
                                    id="laporan_kuliah_umum_ok" value="ok"
                                    @change="changeLaporanKuliahUmum($event)">
                                    <label class="form-check-label" for="laporan_kuliah_umum_ok">OK</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laporan_kuliah_umum"
                                        id="laporan_kuliah_umum_revisi" {{ !empty($laporan->catatan2) &&
                                    empty($laporan->kuliah_umum_selesai) ? 'checked' : ''}} value="revisi"
                                    @change="changeLaporanKuliahUmum($event)">
                                    <label class="form-check-label" for="laporan_kuliah_umum_revisi">Revisi</label>
                                </div>
                                <textarea class="form-control" id="catatan_revisi_kuliah_umum"
                                    name="catatan_revisi_kuliah_umum" rows="3" v-if="laporan_kuliah_umum == 'revisi'">{{
                                    $laporan->catatan2 != '' ? $laporan->catatan2 : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="laporan_kuliah_lapangan">Kuliah Lapangan</label>
                                <br>
                                <a href="{{ url('laporan-kuliah-lapangan/'.$laporan->laporan_kuliah_lapangan) }}">
                                    <small>
                                        Download Laporan
                                    </small>
                                </a>
                            </div>
                            <div class="col-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" {{ $laporan->kuliah_lapangan_selesai ==
                                    1 && empty($laporan->catatan3) ? 'checked' : '' }}
                                    name="laporan_kuliah_lapangan"
                                    id="laporan_kuliah_lapangan_ok" value="ok"
                                    @change="changeLaporanKuliahLapangan($event)">
                                    <label class="form-check-label" for="laporan_kuliah_lapangan_ok">OK</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laporan_kuliah_lapangan"
                                        id="laporan_kuliah_lapangan_revisi" {{ !empty($laporan->catatan3) &&
                                    empty($laporan->kuliah_lapangan_selesai) ? 'checked' : '' }} value="revisi"
                                    @change="changeLaporanKuliahLapangan($event)">
                                    <label class="form-check-label" for="laporan_kuliah_lapangan_revisi">Revisi</label>
                                </div>
                                <textarea class="form-control" id="catatan_revisi_kuliah_lapangan"
                                    name="catatan_revisi_kuliah_lapangan" rows="3"
                                    v-if="laporan_kuliah_lapangan == 'revisi'">{{
                                    $laporan->catatan3 != '' ? $laporan->catatan3 : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4 ml-3">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script>
        var app = new Vue({
            el : "#app",
            data : {
                laporan_praktikum : "{{ !empty($laporan->catatan1) && empty($laporan->praktikum_selesai) ? 'revisi' : ''}}",
                laporan_kuliah_umum : "{{ !empty($laporan->catatan2) && empty($laporan->kuliah_umum_selesai) ? 'revisi' : ''}}",
                laporan_kuliah_lapangan : "{{ !empty($laporan->catatan3) && empty($laporan->kuliah_lapangan_selesai) ? 'revisi' : ''}}",
                // 

            },
            methods : {
                changeLaporanPraktikum(event){
                    var data = event.target.value;
                    this.laporan_praktikum = data;
                    console.log(this.laporan_praktikum);
                },
                changeLaporanKuliahUmum(event){
                    var data = event.target.value;
                    this.laporan_kuliah_umum = data;
                    console.log(this.laporan_kuliah_umum);
                },
                changeLaporanKuliahLapangan(event){
                    var data = event.target.value;
                    this.laporan_kuliah_lapangan = data;
                    console.log(this.laporan_kuliah_lapangan);
                },
            }
        });
    </script>
    @endpush

</x-layouts>