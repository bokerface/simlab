<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 font-weight-bold">
                Pembayaran
            </h1>
        </div>
        <span class="text-secondary">Pembayaran praktikum ke {{ $data['nama'] }}</span>
        <hr class="sidebar-divider">
        <div class="mt-3" id="app">

            @if ($errors->any())
            <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
            @endif

            @if ($message = Session::get('success'))
            <x-alert :type="$message['type']" :message="$message['message']" />
            @endif

            @foreach ($praktikum as $praktikum)
            <div class="row">
                <div class="col-7 d-sm-flex align-items-center justify-content-between">
                    <h5 class="font-weight-bold">
                        {{ $praktikum['nama_praktikum'] }}
                        @if ($praktikum['laporan'])
                        <a href="{{ url('cek-laporan/'.$praktikum['laporan']->id) }}" class="ml-3">
                            <i class="far fa-file"></i>
                        </a>
                        @endif
                    </h5>
                </div>
                <div class="col-5">
                    @if (isset($praktikum['laporan']))
                    {{-- Button Praktikum Start --}}
                    @if ($praktikum['laporan']->praktikum_selesai == 1)
                    <button class="btn btn-primary p-2 btn-lg mr-2"
                        @click="openModalPembayaran('praktikum','Praktikum', '{{ $praktikum['id_praktikum'] }}',{{ $praktikum['tahun_ajaran'] }},{{ $praktikum['semester'] }})"
                        data-toggle="modal" data-target="#exampleModalCenter">
                        <small>Praktikum</small>
                    </button>
                    @else
                    <button class="btn btn-disabled">Praktikum</button>
                    @endif
                    {{-- Button Praktikum End --}}

                    {{-- Button Kuliah Umum Start --}}
                    @if ($praktikum['laporan']->kuliah_umum_selesai == 1)
                    <button class="btn btn-primary p-2 btn-lg mr-2"
                        @click="openModalPembayaran('kuliah-umum','Kuliah Umum','{{ $praktikum['id_praktikum'] }}',{{ $praktikum['tahun_ajaran'] }},{{ $praktikum['semester'] }})"
                        data-toggle="modal" data-target="#exampleModalCenter">
                        <small>Kuliah Umum</small>
                    </button>
                    @else
                    <button class="btn btn-disabled">Kuliah Umum</button>
                    @endif
                    {{-- Button Kuliah Umum End --}}

                    {{-- Button Kuliah Lapangan Start --}}
                    @if ($praktikum['laporan']->kuliah_lapangan_selesai == 1)
                    <button class="btn btn-primary p-2 btn-lg"
                        @click="openModalPembayaran('kuliah-lapangan','Kuliah Lapangan','{{ $praktikum['id_praktikum'] }}',{{ $praktikum['tahun_ajaran'] }},{{ $praktikum['semester'] }})"
                        data-toggle="modal" data-target="#exampleModalCenter">
                        <small>Kuliah Lapangan</small>
                    </button>
                    @else
                    <button class="btn btn-disabled">Kuliah Umum</button>
                    @endif
                    {{-- Button Kuliah Lapangan End --}}
                    @endif
                </div>
            </div>
            <br>
            @endforeach
            <x-modal_pembayaran :rekening="$data['rekening']" />
        </div>
        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Launch demo modal
        </button> --}}
    </div>
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var app = new Vue({
            el : "#app",
            data : {
                type : "",
                modal_title: "",
                id_praktikum : "",
                tahun_ajaran : "",
                semester: "",
                // data pembayaran
                sudah_dibayar : "",
                file_name : "",
                metode : "",
                nominal : "",
                tanggal : "",
            },
            methods:{
                openModalPembayaran : function(type_matkul,modal_title,id_praktikum,tahun_ajaran,semester){
                    this.type = type_matkul;
                    this.modal_title = modal_title;
                    this.id_praktikum = id_praktikum;
                    this.tahun_ajaran = tahun_ajaran;
                    this.semester = semester;
                    this.getDataPembayaran("{{ $data['id_pegawai'] }}",this.id_praktikum,this.tahun_ajaran,this.type,this.semester);
                },
                async getDataPembayaran(id_dosen, id_praktikum, id_tahun, jenis, semester){
                    try {
                        let response = await axios.get("{{ url('/data_pembayaran') }}"+"/"+id_dosen+"/"+id_praktikum+"/"+id_tahun+"/"+jenis+"/"+semester);

                        if(response.data){
                            // console.log(response.data);
                            this.metode = response.data['metode'];
                            this.nominal = response.data['nominal'];
                            this.tanggal = response.data['tanggal'];
                            this.file_name = "{{ url('bukti_pembayaran') }}"+"/"+response.data['file_bukti'];
                            this.sudah_dibayar = true;
                        }else{
                            this.metode = "";
                            this.nominal = "";
                            this.tanggal = "";
                            this.file_name = "";
                            this.sudah_dibayar = false;
                        }
                    } catch (error) {
                        console.log(error)
                    }
                }
            }
        });
    </script>
    @endpush
</x-layouts>