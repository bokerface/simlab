<div class="tab-pane fade show active" id="pills-pembicara-{{ $noPembicara }}" role="tabpanel"
    aria-labelledby="pills-pembicara-{{ $noPembicara }}-tab">
    @isset($data->id)
    <input type="hidden" name="id_pembicara_{{ $noPembicara }}" value="{{ $data->id ?? '' }}">
    @endisset
    <div class="form-group">
        <label for="nama_pembicara_{{ $noPembicara }}">Nama</label>
        <input type="text" class="form-control {{ $errors->has('nama_pembicara_'.$noPembicara)?'is-invalid':'' }}"
            id="nama_pembicara_{{ $noPembicara }}" name="nama_pembicara_{{ $noPembicara }}" placeholder="Nama Pembicara"
            value="{{ old('nama_pembicara_'.$noPembicara) ?? ($data->nama ?? '') }}">
        <div class="invalid-feedback">
            {{ $errors->first('nama_pembicara_'.$noPembicara) }}
        </div>
    </div>
    <div class="form-group">
        <label for="jabatan_pembicara_{{ $noPembicara }}">Jabatan</label>
        <input type="text" class="form-control {{ $errors->has('jabatan_pembicara_'.$noPembicara)?'is-invalid':'' }}"
            id="jabatan_pembicara_{{ $noPembicara }}" name="jabatan_pembicara_{{ $noPembicara }}"
            placeholder="Jabatan Pembicara"
            value="{{ old('jabatan_pembicara_'.$noPembicara) ?? ($data->jabatan ?? '') }}">
        <div class="invalid-feedback">
            {{ $errors->first('jabatan_pembicara_'.$noPembicara) }}
        </div>
    </div>
    <div class="form-group">
        <label for="instansi_pembicara_{{ $noPembicara }}">Instansi</label>
        <input type="text" class="form-control {{ $errors->has('instansi_pembicara_'.$noPembicara)?'is-invalid':'' }}"
            id="instansi_pembicara_{{ $noPembicara }}" name="instansi_pembicara_{{ $noPembicara }}"
            placeholder="Instansi Pembicara"
            value="{{ old('instansi_pembicara_'.$noPembicara) ?? ($data->instansi ?? '') }}">
        <div class="invalid-feedback">
            {{ $errors->first('instansi_pembicara_'.$noPembicara) }}
        </div>
    </div>
    <div class="form-group">
        <label for="foto_pembicara_{{ $noPembicara }}">
            @if (isset($data->foto))
            <a href="{{ url('foto-pembicara/'.$data->foto) }}">Foto</a>
            @else
            Foto
            @endif
        </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="foto_pembicara_{{ $noPembicara }}"
                name="foto_pembicara_{{ $noPembicara }}">
            <label class="custom-file-label" for="customFile">Pilih Foto</label>
        </div>
    </div>
</div>