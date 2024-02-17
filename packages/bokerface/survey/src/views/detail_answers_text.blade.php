<x-components::layouts>
    <div class="mb-3">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Survey Pertanyaan {{ $judul_pertanyaan }}</h1>
        </div>

        <div class="card">

            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>Jawaban Survey</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jawaban as $jawaban)
                        <tr>
                            <td>{{ $jawaban->question_item_other }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>

    </div>
</x-components::layouts>