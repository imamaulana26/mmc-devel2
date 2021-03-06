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

    <div class="row">
        <div class="col-md-12">
            <?php $info = $this->session->flashdata('Info');
            $error = $this->session->flashdata('Error');
            if (!empty($info)) { ?>
                <br>
                <div class="alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="glyphicon glyphicon-check"></i> <?= $info ?>
                </div>
            <?php } ?>
            <?php if (!empty($error)) { ?>
                <br>
                <div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-fw fa-exclamation-triangle"></i> <?= $error ?>
                </div>
            <?php } ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Data Pembiayaan On Progress
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" id="tbl_proses" style="width: 100%">
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
                                <?php if ($this->session->userdata('akses_user') != 'Approval') { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($get_proses->result() as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#detail<?= $row->no_fos ?>" title="Detail"><?= $row->no_fos ?></a>
                                    </td>
                                    <td><?= $row->nama_cabang ?></td>
                                    <td><?= $row->nama_kop ?></td>
                                    <td><?= $row->nama_nsbh ?></td>
                                    <td><?= $row->cif ?></td>
                                    <td><?= $row->rek_nsbh ?></td>
                                    <td class="text-right"><?= number_format($row->nom_fasilitas, 0, '.', ',') ?></td>
                                    <?php if ($this->session->userdata('akses_user') != 'Approval') { ?>
                                        <td class="text-center">
                                            <a href="<?= site_url(ucfirst('maker/input/edit_input/')) . $row->no_fos ?>"><i class="glyphicon glyphicon-edit"></i></a>
                                        </td>
                                    <?php } ?>
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
                <div class="panel-heading" style="cursor: pointer">
                    <h3 class="panel-title">
                        History Data Entry
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" style="width: 100%" id="tbl_existing">
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
                                <?php if ($this->session->userdata('akses_user') == 'Approval') { ?>
                                    <th class="text-center">Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($get_existing->result() as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#details<?= $row->no_fos ?>" title="Detail"><?= $row->no_fos ?></a>
                                    </td>
                                    <td><?= $row->nama_cabang ?></td>
                                    <td><?= $row->nama_kop ?></td>
                                    <td><?= $row->nama_nsbh ?></td>
                                    <td><?= $row->cif ?></td>
                                    <td><?= $row->rek_nsbh ?></td>
                                    <td class="text-right"><?= number_format($row->nom_fasilitas, 0, '.', ',') ?></td>
                                    <?php if ($this->session->userdata('akses_user') == 'Approval') { ?>
                                        <td class="text-center">
                                            <?php if ($row->nip_approval != '') { ?>
                                                <a href="<?= site_url(ucfirst('approval/dashboard/print/' . $row->no_fos)) ?>" title="Print" target="_blank">
                                                    <i class="fa fa-fw fa-print"></i>
                                                </a>
                                            <?php } else { ?>
                                                <i class="fa fa-fw fa-minus"></i>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
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
</div>
<!-- /#page-wrapper -->

<?php $this->load->view('approval/v_detail'); ?>
<?php $this->load->view('maker/v_detail'); ?>
<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function() {
        $('#tbl_proses, #tbl_existing, #tbl_gagal').DataTable({
            'ordering': false,
            'scrollY': 200,
            'scrollX': true
        });
    });
</script>