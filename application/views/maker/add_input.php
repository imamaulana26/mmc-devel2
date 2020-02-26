<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Step 1 - Form Input</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <p class="text-danger">*) Saya <b><?= $this->session->userdata('nama_user') ?></b>, dengan ini menyatakan sebenar-benarnya bahwa apa yang saya input pada Aplikasi ini sesuai dengan dokumen yang ada dan dapat dipertanggung jawabkan.</p>
            <form method="post" id="formValid" action="<?= site_url(ucfirst('maker/input/simpanData')) ?>" class="form-horizontal" autocomplete="off">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="hidden" name="kode">
                        <input type="hidden" name="method" value="add">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nomor Aplikasi</label>
                                    <div class="col-md-4">
                                        <input type="text" name="no_fos" class="form-control" value="<?= date('ymdis') ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">NIP Member Koperasi</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nip" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nomor CIF</label>
                                    <div class="col-md-4">
                                        <input type="text" name="cif" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">CIF Induk</label>
                                    <div class="col-md-4">
                                        <input type="text" name="cif_induk" id="cif_induk" class="form-control" readonly>
                                        <input type="hidden" name="uniqid" id="uniqid" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nama Nasabah</label>
                                    <div class="col-md-8">
                                        <input type="text" name="nama_nsbh" id="nama_nsbh" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nama Koperasi</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" name="nama_kop" id="nama_kop" data-live-search="true" onchange="changeValue(this.value)">
                                            <option disabled selected>-- Pilih --</option>
                                            <?php $jsArray = "var dtKop = new Array();\n";
                                            foreach ($koperasi->result() as $kop) {
                                                echo "<option value='" . $kop->nama_kop . "'>" . $kop->nama_kop . "</option>";
                                                $jsArray .= "dtKop['" . $kop->nama_kop . "'] = {uniqid:'" . addslashes($kop->uniqid) . "', cif:'" . addslashes($kop->cif_induk) . "', rek:'" . addslashes($kop->rek_agent) . "'};\n";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Rekening Nasabah</label>
                                    <div class="col-md-4">
                                        <input type="text" name="rek_nsbh" id="rek_nsbh" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Rekening Debet Angsuran
                                        <i class="fa fa-fw fa-question-circle" style="color: #337ab7" data-toggle="tooltip" title="Rek. Agent / Rek. Escrow / Rek. Nasabah"></i>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" name="rek_pokok" id="rek_pokok" class="form-control">
                                        <input type="checkbox" name="checkbox" id="checkbox" value="Y" onclick="toggleCheckbox();"><i class="text-muted"> Rekening Nasabah</i>
                                    </div>
                                    <h5><i class="text-muted"></i></h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Kode Cabang</label>
                                    <div class="col-md-8">
                                        <select name="kd_cabang" id="kd_cabang" class="form-control selectpicker" data-live-search="true">
                                            <?php foreach ($cabang as $cab) {
                                                foreach ($userCab->result() as $li) {
                                                    $select = '';
                                                    if ($cab['kd_cabang'] == $li->cabang) {
                                                        $select = 'selected';
                                                    }
                                                    echo "<option value='" . $cab['kd_cabang'] . "' " . $select . ">" . $cab['nama_cabang'] . "</option>";
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Lokasi Proyek</label>
                                    <div class="col-md-8">
                                        <select class="form-control selectpicker" name="lokasi" data-live-search="true">
                                            <option selected disabled>-- Pilih --</option>
                                            <?php foreach ($lokasi as $lok) {
                                                echo "<option value='$lok->id'>" . $lok->id . " - " . $lok->deskripsi . "</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nominal Fasilitas</label>
                                    <div class="col-md-5">
                                        <input type="text" name="nominal" id="nominal" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tenor (bulan)</label>
                                    <div class="col-md-3">
                                        <input type="text" name="tenor" id="tenor" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nomor SP3</label>
                                    <div class="col-md-5">
                                        <input type="text" name="no_sp3" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Angsuran</label>
                                    <div class="col-md-2">
                                        <input type="text" name="tgl_angsuran" id="tgl_angsuran" class="form-control" readonly>
                                    </div>
                                    <p class="text-muted">*) Tgl. angsuran sesuai tgl. jatuh tempo</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Alamat</label>
                            <div class="col-md-4">
                                <textarea name="alamat" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Pencairan (5)</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_cair" class="form-control" placeholder="yyyy-mm-dd" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Nota (1)</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_nota" id="tgl_nota" class="form-control" placeholder="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal SP3 (3)</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_sp3" id="tgl_sp3" class="form-control" placeholder="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tgl. Keputusan Komite (2)</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_komite" id="tgl_komite" class="form-control" placeholder="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Frekuensi Review</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="frek_review" class="form-control" placeholder="yyyy-mm-dd" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal PKS (4)</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_pks" id="tgl_pks" class="form-control" placeholder="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nomor PKS</label>
                                    <div class="col-md-5">
                                        <input type="text" name="no_pks" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Jatuh Tempo (6)</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_jth_tempo" id="tgl_jth_tempo" class="form-control" placeholder="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nomor Risalah</label>
                                    <div class="col-md-5">
                                        <input type="text" name="no_skkp" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Tanggal Expire</label>
                                    <div class="col-md-5">
                                        <div class="datepicker-center">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl_expire" id="tgl_expire" class="form-control" placeholder="yyyy-mm-dd" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Gaji Bulanan</label>
                                    <div class="col-md-5">
                                        <input type="text" name="gaji" id="gaji" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Gaji Tahunan</label>
                                    <div class="col-md-5">
                                        <input type="text" name="gaji_thn" id="gaji_thn" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Kode AO Pimpinan Cabang</label>
                                    <div class="col-md-5">
                                        <input type="text" name="kode_pim" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Kode AO Risk Officer</label>
                                    <div class="col-md-5">
                                        <input type="text" name="kode_fao" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Kode AO Marketing</label>
                                    <div class="col-md-5">
                                        <input type="text" name="kode_ao" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="btn-groups">
                            <a onclick="javascript:history.back()" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
                            <button type="submit" id="button" class="btn btn-primary pull-right">
                                Next <i class="glyphicon glyphicon-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('layout/_footer'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        $('.selectpicker').selectpicker('refresh');
    });

    var rek = document.getElementById('rek_pokok');
    var rek_nsbh = document.getElementById('rek_nsbh');
    var nama_nsbh = document.getElementById('nama_nsbh');

    <?php echo $jsArray; ?>

    function changeValue(nama_kop) {
        document.getElementById('cif_induk').value = dtKop[nama_kop].cif;
        document.getElementById('rek_pokok').value = dtKop[nama_kop].rek;
        document.getElementById('uniqid').value = dtKop[nama_kop].uniqid;
        $('h5').html("<i class='text-muted'>" + $('#nama_kop').val() + "</i>");
        document.getElementById("checkbox").checked = false;
        $('#formValid').bootstrapValidator('updateStatus', 'rek_pokok', 'NOT_VALIDATED');
    }

    function toggleCheckbox() {
        if (document.getElementById("checkbox").checked) {
            rek.value = rek_nsbh.value;
            $('h5').html("<i class='text-muted'>" + nama_nsbh.value + "</i>");
        } else {
            changeValue($('#nama_kop').val());
            $('h5').html("<i class='text-muted'>" + $('#nama_kop').val() + "</i>");
        }
        $('#formValid').bootstrapValidator('updateStatus', 'rek_pokok', 'NOT_VALIDATED');
    }
</script>