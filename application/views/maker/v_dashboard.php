<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-md-3 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3">
                            <i class="fa fa-fw fa-bank fa-5x"></i>
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
                            <i class="fa fa-fw fa-server fa-5x"></i>
                        </div>
                        <div class="col-md-9 text-right">
                            <div class="huge"><?= $cif ?></div>
                            <div>Jumlah CIF</div>
                        </div>
                    </div>
                </div>
                <a href="<?= site_url(ucfirst('maker/dashboard')) ?>">
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
                            <i class="fa fa-fw fa-book fa-5x"></i>
                        </div>
                        <div class="col-md-9 text-right">
                            <div class="huge"><?= $get_approve->num_rows() + $get_revisi->num_rows() ?></div>
                            <div>Proses Data</div>
                        </div>
                    </div>
                </div>
                <a href="<?= site_url(ucfirst('maker/dashboard/approve')) ?>">
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
                            <div class="huge"><?= $getSukses->num_rows() + $getGagal->num_rows() ?></div>
                            <div>Hasil Pencairan</div>
                        </div>
                    </div>
                </div>
                <a href="<?= site_url(ucfirst('maker/dashboard/result')) ?>">
                    <div class=" panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php $info = $this->session->flashdata('Info');
            if (!empty($info)) { ?>
                <br>
                <div class="alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="glyphicon glyphicon-check"></i> <?= $info ?>
                </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Pembiayaan On Progress</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" id="tbl_input" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Aplikasi</th>
                                <th>Nama Cabang</th>
                                <th>Nama Koperasi</th>
                                <th>Nama Nasabah</th>
                                <th>Nomor CIF</th>
                                <th>Rek. Nasabah</th>
                                <th>Nom. Fasilitas (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($proses->result_array() as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#details<?= $row['no_fos'] ?>" title="Detail"><?= $row['no_fos'] ?></a>
                                    </td>
                                    <td><?= $row['nama_cabang'] ?></td>
                                    <td><?= $row['nama_kop'] ?></td>
                                    <td><?= $row['nama_nsbh'] ?></td>
                                    <td><?= $row['cif'] ?></td>
                                    <td><?= $row['rek_nsbh'] ?></td>
                                    <td class="text-right"><?= number_format($row['nom_fasilitas'], 0, '.', ',') ?></td>
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
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Data Pembiayaan Existing
                    </h3>
                </div>
                <div class="panel-body">
                    <table style="width: 100%" class="table table-bordered table-hover" id="tbl_eksisting">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Aplikasi</th>
                                <th>Nama Cabang</th>
                                <th>Nama Koperasi</th>
                                <th>Nama Nasabah</th>
                                <th>Nomor CIF</th>
                                <th>Rek. Nasabah</th>
                                <th>Nom. Fasilitas (Rp)</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($existing->result_array() as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#details<?= $row['no_fos'] ?>" title="Detail"><?= $row['no_fos'] ?></a>
                                    </td>
                                    <td><?= $row['nama_cabang'] ?></td>
                                    <td><?= $row['nama_kop'] ?></td>
                                    <td><?= $row['nama_nsbh'] ?></td>
                                    <td><?= $row['cif'] ?></td>
                                    <td><?= $row['rek_nsbh'] ?></td>
                                    <td class="text-right"><?= number_format($row['nom_fasilitas'], 0, '.', ',') ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url(ucfirst('maker/dashboard/print/' . $row['no_fos'])) ?>" title="Print" target="_blank">
                                            <i class="fa fa-fw fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
<?php $this->load->view('maker/v_detail'); ?>
<?php $this->load->view('approval/v_detail'); ?>
<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function() {
        $('#tbl_input, #tbl_eksisting').DataTable({
            'ordering': false,
            'scrollY': 200,
            'scrollX': true
        });
    });
</script>