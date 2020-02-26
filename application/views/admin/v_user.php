<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Data Users</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <?php $info = $this->session->flashdata('info');
            if (!empty($info)) { ?>
                <br>
                <div class="alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="glyphicon glyphicon-check"></i> <?= $info ?>
                </div>
            <?php } ?>

            <a href="<?= site_url(ucfirst('admin/user/add_user')) ?>" class="btn btn-primary" style="margin-bottom: 10px">
                <i class="fa fa-fw fa-plus"></i> Daftar User
            </a>

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered table-hover" id="tbl_user">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Akses User</th>
                                <th>No Employe</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan</th>
                                <th>Nama Cabang</th>
                                <th>Region</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($list as $li) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-center">
                                        <?php if($li->enable == '0'){
                                            echo "<input type='checkbox' class='form-check-input' data-nip='".$li->nip_user."' checked='checked'>";
                                        } else {
                                            echo "<input type='checkbox' class='form-check-input' data-nip='".$li->nip_user."'>";
                                        } ?>
                                    </td>
                                    <td><?php if ($li->akses_user != 'Maker') { ?>
                                            <p style="color: #337ab7; cursor: pointer; text-decoration: underline" data-user="<?= $li->nip_user ?>" id="lv_user">
                                                <?= cetak($li->akses_user) ?>
                                            </p>
                                        <?php } else {
                                                cetak($li->akses_user);
                                            } ?></td>
                                    <td><?= cetak($li->nip_user) ?></td>
                                    <td><?= cetak($li->nama_user) ?><br>
                                        <p style="color: #337ab7"><?= cetak(str_replace('syariahmandiri', 'bsm', $li->email)) ?></p>
                                    </td>
                                    <td><?= cetak($li->jabatan) ?></td>
                                    <td><?= cetak($li->nama_cabang) ?></td>
                                    <td><?= cetak($li->region) ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url(ucfirst('admin/user/edit_user/')) . $li->nip_user ?>">
                                            <i class="glyphicon glyphicon-edit" title="Edit"></i>
                                        </a>
                                        <!-- <a href="<?= site_url(ucfirst('admin/user/delete_user/')) . $li->id ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="glyphicon glyphicon-trash" title="Delete"></i></a> -->
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal_user">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Jaringan User</h4>
            </div>
            <div class="modal-body">
                <ul id="show"></ul>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function() {
        $('#tbl_user').DataTable({
            "columnDefs": [{
                "targets": -1,
                "orderable": false
            }]
        });
    });

    $('p#lv_user').click(function() {
        $('#modal_user').modal('show');

        const user = $(this).data('user');

        $.ajax({
            url: "<?= site_url(ucfirst('admin/user/v_jaringan')) ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                user: user
            },
            success: function(data) {
                var html = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        html += '<li>' + data[i].nama_cabang + '</li>';
                    }
                } else {
                    html += '<li>Data tidak tersedia!</li>';
                }
                $('#show').html(html);
            }
        });
    });
</script>