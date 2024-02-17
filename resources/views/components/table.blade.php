<div class="card">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    </div>
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    @foreach ($kolom as $kolom)
                    <th>{!! html_entity_decode($kolom) !!}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($isi as $item)
                <tr>
                    @foreach ((array)$item as $key=>$value)
                    <td>
                        {{-- {{ $value }} --}}
                        {!! html_entity_decode($value) !!}
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer"></div>
</div>