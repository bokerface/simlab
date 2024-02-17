<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Praktikum Semester {{ $semester_nama }} 2021/2022</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div id="accordion">
                    @foreach ($jadwal as $praktikum)
                    <div class="card mb-4">
                        <h5 class="mb-0">
                            <button class="btn btn-primary btn-block" data-toggle="collapse"
                                data-target="#{{ $praktikum['course_id'] }}" aria-expanded="true"
                                aria-controls="{{ $praktikum['course_id'] }}">
                                <div class="text-left p-2 mx-3">
                                    Semester {{ $praktikum['semester'] ?? '' }}
                                    <h5 class="font-weight-bold">
                                        {{ $praktikum['praktikum'] ?? '' }}
                                    </h5>
                                </div>
                            </button>
                        </h5>

                        <div id="{{ $praktikum['course_id'] }}" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                <div class="p-2 mx-2">
                                    {{-- <div class="row"> --}}
                                        @foreach ($praktikum['jadwal'] as $jadwal)
                                        <div class="col-sm">
                                            <h6>
                                                Kelas {{ $jadwal['kelas'] }} :
                                                <p>
                                                    {{ $jadwal['hari'] }}, {{ $jadwal['jam_mulai'] }} -
                                                    {{ $jadwal['jam_selesai'] }}
                                                    , ruang {{ $jadwal['ruang'] }}
                                                </p>
                                            </h6>
                                        </div>
                                        @endforeach
                                        {{--
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-slot name='js'></x-slot>
</x-layouts>