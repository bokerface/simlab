<x-layouts>
    <div class="col-12" id="app">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kurikulum</h1>
        </div>

        <div class="row">
            <div class="col-lg-7 col-sm-12 col-md-12 mb-4">
                <div class="card mb-3">
                    <div class="col-12 p-3">
                        <h6><b>Kurikulum Praktikum</b></h6>
                        <hr class="sidebar-divider">
                    </div>
                    <div class="col-12 mb-3" style="max-height: 340px;overflow-y: auto;">
                        <button v-for="kurikulum in kurikulum" :key="kurikulum.KURIKULUM_ID" type="button"
                            @click="get_kurikulum_praktikum(kurikulum)" class="btn btn-light btn-block">@{{
                            kurikulum.NAME_OF_CURRICULUM }}</button>
                    </div>
                    <div class="col-12 mb-3">
                        <h6><b>Praktikum</b></h6>
                        <div class="col-12">
                            <ul v-for="praktikum in praktikum" {{-- :key="praktikum.course_id" --}}>
                                @{{ praktikum.name_of_course }} (semester @{{ praktikum.study_level }})
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="col-12 p-3">
                        <h6><b>Kurikulum Softskill</b></h6>
                        <hr class="sidebar-divider">
                    </div>
                    <div class="col-12 mb-3" style="max-height: 340px;overflow-y: auto;">
                        <button @click="get_matkul_kurikulum_softskill(kurikulum_softskill)"
                            v-for="kurikulum_softskill in kurikulum_softskill" :key="kurikulum_softskill.KURIKULUM_ID"
                            type="button" class="btn btn-light btn-block">@{{ kurikulum_softskill.NAME_OF_CURRICULUM
                            }}</button>
                    </div>
                    <div class="col-12 mb-3">
                        <h6><b>Softskill</b></h6>
                        <div class="col-12">
                            <ul v-for="softskill in softskill">
                                @{{ softskill.name_of_course }} (semester @{{ softskill.study_level }})
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-md-12 mb-4">
                <div class="card mb-3">
                    <div class="col-12 p-3">
                        <h6><b>Setting Kurikulum Softskill tiap Tahun Akademik</b></h6>
                        <hr class="sidebar-divider">
                        <div class="col-12">
                            <form action="{{ url('/save_kurikulum_softskill') }}" method="POST">
                                @csrf
                                <input type="hidden" name="angkatan" value="{{ $current_year }}">

                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">
                                        <b>Tahun Akademik</b>
                                    </label>
                                    <div class="col-sm-7">
                                        <b>{{ $current_year }}</b>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="kurikulum" class="col-sm-5 col-form-label">
                                        <b>Pilih Kurikulum</b>
                                    </label>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="kurikulum" name="KURIKULUM_ID">
                                            @foreach ($daftar_kurikulum_softskill as $kurikulum)
                                            <option value="{{ $kurikulum->KURIKULUM_ID }}">
                                                <b>{{ $kurikulum->NAME_OF_CURRICULUM }}</b>
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-5"></div>
                                    <div class="col-sm-7">
                                        <button type="submit" class="btn btn-secondary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="col-12 p-3">
                        <h6><b>Kurikulum Softskill tiap Tahun Akademik</b></h6>
                        <hr class="sidebar-divider">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Tahun Akdemik</th>
                                            <th>Kurikulum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="tahun in kurikulum_tahun_ajaran">
                                            <td>@{{ tahun.tahun }}</td>
                                            <td>@{{ tahun.NAME_OF_CURRICULUM }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-vue-pagination@2.3.1/dist/laravel-vue-pagination.common.min.js">
    </script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                kurikulum: [],
                praktikum: [],
                softskill: [],
                kurikulum_softskill: [],
                kurikulum_tahun_ajaran: []
            },
            methods: {
                tambah: function (item) {
                    //    console.log(item.name);
                    this.praktikum = item.praktikum;
                },
                async get_kurikulum_praktikum(kurikulum) {
                    let kurikulum_id = kurikulum.KURIKULUM_ID;
                    try {
                        let response = await axios.get("{{ url('/praktikum-by-kurikulum-data') }}" + '/' +
                            kurikulum_id);
                        this.praktikum = response.data;
                    } catch (error) {
                        console.log(error)
                    }
                },
                async get_matkul_kurikulum_softskill(kurikulum_softskill) {
                    let kurikulum_softskill_id = kurikulum_softskill.KURIKULUM_ID;
                    try {
                        let response = await axios.get("{{ url('/softskill-by-kurikulum-data') }}" + '/' +
                            kurikulum_softskill_id);
                        this.softskill = response.data;
                        console.log(this.softskill);
                    } catch (error) {
                        console.log(error)
                    }
                },
                async get_kurikulum_softskill() {
                    try {
                        let response = await axios.get("{{ url('kurikulum-softskill-data') }}");
                        this.kurikulum_softskill = response.data;
                    } catch (error) {
                        console.log(error)
                    }
                },
                async get_kurikulum_tahun_ajaran() {
                    try {
                        let response = await axios.get("{{ url('/kurikulum-tahun-ajaran-data') }}");
                        this.kurikulum_tahun_ajaran = response.data;
                        // console.log(response.data);
                    } catch (error) {
                        console.log(error)
                    }
                }
            },
            async mounted() {
                this.get_kurikulum_tahun_ajaran();
                this.get_kurikulum_softskill();
                try {
                    let response = await axios.get("{{ url('/kurikulum-praktikum-data') }}");
                    this.kurikulum = response.data;
                    // console.log(this.kurikulum);
                } catch (error) {
                    console.log(error);
                }
            }
        });

    </script>
    @endpush

</x-layouts>
