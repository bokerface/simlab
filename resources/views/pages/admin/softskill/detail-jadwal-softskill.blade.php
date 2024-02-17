<x-layouts>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Presensi Softskils</h1>
    </div>

    <!-- Row -->
    <section id="softskils">
        <div class="row title">
            <div class="col-lg-12">
                <h4 class="text-center"><b>{{ $jadwal_softskill->name_of_course }}</b></h4>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
                <h6 class="tr"><i class='fas fa-calendar-alt'></i><b>{{ $jadwal_softskill->tanggal }}</b></h6>
                <br>
                <h6 class="tr"><i class='fas fa-map-marker-alt'></i><b>{{ $jadwal_softskill->tempat }}</b></h6>
            </div>
            <div class="col-lg-6">
                <h6><i class='fas fa-comment'></i><b>{{ $jadwal_softskill->name_of_course }}</b></h6><br>
                <h6><i class='fas fa-microphone'></i><b>{{ $jadwal_softskill->pembicara }}</b></h6>
            </div>
        </div>

        <div class="row" id="app">
            <!-- Datatables -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    {{-- <div class="form-group my-2 mx-1 col-4">
                        <label for="search">Cari Mahasiswa</label>
                        <div class="ml-1 row">
                            <input type="text" class="form-control col-9 col-sm-12" id="search" name="search"
                                placeholder="masukkan nama atau nim">
                            <div class="col-2 ml-1 col-sm-12">
                                <button class="btn btn-primary" name="submit" id="submit">cari</button>
                            </div>
                        </div>
                    </div> --}}
                    <div class="">
                        <label for="search" class="col-sm-2 mx-2 col-form-label">Cari Mahasiswa</label>
                        <div class="form-group row m-2">
                            <div class="col-sm-3 mx-0">
                                <input type="text" placeholder="masukkan nama atau nim" class="form-control" id="search"
                                    name="search">
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-primary py-2 px-3" name="submit" id="submit">cari</button>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Presensi</th>
                                        <th>Screenshot</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Row-->
    </section>

    @push('js')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $('#dataTableHover').DataTable({
            bFilter: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('detail-jadwal-softskill-data/'.$jadwal_softskill->id) }}",
                type: "GET",
                data: function (data) {
                    data.search = $('#search').val();
                }
            },
            columns: [{
                    data: 'foto_mahasiswa',
                    name: 'foto_mahasiswa',
                    render: function (data) {
                        return "<span> <img style='max-height: 90px;max-width:90px' src='" + data
                            .foto + "'> </span> <br>" + data.nim;
                    }
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'presensi',
                    name: 'presensi',
                },
                {
                    data: 'screenshot',
                    name: 'screenshot',
                    render: function (data) {
                        return "<img style='max-height: 60px;' src='" + data + "'>";
                    }
                }
            ]
        }); // ID From dataTable 

        $('#submit').click(function () {
            $('#dataTableHover').DataTable().draw(true);
        });

        function cek_kehadiran(id_presensi) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ url('verifikasi-kehadiran') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id_presensi,
                }
            });
        }

    </script>



    @endpush
</x-layouts>
