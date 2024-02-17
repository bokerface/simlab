<x-layouts>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Arsip Praktikum</h1>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush" id="data-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Praktikum</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            {{-- <th>Tempat</th> --}}
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
        $(function() {
                $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('arsip-praktikum-data') }}",
                    columns: [
                        { data: 'name_of_course', name: 'name_of_course' },
                        { data: 'THAJARANID', name: 'THAJARANID' },
                        { data: 'TERMID', name: 'semester' },
                        // { data: 'tempat', name: 'tempat' },
                    ]
                });
            }
        );
    </script>
    @endpush

</x-layouts>