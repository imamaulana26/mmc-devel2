<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Daftar List Cabang</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <?php $info = $this->session->flashdata('Info');
            $error = $this->session->flashdata('Error');
            if (!empty($info)) { ?>
                <div class="alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-fw fa-check-square-o"></i> <?= $info ?>
                </div>
            <?php } ?>

            <?php if (!empty($error)) { ?>
                <div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-fw fa-exclamation-triangle"></i> <?= $error ?>
                </div>
            <?php } ?>

            <a href="<?= site_url(ucfirst('admin/cabang/add_cabang')) ?>" class="btn btn-primary" style="margin-bottom: 10px">
                <i class="fa fa-fw fa-plus"></i> Daftar Cabang
            </a>
            <a href="<?= site_url(ucfirst('admin/cabang/print_cabang')) ?>" target="_blank" class="btn btn-primary" style="margin-bottom: 10px">
                <i class="fa fa-fw fa-file-pdf-o"></i> Export PDF
            </a>
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
                                        <a href="<?= site_url(ucfirst('admin/cabang/edit_cabang/' . $cab['kd_cabang'])) ?>" title="Ubah Data"><i class="fa fa-fw fa-edit"></i></a>
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


<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function() {
        $('#tbl_cabang').DataTable({
            "columnDefs": [{
                "targets": -1,
                "orderable": false
            }]
        });
    });
</script>