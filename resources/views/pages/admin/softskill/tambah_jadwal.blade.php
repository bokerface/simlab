<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Softskill</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="card col-8">
            <div class="card-body" id="app">
                <form method="POST" action="{{ url('/save_jadwal_softskill') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="nama-softskill" class="col-sm-3 col-form-label">Softskill</label>
                        <div class="col-sm-9">
                            {{-- <v-select v-model="selected_softskill" :options="softskills_options"
                                id="nama-softskill" placeholder="pilih softskill" @search="search()"
                                :value="softskills_options">
                            </v-select> --}}
                            <select class="form-control mb-3" name="softskill">
                                <option>pilih softskill</option>
                                @foreach ($softskill_options as $softskill)
                                <option value="{{ $softskill->course_id }}">{{ $softskill->name_of_course }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" id="tanggal" class="form-control" name="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jam_mulai" class="col-sm-3 col-form-label">Jam Mulai</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control {{ $errors->has('jam_mulai')?'is-invalid':'' }}"
                                name="jam_mulai" id="jam_mulai">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jam_selesai" class="col-sm-3 col-form-label">Jam Selesai</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control {{ $errors->has('jam_selesai')?'is-invalid':'' }}"
                                name="jam_selesai" id="jam_selesai">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pembicara" class="col-sm-3 col-form-label">Pembicara</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="pembicara" name="pembicara"
                                placeholder="nama pembicara">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tempat" class="col-sm-3 col-form-label">Tempat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tempat" name="tempat" placeholder="nama gedung">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="semester" class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9">
                            <input type="number" min="1" max="2" class="form-control" id="semester" name="semester"
                                placeholder="semester softskill yang akan dilaksanakan (1/2)">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    @push('css')
    <link rel="stylesheet" href="{{asset('vendor/jquery-timepicker/dist/wickedpicker.min.css')}}">
    @endpush

    @push('js')
    <script type="text/javascript" src="{{asset('vendor/jquery-timepicker/dist/wickedpicker.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- <script src="https://unpkg.com/vue-select@3.0.0"></script> --}}
    {{--
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css"> --}}
    <script>
        // Vue.component('v-select', VueSelect.VueSelect)
    </script>
    <script>
        // var app = new Vue({
        //     el : '#app',
        //     data : {
        //         softskills_options : [
        //             {
        //                 label:"soft1",
        //                 code:"s1"
        //             }
        //         ],
        //         selected_softskill : ""
        //     },
        //     methods:{
        //         search : function() {
        //             // console.log("asdf");
        //             console.log(this.selected_softskill.code);
        //         }
        //     },
        //     mounted(){

        //     }
        // });

        var option_jam_mulai = {
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