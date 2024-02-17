<x-layouts>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mahasiswa</h1>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="data-table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Tahun Akademik</th>
                            <th>softskill</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <!-- Page level custom scripts -->
        <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

        <script>
            $(function () {
                $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('peserta-softskill-data') }}",
                    },
                    columns: [{
                            data: 'photo_profile',
                            name: 'photo_profile',
                            render: function (data) {
                                return "<img src=" + data +
                                    " class='rounded float-left' style='max-height: 90px;max-width:90px' alt='foto' />"
                            }
                        },
                        {
                            data: 'STUDENTID',
                            name: 'STUDENTID'
                        },
                        {
                            data: 'FULLNAME',
                            name: 'FULLNAME'
                        },
                        {
                            data: 't_akademik',
                            name: 't_akademik'
                        },
                        {
                            data: 'softskill_progress',
                            name: 'softskill_progress',
                            render: function (data) {
                                return "<div class='progress'><div class='progress-bar' role='progressbar' style='width:" +
                                    data + "%' aria-valuenow='" + data +
                                    "' aria-valuemin='0' aria-valuemax='100'>" + ((data / 100) *
                                        6)
                                    .toFixed(0) + "/" + 6 + "</div></div>"
                            }
                        }
                    ]
                });
            });

        </script>
    @endpush

</x-layouts>
