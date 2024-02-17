<x-components::layouts>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Survey</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ url('survey/tambah') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nama-survey">Nama Survey</label>
                    <input type="text"
                        class="form-control {{ $errors->has('nama_survey')?'is-invalid':'' }}"
                        name="nama_survey" id="nama-survey" value="{{ old(" nama_survey") }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_survey') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="deskripsi-survey">Deskripsi</label>
                    <textarea
                        class="form-control {{ $errors->has('deskripsi_survey')?'is-invalid':'' }}"
                        name="deskripsi_survey" id="deskripsi-survey"
                        rows="3">{{ old("deskripsi_survey") }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('deskripsi_survey') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="expired-survey">Tanggal Survey Berakhir</label>
                    <input type="date"
                        class="form-control {{ $errors->has('expired_date')?'is-invalid':'' }}"
                        name="expired_date" id="expired-survey" value="{{ old('expired_date') }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('expired_date') }}
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="Tambah">
                </div>
            </form>
        </div>
    </div>
</x-components::layouts>
