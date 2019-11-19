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
                <a href="<?= site_url(ucfirst('checker/dashboard')) ?>">
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
                <a href="<?= site_url(ucfirst('checker/dashboard/approve')) ?>">
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
                <a href="<?= site_url(ucfirst('checker/dashboard/result')) ?>">
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Data Pembiayaan Approve
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" style="width: 100%" id="tbl_approve">
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
                            foreach ($get_approve->result() as $row) { ?>
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
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Data Pembiayaan Revisi
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" style="width: 100%" id="tbl_revisi">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No. MMC</th>
                                <th>CIF</th>
                                <th>Nama Nasabah</th>
                                <th>Cabang</th>
                                <th>NIP Member koperasi</th>
                                <th>CIF Induk</th>
                                <th>Nama Koperasi</th>
                                <th>Rek. Nasabah</th>
                                <th>Nominal Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($get_revisi->result() as $row) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#details<?= $row->no_fos ?>" title="Detail"><?= $row->no_fos ?></a>
                                    </td>
                                    <td><?= $row->cif ?></td>
                                    <td><?= $row->nama_nsbh ?></td>
                                    <td><?= $row->kode_cabang ?></td>
                                    <td><?= $row->nip_member_kop ?></td>
                                    <td><?= $row->cif_induk ?></td>
                                    <td><?= $row->nama_kop ?></td>
                                    <td><?= $row->rek_nsbh ?></td>
                                    <td><?= number_format($row->nom_fasilitas, 0, '.', ',') ?></td>
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
<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function(){
        $('#tbl_approve, #tbl_revisi').DataTable({
            'ordering': false,
            'scrollY': 200,
            'scrollX': true
        });
    });
</script>