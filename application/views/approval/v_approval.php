<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <?php $proses = $this->session->flashdata('Proses');
        $email = $this->session->flashdata('Email');
        if (!empty($proses)) { ?>
            <br>
            <div class="alert alert-success fade in">
                <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
                <i class="fa fa-fw fa-spin fa-refresh"></i> <?= $proses ?>
            </div>
        <?php }
        if (!empty($email)) { ?>
            <br>
            <div class="alert alert-success fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-fw fa-envelope"></i> <?= $email ?>
            </div>
        <?php } ?>

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
            if (!empty($info)) { ?>
                <br>
                <div class="alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="glyphicon glyphicon-check"></i> <?= $info ?>
                </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading" style="cursor: pointer">
                    <h3 class="panel-title">
                        Data Proses Pembiayaan
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" style="width: 100%" id="tbl_proses">
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
                            foreach ($proses_cair->result() as $row) { ?>
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
                                    <td class="text-center">
                                        <?php $level = $this->session->userdata('akses_user');
                                            if ($level == 'Reviewer') {
                                                echo "<a href='' data-toggle='modal' data-target='#modal-form$row->no_fos'><i class='fa fa-fw fa-calendar'></i></a>";
                                            } else {
                                                echo "<a href='" . site_url(ucfirst('approval/dashboard/send_ftp/')) . $row->no_fos . "' id='upload'><i class='glyphicon glyphicon-share' title='Send to ftp'></i></a>";
                                            } ?>
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

<?php $this->load->view('approval/v_detail'); ?>
<?php $this->load->view('maker/v_detail'); ?>
<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function() {
        $('#tbl_proses').DataTable({
            'ordering': false,
            'scrollY': 200,
            'scrollX': true
        });
    });
</script>