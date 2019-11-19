<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="fa fa-bank fa-fw fa-5x"></i>
                        </div>
                        <div class="col-md-9 text-right">
                            <div class="huge"><?= $kop ?></div>
                            <div>Jumlah Koperasi</div>
                        </div>
                    </div>
                </div>
                <a href="<?= site_url(ucfirst('maker/koperasi')) ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="fa fa-server fa-fw fa-5x"></i>
                        </div>
                        <div class="col-md-9 text-right">
                            <div class="huge"><?= $cif ?></div>
                            <div>Jumlah CIF</div>
                        </div>
                    </div>
                </div>
                <a href="<?= site_url(ucfirst('approval/dashboard')) ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="fa fa-fw fa-check-square-o fa-5x"></i>
                        </div>
                        <div class="col-md-9 text-right">
                            <div class="huge"><?= $proses_cair->num_rows() ?></div>
                            <div>Proses Pencairan</div>
                        </div>
                    </div>
                </div>
                <a href="<?= site_url(ucfirst('approval/dashboard/approve')) ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="fa fa-fw fa-file-text fa-5x"></i>
                        </div>
                        <div class="col-md-9 text-right">
                            <div class="huge"><?= $getGagal->num_rows() + $getSukses->num_rows() ?></div>
                            <div>Hasil Pencairan</div>
                        </div>
                    </div>
                </div>
                <a href="<?= site_url(ucfirst('approval/dashboard/result')) ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Table Info Hasil Pencairan -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="cursor: pointer">
                    <h3 class="panel-title">
                        Data Hasil Pencairan Berhasil
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" style="width: 100%" id="tbl_sukses">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Aplikasi</th>
                                <th>Nama Cabang</th>
                                <th>Nama Koperasi</th>
                                <th>Nama Nasabah</th>
                                <th>NOLOAN</th>
                                <th>Waktu Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getSukses->result() as $dt) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#details<?= $dt->no_fos ?>" title="Detail"><?= $dt->no_fos ?></a>
                                    </td>
                                    <td><?= $dt->nama_cabang ?></td>
                                    <td><?= $dt->nama_kop ?></td>
                                    <td><?= $dt->nama_nsbh ?></td>
                                    <td><?= $dt->no_loan ?></td>
                                    <td><?= $dt->time_upload ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="cursor: pointer">
                    <h3 class="panel-title">
                        Data Hasil Pencairan Gagal
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" style="width: 100%" id="tbl_gagal">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Aplikasi</th>
                                <th>Nama Cabang</th>
                                <th>Nama Koperasi</th>
                                <th>Nama Nasabah</th>
                                <th>File Proses</th>
                                <th>Waktu Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($getGagal->result() as $dt) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if ($dt->status == 'Gagal') { ?>
                                            <a href="" data-toggle="modal" data-target="#detail<?= $dt->no_fos ?>" title="Detail"><?= $dt->no_fos ?></a>
                                        <?php } else { ?>
                                            <a href="" data-toggle="modal" data-target="#details<?= $dt->no_fos ?>" title="Detail"><?= $dt->no_fos ?></a>
                                        <?php } ?>
                                    </td>
                                    <td><?= $dt->nama_cabang ?></td>
                                    <td><?= $dt->nama_kop ?></td>
                                    <td><?= $dt->nama_nsbh ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#log<?= $dt->no_fos ?>" title="Log Error"><?= $dt->file_name ?></a>
                                    </td>
                                    <td><?= $dt->time_upload ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Table Info Hasil Pencairan -->
</div>

<?php $this->load->view('approval/v_detail'); ?>
<?php $this->load->view('maker/v_detail'); ?>
<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function() {
        $('#tbl_sukses, #tbl_gagal').DataTable({
            'ordering': false,
            'scrollY': 200,
            'scrollX': true
        });
    });
</script>