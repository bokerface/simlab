<x-components::layouts>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pertanyaan</h1>
    </div>

    <div class="mb-3">
        <div class="card">
            <div class="card-body">
                <form
                    action="{{ url('survey/edit-pertanyaan/'.$pertanyaan->survey_question_id) }}"
                    method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <div class="row mx-1">
                            <label for="pertanyaan-survey" class="col-3 my-auto">Pertanyaan</label>
                            <div class="col-9">
                                <input type="text"
                                    class="form-control
                                    {{ $errors->has('pertanyaan')?'is-invalid':'' }}"
                                    name="pertanyaan" id="pertanyaan-survey"
                                    value="{{ $pertanyaan->question ?? '' }}">
                                <div class="invalid-feedback">
                                    {{ $errors->first('pertanyaan') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row mx-1">
                            <label for="question-type" class="col-3 my-auto">
                                Jenis Pertanyaan
                            </label>
                            <div class="col-9">
                                <select
                                    class="form-control
                                    {{ $errors->has('question_type')?'is-invalid':'' }}"
                                    id="question-type" name="question_type">
                                    @foreach($daftar_jenis_pertanyaan as $jenis_pertanyaan)
                                        <option value="{{ $jenis_pertanyaan->question_type_id }}"
                                            {{ $pertanyaan->question_type_id == $jenis_pertanyaan->question_type_id ?'selected' : '' }}>
                                            {{ $jenis_pertanyaan->question_type }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ $errors->first('question_type') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row mx-1">
                            <label for="variant" class="col-3 my-auto">Variasi Jawaban :</label>
                            <div class="col-9">
                                <textarea
                                    class="form-control
                                    {{ $errors->has('jawaban')?'is-invalid':'' }}"
                                    name="jawaban" id="variant" rows="3">{{ $jawaban }}</textarea>
                                <div class="invalid-feedback">
                                    {{ $errors->first('jawaban') }}
                                </div>
                            </div>
                        </div>
                        <div class="row mx-1">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <small>pisahkan jawaban dengan "enter"</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-3"></div>
                        <div class="col-9">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="required" id="required"
                                    {{ $pertanyaan->is_required == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="required">
                                    Required
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $("#question-type").on('change', function () {
                var value = $("#question-type").val();
                if (value == 3) {
                    $("#variant").prop('disabled', true);
                } else {
                    $("#variant").prop('disabled', false);
                }
            })

        </script>
    @endpush
</x-components::layouts>
