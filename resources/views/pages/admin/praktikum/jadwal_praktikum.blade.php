<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Praktikum Semester {{ $semester_nama }} 2021/2022</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                {{-- {{ print_r($data) }} --}}
                {{-- <x-table :kolom="$kolom" :isi="$isi"></x-table> --}}
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    @foreach ($kolom as $kolom)
                                    <th>{{ $kolom }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($isi as $praktikum)
                                <tr>
                                    <th>{{ $praktikum['praktikum'] }}</th>
                                    <td>
                                        @foreach ($praktikum['jadwal'] as $jadwal)
                                        {!! html_entity_decode($jadwal[0]) !!}
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name='js'></x-slot>
</x-layouts>