<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Kuliah Umum</h1>
        </div>

        @if ($errors->any())
        <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
        @endif

        @if ($errors->any())
        {{ print_r($errors) }}
        @endif

        <div class="card mx-auto col-lg-8 col-md-8 col-sm-12 mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">{{ $praktikum['name_of_course'] }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('/jadwal-praktikum/tambah-jadwal-kuliah-umum') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id_praktikum" value="{{ $praktikum['COURSE_ID'] }}">
                    <input type="hidden" name="tahun_ajaran" value="{{ $praktikum['THAJARANID'] }}">
                    <input type="hidden" name="semester" value="{{ $praktikum['TERMID'] }}">
                    {{-- <input type="hidden" name="id_praktikums[]" value="asdf123">
                    <input type="hidden" name="id_praktikums[]" value="ghjk234"> --}}
                    <div class="form-group">
                        <label for="tempat">Tempat</label>
                        <input type="text" class="form-control {{ $errors->has('tempat')?'is-invalid':'' }}" id="tempat"
                            name="tempat" placeholder="nama gedung">
                        <div class="invalid-feedback">
                            {{ $errors->first('tempat') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control {{ $errors->has('tanggal')?'is-invalid':'' }}"
                                    name="tanggal" id="tanggal">
                                <div class="invalid-feedback">
                                    {{ $errors->first('tanggal') }}
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="jam_mulai">Jam Mulai</label>
                                <input type="text" class="form-control {{ $errors->has('jam_mulai')?'is-invalid':'' }}"
                                    name="jam_mulai" id="jam_mulai">
                                <div class="invalid-feedback">
                                    {{ $errors->first('jam_mulai') }}
                                </div>
                                {{-- <input type="time" class="form-control" name="jam_mulai" id="jam_mulai"> --}}
                            </div>
                            <div class="col-4">
                                <label for="jam_selesai">Jam Selesai</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('jam_selesai')?'is-invalid':'' }}"
                                    name="jam_selesai" id="jam_selesai">
                                <div class="invalid-feedback">
                                    {{ $errors->first('jam_selesai') }}
                                </div>
                                {{-- <input type="time" class="form-control" name="jam_selesai" id="jam_selesai"> --}}
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="tahun_ajaran">Tahun Ajaran</label>
                                <input type="number" class="form-control" name="tahun_ajaran" id="tahun_ajaran"
                                    placeholder="Tahun Ajaran Kuliah Umum">
                            </div>
                            <div class="col-6">
                                <label for="semester">Semester</label>
                                <input type="number" max="6" min="1" class="form-control" name="semester" id="semester"
                                    placeholder="Semester Kuliah Umum">
                            </div>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        <label for="tema">Tema</label>
                        <input type="text" class="form-control {{ $errors->has('tema')?'is-invalid':'' }}" id="tema"
                            name="tema" placeholder="tema kuliah umum">
                        <div class="invalid-feedback">
                            {{ $errors->first('tema') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_moderator">Moderator</label>
                        <input type="text" class="form-control {{ $errors->has('nama_moderator')?'is-invalid':'' }}"
                            id="nama_moderator" name="nama_moderator" placeholder="Nama Moderator">
                        <div class="invalid-feedback">
                            {{ $errors->first('nama_moderator') }}
                        </div>
                    </div>
                    <div class="form-group mb-5">
                        <label for="foto_moderator">Foto Moderator</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto_moderator" name="foto_moderator"
                                required>
                            <label class="custom-file-label" for="customFile">Pilih Foto</label>
                        </div>
                    </div>

                    <ul class="nav nav-pills mb-3 mx-auto d-flex justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active btn" id="pills-pembicara-1-tab" data-toggle="pill"
                                href="#pills-pembicara-1" role="tab" aria-controls="pills-pembicara-1"
                                aria-selected="true">
                                Pembicara 1
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link btn" id="pills-pembicara-2-tab" data-toggle="pill"
                                href="#pills-pembicara-2" role="tab" aria-controls="pills-pembicara-2"
                                aria-selected="false">
                                Pembicara 2
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link btn" id="pills-pembicara-3-tab" data-toggle="pill"
                                href="#pills-pembicara-3" role="tab" aria-controls="pills-pembicara-3"
                                aria-selected="false">
                                Pembicara 3
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mb-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-pembicara-1" role="tabpanel"
                            aria-labelledby="pills-pembicara-1-tab">
                            <x-tab_pembicara no-pembicara="1" />
                        </div>
                        <div class="tab-pane fade" id="pills-pembicara-2" role="tabpanel"
                            aria-labelledby="pills-pembicara-2-tab">
                            <x-tab_pembicara no-pembicara="2" />
                        </div>
                        <div class="tab-pane fade" id="pills-pembicara-3" role="tabpanel"
                            aria-labelledby="pills-pembicara-3-tab">
                            <x-tab_pembicara no-pembicara="3" />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    @push('css')
    <link rel="stylesheet" href="{{asset('vendor/jquery-timepicker/dist/wickedpicker.min.css')}}">
    @endpush

    @push('js')
    <script type="text/javascript" src="{{asset('vendor/jquery-timepicker/dist/wickedpicker.min.js')}}"></script>

    <script>
        var option_jam_mulai = {
                // now: "00:00",
                twentyFour: true, //Display 24 hour format, defaults to false
                upArrow: 'wickedpicker__controls__control-up', //The up arrow class selector to use, for custom CSS
                downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
                close: 'wickedpicker__close', //The close class selector to use, for custom CSS
                hoverState: 'hover-state', //The hover state class to use, for custom CSS
                title: 'Timepicker', //The Wickedpicker's title,
                showSeconds: false, //Whether or not to show seconds,
                timeSeparator: ':', // The string to put in between hours and minutes (and seconds)
                secondsInterval: 1, //Change interval for seconds, defaults to 1,
                minutesInterval: 1, //Change interval for minutes, defaults to 1
                beforeShow: null, //A function to be called before the Wickedpicker is shown
                afterShow: null, //A function to be called after the Wickedpicker is closed/hidden
                show: null, //A function to be called when the Wickedpicker is shown
                clearable: false, //Make the picker's input clearable (has clickable "x")
            };
    
            var option_jam_selesai = {
                now: "00:00",
                twentyFour: true, //Display 24 hour format, defaults to false
                upArrow: 'wickedpicker__controls__control-up', //The up arrow class selector to use, for custom CSS
                downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
                close: 'wickedpicker__close', //The close class selector to use, for custom CSS
                hoverState: 'hover-state', //The hover state class to use, for custom CSS
                title: 'Timepicker', //The Wickedpicker's title,
                showSeconds: false, //Whether or not to show seconds,
                timeSeparator: ':', // The string to put in between hours and minutes (and seconds)
                secondsInterval: 1, //Change interval for seconds, defaults to 1,
                minutesInterval: 1, //Change interval for minutes, defaults to 1
                beforeShow: null, //A function to be called before the Wickedpicker is shown
                afterShow: null, //A function to be called after the Wickedpicker is closed/hidden
                show: null, //A function to be called when the Wickedpicker is shown
                clearable: false, //Make the picker's input clearable (has clickable "x")
            };
    
            $('#jam_mulai').wickedpicker(option_jam_mulai);
            $('#jam_selesai').wickedpicker(option_jam_selesai);
    </script>
    @endpush

</x-layouts>