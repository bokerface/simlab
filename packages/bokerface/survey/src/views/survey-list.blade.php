<x-components::layouts>
    <div class="mb-3">
        <div class="d-sm-flex align-items-center  mb-4">
            <h1 class="h3 mb-0 text-gray-800 mr-3">Daftar Survey</h1>
            <a href="{{ url('survey/tambah') }}" class="btn btn-sm btn-primary">tambah survey</a>
        </div>

        <div class="list-group">
            @foreach($daftar_survey as $survey)
                <a href="{{ url('survey/edit'.'/'.$survey->id_survey) }}"
                    class="list-group-item list-group-item-action mb-3" aria-current="true">
                    {{ $survey->survey_name }}
                    <br>
                    <small>{{ $survey->survey_description }}</small>
                </a>
            @endforeach
        </div>
    </div>
</x-components::layouts>
