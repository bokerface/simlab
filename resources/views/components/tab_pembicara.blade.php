<div class="tab-pane fade show active" id="pills-pembicara-{{ $noPembicara }}" role="tabpanel"
    aria-labelledby="pills-pembicara-{{ $noPembicara }}-tab">
    <div class="form-group">
        <label for="nama_pembicara_{{ $noPembicara }}">Nama</label>
        <input type="text" class="form-control" id="nama_pembicara_{{ $noPembicara }}"
            name="nama_pembicara_{{ $noPembicara }}" placeholder="Nama Pembicara">
    </div>
    <div class="form-group">
        <label for="jabatan_pembicara_{{ $noPembicara }}">Jabatan</label>
        <input type="text" class="form-control" id="jabatan_pembicara_{{ $noPembicara }}"
            name="jabatan_pembicara_{{ $noPembicara }}" placeholder="Jabatan Pembicara">
    </div>
    <div class="form-group">
        <label for="instansi_pembicara_{{ $noPembicara }}">Instansi</label>
        <input type="text" class="form-control" id="instansi_pembicara_{{ $noPembicara }}"
            name="instansi_pembicara_{{ $noPembicara }}" placeholder="Instansi Pembicara">
    </div>
    <div class="form-group">
        <label for="foto_pembicara_{{ $noPembicara }}">Foto</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="foto_pembicara_{{ $noPembicara }}"
                name="foto_pembicara_{{ $noPembicara }}">
            <label class="custom-file-label" for="customFile">Pilih Foto</label>
        </div>
    </div>
</div>