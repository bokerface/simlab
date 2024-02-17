<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Honor @{{ modal_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/simpan_laporan_pembayaran') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id_pegawai" value="{{ $rekening['id_pegawai'] ?? "" }}">
                    <input type="hidden" name="id_praktikum" v-model="id_praktikum">
                    <input type="hidden" name="tahun_ajaran" v-model="tahun_ajaran">
                    <input type="hidden" name="semester" v-model="semester">
                    <input type="hidden" name="type" v-model="type">
                    <div class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0">Metode</legend>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="custom-control custom-radio col-6">
                                        <input type="radio" id="customRadio1" name="metode" class="custom-control-input"
                                            value="transfer" v-model="metode">
                                        <label class="custom-control-label" for="customRadio1">Transfer</label>
                                    </div>
                                    <div class="custom-control custom-radio col-6">
                                        <input type="radio" id="customRadio2" name="metode" class="custom-control-input"
                                            value="tunai" v-model="metode">
                                        <label class="custom-control-label" for="customRadio2">Tunai</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="nominal" placeholder="jumlah nominal"
                                name="nominal" v-model="nominal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="exampleFormControlTextarea1" disabled rows="2">{{
                                $rekening['no_rek'] ?? '' }} {{ $rekening['nama_rekening'] ?? '' }} {{ $rekening['bank']
                                ?? '' }} {{ $rekening['cabang'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_pembayaran" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="tanggal_pembayaran"
                                placeholder="tanggal pembayaran" name="tanggal" v-model="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bukti" class="col-sm-3 col-form-label">Bukti Pembayaran</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3" v-if="file_name ==='' ">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02"
                                        name="file_bukti">
                                    <label class="custom-file-label" for="inputGroupFile02">file bukti
                                        pembayaran
                                    </label>
                                </div>
                            </div>
                            <span v-else><a :href="file_name">bukti pembayaran</a></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="!sudah_dibayar">
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>