<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Softskill Semester {{ $semester_nama }} 2021/2022</h1>
        </div>

        @if (session('user_data')['role'] == 1)
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="{{ url('jadwal-softskill/tambah-jadwal') }}" class="btn btn-primary">Tambah Jadwal Softskill</a>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                {{-- {{ print_r($data) }} --}}
                <x-table :kolom="$kolom" :isi="$isi"></x-table>
            </div>
        </div>
    </div>
</x-layouts>