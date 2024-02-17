<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Softskill Semester {{ $gangen }} {{ $tahun_ajaran }}</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div id="accordion">
                    @foreach($jadwal as $praktikum)
                        <div class="card mb-4">
                            <h5 class="mb-0">
                                <button class="btn btn-primary btn-block" data-toggle="collapse"
                                    data-target="#NO-{{ $praktikum['id'] }}"
                                    aria-expanded="true"
                                    aria-controls="NO-{{ $praktikum['id'] }}">
                                    <div class="text-left p-2 mx-3">
                                        Semester
                                        {{ $praktikum['semester'] ?? '' }}
                                        <h5 class="font-weight-bold">
                                            {{ $praktikum['name_of_course'] ?? '' }}
                                        </h5>
                                    </div>
                                </button>
                            </h5>

                            {{-- @php --}}
                            {{-- print_r($errors->all()) --}}
                            {{-- @endphp --}}

                            <div id="NO-{{ $praktikum['id'] }}" class="collapse"
                                aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="p-2 mx-2">
                                        <div class="row">
                                            <div class="col-8">
                                                Tanggal : {{ $praktikum['tanggal'] }}
                                                <br>
                                                @php
                                                    $unformatted_jam_mulai = new DateTime($praktikum['jam_mulai']);
                                                    $jam_mulai = $unformatted_jam_mulai->format('H:i');
                                                    $unformatted_jam_selesai = new DateTime($praktikum['jam_selesai']);
                                                    $jam_selesai = $unformatted_jam_selesai->format('H:i');
                                                @endphp
                                                Waktu : {{ $jam_mulai }} s.d {{ $jam_selesai }}
                                                <br>
                                                Pembicara : {{ $praktikum['pembicara'] }}
                                                <br>
                                                <form class="mt-4" method="POST"
                                                    action="{{ url('jadwal-softskill/upload-bukti-kehadiran') }}"
                                                    enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        @csrf
                                                        <input type="hidden" name="id_praktikum"
                                                            value="{{ $praktikum['course_id'] }}">
                                                        <input type="hidden" name="t_akademik"
                                                            value="{{ $praktikum['thajaranid'] }}">
                                                        <input type="hidden" name="semester"
                                                            value="{{ $praktikum['termid'] }}">
                                                        <input type="hidden" name="id_jadwal"
                                                            value="{{ $praktikum['id'] }}">
                                                        <input type="file" name="bukti_kegiatan"
                                                            class="form-control-file">
                                                        <br>
                                                        <button type="submit" class="btn btn-success">
                                                            kirim foto bukti kegiatan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            @if(!empty($praktikum['screenshot']))
                                                <div class="col-4">
                                                    <img style="max-height: 150px;"
                                                        src="{{ url('bukti-presensi-softskill/' . $praktikum['screenshot']) }}">
                                                </div>
                                            @endif
                                        </div>
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
