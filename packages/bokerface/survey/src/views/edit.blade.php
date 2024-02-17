<x-components::layouts>
    <div class="mb-3">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Survey</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ url('survey/update/'.$detail_survey->id_survey) }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama-survey">Nama Survey</label>
                        <input type="text" class="form-control {{ $errors->has('nama_survey')?'is-invalid':'' }}"
                            name="nama_survey" id="nama-survey" value="{{ $detail_survey->survey_name ?? '' }}">
                        <div class="invalid-feedback">
                            {{ $errors->first('nama_survey') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi-survey">Deskripsi</label>
                        <textarea class="form-control {{ $errors->has('deskripsi_survey')?'is-invalid':'' }}"
                            name="deskripsi_survey" id="deskripsi-survey" rows="3">{{$detail_survey->survey_description
                            ?? '' }}</textarea>
                        <div class="invalid-feedback">
                            {{ $errors->first('deskripsi_survey') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="expired-survey">Tanggal Survey Berakhir</label>
                        <input type="date" class="form-control {{ $errors->has('expired_date')?'is-invalid':'' }}"
                            name="expired_date" id="expired-survey"
                            value="{{ date('Y-m-d', strtotime($detail_survey->expires_at)) ?? '' }}">
                        <div class="invalid-feedback">
                            {{ $errors->first('expired_date') }}
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="aktif" id="aktif"
                            {{$detail_survey->is_active == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">
                            Aktif
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block" value="Simpan">
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Pertanyaan</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <ul class="list-group">
                        @foreach($pertanyaan as $pertanyaan)
                        <li class="list-group-item mb-2 p-3">
                            <div class="row d-flex mx-2 justify-content-between">
                                <div class="">
                                    {{ $pertanyaan['pertanyaan'] }}   
                                    <br>           
                                    <form action="{{ url('survey/hapus-pertanyaan/'.$pertanyaan['id_pertanyaan']) }}" method="POST" enctype="multipart/form-data">
                                        <a href="{{ url('survey/edit-pertanyaan/'.$pertanyaan['id_pertanyaan']) }}" class="badge badge-pill badge-warning mb-2">edit</a>
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id_pertanyaan"
                                            value="{{ $pertanyaan['id_pertanyaan'] }}">
                                        <button type="submit" class="badge badge-pill badge-danger">hapus</button>
                                    </form>
                                </div>
                                <div>
                                    <div class="row d-flex justify-content-between">
                                        @if (is_array($pertanyaan['jawaban']))
                                        <ul class="list-group">
                                            @foreach ($pertanyaan['jawaban'] as $item)
                                            <li class="list-group-item">
                                                {{ $item['jawaban'] }}
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $item['persentase'] }}%"
                                                        aria-valuenow="{{ $item['persentase'] }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        {{ $item['persentase'] }}%
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <a href="{{ $pertanyaan['jawaban'] }}" class="btn btn-outline-success">
                                            Detail
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="form-group">
                    <a href="{{ url('survey/edit'.'/'.$id_survey.'/'.'tambah-pertanyaan') }}"
                        class="btn btn-primary  btn-block">Tambah Pertanyaan</a>
                </div>
            </div>
        </div>
    </div>
</x-components::layouts>