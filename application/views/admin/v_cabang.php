<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Management Cabang</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary" style="margin-bottom: 10px" onclick="add_region()">
                <i class="fa fa-fw fa-plus"></i> Daftar Region
            </button>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered table-hover" id="tbl_region">
                        <thead>
                            <tr>
                                <th style="width: 5px">#</th>
                                <th>Nama Region</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="show_region">
                            <?php $no = 1;
                            $get_ro = $this->db->select('*')->from('tbl_region')->order_by('nm_region', 'asc')->get()->result_array();
                            foreach ($get_ro as $ro) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $ro['nm_region'] ?></td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" onclick="edit_region('<?= $ro['kd_region'] ?>')"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="<?= site_url(ucfirst('admin/cabang/delete_region/' . $ro['kd_region'])) ?>" onclick="return confirm('Apakah anda yakin akan menghapus data <?= $ro['nm_region'] ?>?');"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <button class="btn btn-primary" style="margin-bottom: 10px" onclick="add_area()">
                <i class="fa fa-fw fa-plus"></i> Daftar Area
            </button>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered table-hover" id="tbl_area">
                        <thead>
                            <tr>
                                <th style="width: 5px">#</th>
                                <th>Kode Area</th>
                                <th>Nama Area</th>
                                <th>Region</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="show_area">
                            <?php $no = 1;
                            $get_area = $this->db->select('*')->from('tbl_area')->order_by('nm_region')->get()->result_array();
                            foreach ($get_area as $val) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $val['kd_area'] ?></td>
                                    <td><?= $val['nm_area'] ?></td>
                                    <td><?= $val['nm_region'] ?></td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" onclick="edit_area('<?= $val['kd_area'] ?>')"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="<?= site_url(ucfirst('admin/cabang/delete_area/' . $val['kd_area'])) ?>" onclick="return confirm('Apakah anda yakin akan menghapus data <?= $val['nm_area'] ?>?');"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary" style="margin-bottom: 10px" onclick="add_cabang()">
                <i class="fa fa-fw fa-plus"></i> Daftar Cabang
            </button>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered table-hover" id="tbl_cabang">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Cabang</th>
                                <th>Nama Cabang</th>
                                <th>Area</th>
                                <th>Region</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            $cabang = $this->db->get('tbl_cabang')->result_array();
                            foreach ($cabang as $cab) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= cetak($cab['kd_cabang']) ?></td>
                                    <td><?= cetak($cab['nama_cabang']) ?></td>
                                    <td><?= cetak($cab['area']) ?></td>
                                    <td><?= cetak($cab['region']) ?></td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" onclick="edit_cabang('<?= $cab['kd_cabang'] ?>')"><i class="fa fa-fw fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="delete_cabang('<?= $cab['kd_cabang'] ?>')"><i class="fa fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Modal Region -->
<div id="modal_region" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title_region"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_region" autocomplete="off">
                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Region</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="kode_region" id="kode_region">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Region</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="nama_region" id="nama_region" placeholder="Ex. RO I">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_region()">
                        <i class="fa fa-fw fa-save"></i> Save
                    </button>
                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-fw fa-remove"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal Region -->

<!-- Modal Add Area -->
<div id="modal_area" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title_area"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_area" autocomplete="off">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Region</label>
                        <div class="col-md-4">
                            <select name="nm_region" id="nm_region" class="form-control selectpicker"></select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="btn btn-default" id="add"><i class="fa fa-fw fa-plus"></i></div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Area</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="kd_area[0]" id="kd_area" onkeypress="return CheckNumeric()">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Area</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="nm_area[0]" id="nm_area">
                            <span class="help-block"></span>
                        </div>
                        </label>
                    </div>

                    <div id="clone"></div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_area()">
                        <i class="fa fa-fw fa-save"></i> Save
                    </button>
                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-fw fa-remove"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal Add Area -->

<!-- Modal Edit Area -->
<div id="modal_area_edit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title_area_edit"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_area_edit" autocomplete="off">
                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Region</label>
                        <div class="col-md-4">
                            <select name="nm_region" id="nm_region_edit" class="form-control selectpicker"></select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Area</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="kd_area" id="kd_area_edit" onkeypress="return CheckNumeric()">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Area</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="nm_area" id="nm_area_edit">
                            <span class="help-block"></span>
                        </div>
                        </label>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_area()">
                        <i class="fa fa-fw fa-save"></i> Save
                    </button>
                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-fw fa-remove"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal Edit Area -->

<!-- Modal Add Office -->
<div id="modal_office" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title_office"></h4>
            </div>
            <div class="modal-body form">
                <form class="form-horizontal" id="form_office" autocomplete="off">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Region</label>
                            <div class="col-md-4">
                                <select class="form-control selectpicker" name="region" id="region"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Area</label>
                            <div class="col-md-8">
                                <select name="area" id="area" class="form-control selectpicker" data-live-search="true">
                                    <option disabled selected>-- Please Select --</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="btn btn-default" id="add_cabang"><i class="fa fa-fw fa-plus"></i></div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Cabang</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="kd_cabang[0]" id="kd_cabang" onkeypress="return CheckNumeric()">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Cabang</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="nm_cabang[0]" id="nm_cabang">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div id="clone_cabang"></div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_office()">
                        <i class="fa fa-fw fa-save"></i> Save
                    </button>
                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-fw fa-remove"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal Add Office -->

<!-- Modal Edit Office -->
<div id="modal_office_edit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title_office_edit"></h4>
            </div>
            <div class="modal-body form">
                <form class="form-horizontal" id="form_office_edit" autocomplete="off">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Region</label>
                            <div class="col-md-4">
                                <select class="form-control selectpicker" name="region" id="region_edit"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Area</label>
                            <div class="col-md-8">
                                <select name="area" id="area_edit" class="form-control selectpicker" data-live-search="true"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Kode Cabang</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="kd_cabang" id="kd_cabang_edit" onkeypress="return CheckNumeric()">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Cabang</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="nm_cabang" id="nm_cabang_edit">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="save_office()">
                        <i class="fa fa-fw fa-save"></i> Save
                    </button>
                    <button type="reset" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-fw fa-remove"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /. Modal Edit Office -->

<?php $this->load->view('layout/_footer'); ?>