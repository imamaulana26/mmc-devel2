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
            <form action="<?= site_url(ucfirst('admin/cabang/save')) ?>" method="post" class="form-horizontal" id="form-cabang" autocomplete="off">
                <input type="hidden" name="method" id="method" value="add">
                <div class="form-group">
                    <label class="control-label col-md-2">Kode Cabang</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="kd_cabang" id="kd_cabang">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Cabang</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="nama_cabang" id="nama_cabang">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Area</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="area" id="area">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Region</label>
                    <div class="col-md-3">
                        <select class="form-control selectpicker" name="region" id="region">
                            <option selected disabled>-- Please Select --</option>
                            <option value="RO I">I / Medan</option>
                            <option value="RO II">II / Palembang</option>
                            <option value="RO III">III / Jakarta</option>
                            <option value="RO IV">IV / Bandung</option>
                            <option value="RO V">V / Semarang</option>
                            <option value="RO VI">VI / Surabaya</option>
                            <option value="RO VII">VII / Banjarmasin</option>
                            <option value="RO VIII">VIII / Makassar</option>
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
        </div>
    </div>
</div>

<?php $this->load->view('layout/_footer'); ?>