<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1>Tambah Daftar Cabang</h1>
            <hr>
        </div>
    </div>

    <div style="margin-bottom: 10px">
        <a href="<?= site_url(ucfirst('admin/cabang')) ?>" class="btn btn-primary"><i class="fa fa-fw fa-chevron-left"></i> Back</a>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php foreach ($data->result_array() as $dt) { ?>
                <form action="<?= site_url(ucfirst('admin/cabang/save')) ?>" method="post" class="form-horizontal" id="form-cabang" autocomplete="off">
                    <input type="hidden" name="id" id="id" value="<?= $dt['id'] ?>">
                    <input type="hidden" name="method" id="method" value="update">

                    <div class="form-group">
                        <label class="control-label col-md-2">Kode Cabang</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="kd_cabang" id="kd_cabang" value="<?= substr($dt['kd_cabang'], 2) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Nama Cabang</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="nama_cabang" id="nama_cabang" value="<?= $dt['nama_cabang'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Nama Area</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="area" id="area" value="<?= $dt['area'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Region</label>
                        <div class="col-md-3">
                            <select class="form-control selectpicker" name="region" id="region">
                                <option selected disabled>-- Please Select --</option>
                                <?php $list = array('RO I' => 'I / Medan', 'RO II' => 'II / Palembang', 'RO III' => 'III / Jakarta', 'RO IV' => 'IV / Bandung',
                                'RO V' => 'V / Semarang', 'RO VI' => 'VI / Surabaya', 'RO VII' => 'VII / Banjarmasin', 'RO VIII' => 'VIII / Makasar');
                                foreach($list as $key => $val){
                                    $select = '';
                                    if($key == $dt['region']) $select = 'selected';
                                    echo "<option value='".$key."' $select>" . $key . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">&nbsp;</label>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>

<?php $this->load->view('layout/_footer'); ?>