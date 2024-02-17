<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Praktikum Semester {{ $semester_nama }} 2021/2022</h1>
        </div>

        @if ($errors->any())
        <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
        @endif

        @if ($message = Session::get('success'))
        <x-alert :type="$message['type']" :message="$message['message']" />
        @endif

        @if ($data)
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div id="accordion">
                    @foreach ($data as $detail_praktikum)
                    <div class="card mb-4">
                        <h5 class="mb-0">
                            <button class="btn btn-primary btn-block" data-toggle="collapse"
                                data-target="#{{ $detail_praktikum['id_praktikum'] }}" aria-expanded="true"
                                aria-controls="{{ $detail_praktikum['id_praktikum'] }}">
                                <div class="text-left p-2 mx-3">
                                    Semester {{ $detail_praktikum['semester'] }}
                                    <h5 class="font-weight-bold">
                                        {{$detail_praktikum['nama_praktikum']}}
                                    </h5>
                                </div>
                            </button>
                        </h5>

                        <div id="{{ $detail_praktikum['id_praktikum'] }}" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                <div class="p-2 mx-2">
                                    <div class="p-2 mx-3">
                                        <div class="row mb-5">
                                            <span class="mr-3 p-2">Status Laporan</span>
                                            @if ($detail_praktikum['laporan'])
                                            @if (!empty($detail_praktikum['laporan']->catatan1) ||
                                            !empty($detail_praktikum['laporan']->catatan2)||
                                            !empty($detail_praktikum['laporan']->catatan3))
                                            <a class="btn btn-primary"
                                                href="{{ url('/jadwal-praktikum/revisi-laporan/'.$detail_praktikum['laporan']->id) }}">
                                                Revisi
                                            </a>
                                            @elseif($detail_praktikum['laporan']->praktikum_selesai == 1 &&
                                            $detail_praktikum['laporan']->kuliah_umum_selesai == 1 &&
                                            $detail_praktikum['laporan']->kuliah_lapangan_selesai == 1)
                                            <a class="btn btn-success"
                                                href="{{ url('/jadwal-praktikum/revisi-laporan/'.$detail_praktikum['laporan']->id) }}">
                                                Laporan OK
                                            </a>
                                            {{-- @elseif($detail_praktikum['laporan']->laporan_praktikum == '' &&
                                            $detail_praktikum['laporan']->laporan_kuliah_umum == '' &&
                                            $detail_praktikum['laporan']->laporan_kuliah_lapangan == '')
                                            <a class="btn btn-success"
                                                href="{{ url('/jadwal-praktikum/buat-laporan/'.$detail_praktikum['id_praktikum']) }}">
                                                Kirim Laporan
                                            </a> --}}
                                            @else
                                            <a class="btn btn-success disabled" href="">
                                                Menunggu Evaluasi Admin
                                            </a>
                                            @endif
                                            @else
                                            <a class="btn btn-success"
                                                href="{{ url('/jadwal-praktikum/buat-laporan/'.$detail_praktikum['id_praktikum'].'/'.$detail_praktikum['tahun_ajaran'].'/'.$detail_praktikum['semester']) }}">
                                                Kirim Laporan
                                            </a>
                                            @endif
                                        </div>
                                        <div>
                                            <table class="table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Praktikum</th>
                                                        <th scope="col">Semester</th>
                                                        <th scope="col">Jadwal</th>
                                                        <th scope="col">Ruang</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detail_praktikum['jadwal_praktikum'] as
                                                    $jadwal_praktikum)
                                                    <tr>
                                                        <th scope="row">
                                                            {{ $jadwal_praktikum['nama_praktikum'] }} kelas
                                                            {{ $jadwal_praktikum['kelas'] }}
                                                        </th>
                                                        <td>{{ $jadwal_praktikum['semester'] }}</td>
                                                        <td>{{ $jadwal_praktikum['hari'] }},
                                                            {{ $jadwal_praktikum['jam_mulai'] }} -
                                                            {{ $jadwal_praktikum['jam_selesai'] }}
                                                        </td>
                                                        <td>{{ $jadwal_praktikum['ruang'] }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-5">
                                            <p>Kuliah Umum</p>
                                            @if ($detail_praktikum['jadwal_kuliah_umum'])
                                            @foreach ($detail_praktikum['jadwal_kuliah_umum'] as $jadwal)
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="font-weight-bold mr-5">Tanggal</span>
                                                    <span class="font-weight-bold mr-2">{{ $jadwal->tanggal }}</span>
                                                    <span class="font-weight-bold mr-2">
                                                        {{ date('H:i',strtotime($jadwal->jam_mulai)) }}
                                                    </span>
                                                    <span class="font-weight-bold mr-2">-</span>
                                                    <span class="font-weight-bold mr-5">
                                                        {{ date('H:i',strtotime($jadwal->jam_selesai)) }}
                                                    </span>
                                                    <span class="font-weight-bold mr-5">
                                                        Tempat
                                                    </span>
                                                    <span class="font-weight-bold mr-4">
                                                        {{ $jadwal->tempat }}
                                                    </span>
                                                    <a href="{{ url('/jadwal-praktikum/edit-kuliah-umum/'.$jadwal->id) }}"
                                                        class="btn btn-secondary">Edit</a>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <a href="{{ url('/jadwal-praktikum/tambah-jadwal-kuliah-umum/'.$detail_praktikum['id_praktikum']).'/'.$detail_praktikum['tahun_ajaran'].'/'.$detail_praktikum['semester'] }}"
                                                class="btn btn-primary">Buat Jadwal</a>
                                            @endif

                                        </div>
                                        <div class="mt-5">
                                            <p>Kuliah Lapangan</p>
                                            @if ($detail_praktikum['jadwal_kuliah_lapangan'])
                                            @foreach ($detail_praktikum['jadwal_kuliah_lapangan'] as $jadwal)
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="font-weight-bold mr-5">Tanggal</span>
                                                    <span class="font-weight-bold mr-2">
                                                        {{-- {{ $jadwal->tanggal_start }} --}}
                                                        {{ date('Y-m-d H:i',strtotime($jadwal->tanggal_start)) }}
                                                    </span>
                                                    <span class="font-weight-bold mr-2">-</span>
                                                    <span class="font-weight-bold mr-5">
                                                        {{ date('Y-m-d H:i',strtotime($jadwal->tanggal_end)) }}
                                                    </span>
                                                    <span class="font-weight-bold mr-5">
                                                        Tempat
                                                    </span>
                                                    <span class="font-weight-bold mr-4">
                                                        {{ $jadwal->instansi }}
                                                    </span>
                                                    <a href="{{ url('/jadwal-praktikum/edit-jadwal-kuliah-lapangan/'.$jadwal->id) }}"
                                                        class="btn btn-secondary">Edit</a>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <a href="{{ url('/jadwal-praktikum/tambah-jadwal-kuliah-lapangan/'.$detail_praktikum['id_praktikum']).'/'.$detail_praktikum['tahun_ajaran'].'/'.$detail_praktikum['semester'] }}"
                                                class="btn btn-primary">
                                                Buat Jadwal
                                            </a>
                                            @endif

                                        </div>
                                        <div class="mt-5">
                                            <div class="row">
                                                @if ($detail_praktikum['pembayaran'])
                                                @foreach ($detail_praktikum['pembayaran'] as $detail_pembayaran)
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="font-weight-bold">
                                                                Pembayaran
                                                                {{$detail_pembayaran['jenis']}}
                                                            </h5>
                                                            <hr class="sidebar-divider">
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                    <button class="btn btn-success px-5" disabled>
                                                                        Lunas
                                                                    </button>
                                                                </div>
                                                                <div class="col-lg-6 col-md-12 col-sm-12 p-2">
                                                                    <a href="{{ url('bukti_pembayaran/'.$detail_pembayaran['file_bukti']) }}"
                                                                        class="p-2">Bukti Trf</a>
                                                                </div>
                                                            </div>
                                                            <div class="mt-3">
                                                                <span class="font-weight-bold">BSI 123456789</span><br>
                                                                <span class="font-weight-bold">
                                                                    Rp. {{ $detail_pembayaran['nominal'] }}
                                                                </span><br>
                                                                <span class="font-weight-bold">
                                                                    {{ $detail_pembayaran['tanggal'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <p>tidak ada jadwal pada semester ini</p>
        @endif
    </div>

</x-layouts>