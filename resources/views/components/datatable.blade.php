<div class="col-lg-12">
    <div class="card mb-4">
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="data-table">
                <thead class="thead-light">
                    <tr>
                        <th>Softskill</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Tempat</th>
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
                ajax: "{{ url('arsip-softskill-data') }}",
                columns: [
                    { data: 'nama_matkul', name: 'nama_matkul' },
                    { data: 't_akademik', name: 't_akademik' },
                    { data: 'semester', name: 'semester' },
                    { data: 'tempat', name: 'tempat' },
                ]
            });
        });
</script>
@endpush