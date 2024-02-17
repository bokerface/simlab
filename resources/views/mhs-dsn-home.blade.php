<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        @if($errors->any())
            <x-alert :type="$errors->first('type')" :message="$errors->first('message')" />
        @endif

        @if($survey_done == false)
            <x-alert type='warning'
                message="Anda belum mengisi survey. Silahkan isi survey <a
                        href='{{ url('survey') }}'>disini</a> sebelum {{ $survey_data->expires_at ?? '' }}." />
        @endif

        @if($message = Session::get('success'))
            <x-alert :type="$message['type']" :message="$message['message']" />
        @endif
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5>Selamat Datang</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-md mb-1">Ini adalah halaman pengelolaan SIM Praktikum Ilmu
                            Pemerintahan UMY
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('js')
    @endpush

</x-layouts>
