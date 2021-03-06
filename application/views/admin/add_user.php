<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1>Registrasi User</h1>
            <hr>
        </div>
    </div>

    <?php $info = $this->session->flashdata('info');
    $error = $this->session->flashdata('error');
    if (!empty($info)) { ?>
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="glyphicon glyphicon-check"></i> <?= $info ?>
        </div>
    <?php } ?>
    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="glyphicon glyphicon-exclamation-sign"></i> <?= $error ?>
        </div>
    <?php } ?>

    <a href="<?= site_url(ucfirst('admin/user')) ?>" class="btn btn-primary" style="margin-bottom: 10px">
        <i class="fa fa-fw fa-chevron-left"></i> Back
    </a>

    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" action="<?= site_url(ucfirst('admin/user/simpan')) ?>" method="post" id="formValid" autocomplete="off">
                <input type="hidden" name="method" id="method" value="add">

                <div class="form-group">
                    <label class="control-label col-md-2">NIP User</label>
                    <div class="col-md-2">
                        <input type="text" name="nip_user" id="nip_user" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Lengkap</label>
                    <div class="col-md-4">
                        <input type="text" name="nama_user" id="nama_user" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Email User</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="email" id="email">
                            <span class="input-group-addon">@bsm.co.id</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Akses User</label>
                    <div class="col-md-3">
                        <select class="form-control selectpicker" name="akses" id="akses">
                            <option value="" selected disabled>-- Please Select --</option>
                            <?php $list = array('Maker', 'Checker', 'Reviewer', 'Approval');
                            foreach ($list as $li) {
                                echo "<option value='" . $li . "'>" . $li . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Jabatan</label>
                    <div class="col-md-4">
                        <select class="form-control selectpicker" name="jabatan" id="jabatan">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Cabang</label>
                    <div class="col-md-5">
                        <select class="form-control selectpicker" name="cabang" id="cabang" data-live-search="true">
                            <option value="" selected disabled>-- Please Select --</option>
                            <?php foreach ($cabang as $cab) {
                                echo "<option value='" . $cab->kd_cabang . "'>" . $cab->kd_cabang . " - " . $cab->nama_cabang . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="toggle_jaringan">
                    <label class="control-label col-md-2">Jaringan</label>
                    <div class="col-md-5">
                        <select class="form-control selectpicker" name="jaringan[]" id="jaringan" multiple data-live-search="true">
                            <?php foreach ($cabang as $cab) {
                                echo "<option value='" . $cab->kd_cabang . "'>" . $cab->kd_cabang . " - " . $cab->nama_cabang . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">&nbsp;</label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('layout/_footer'); ?>

<script>
    $(document).ready(function() {
        $('#toggle_jaringan').hide();
        $('#akses').change(function() {
            if ($(this).val() != 'Maker') {
                $('#toggle_jaringan').show();
                $.ajax({
                    url: '<?= site_url(ucfirst('admin/cabang/get_cabang')) ?>',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].kd_cabang + '">' + data[i].nama_cabang + '</option>';
                            $('#jaringan').html(html);
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            } else {
                $('#toggle_jaringan').hide();
            }

            if ($(this).val() == 'Maker') {
                arr = ['BBRM', 'Jr. BBRM'];
                get_cabang();
            } else if ($(this).val() == 'Checker') {
                arr = ['ABBM', 'AM', 'BM'];
                get_cabang();
            } else if ($(this).val() == 'Reviewer') {
                arr = ['FO Staff', 'BFO Staff', 'CV Staff', 'FCLA', 'FO Supervisor', 'LPDC Officer', 'LPDC Sign Officer', 'LPDC Staff', 'LPDC Supervisor'];
                get_cabang_fog();
            } else {
                arr = ['FO Supervisor', 'AFO Manager', 'BFO Supervisor', 'CV Officer', 'LPDC Manager'];
                get_cabang_rfo();
            }

            var html = '<option selected disabled>-- Please Select --</option>';
            for (var i = 0; i < arr.length; i++) {
                html += '<option value="' + arr[i] + '">' + arr[i] + '</option>';
            }
            $('#jabatan').html(html);
            $('.selectpicker').selectpicker('refresh');
        });
    });

    function get_cabang() {
        $.ajax({
            url: '<?= site_url(ucfirst('admin/cabang/get_cabang')) ?>',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                var html = '<option selected disabled>-- Please Select --</option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].kd_cabang + '">' + data[i].nama_cabang + '</option>';
                    $('#cabang').html(html);
                }
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
    
    function get_cabang_fog() {
        $.ajax({
            url: '<?= site_url(ucfirst('admin/cabang/get_cabang_fog')) ?>',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                var html = '<option selected disabled>-- Please Select --</option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].kd_cabang + '">' + data[i].nama_cabang + '</option>';
                    $('#cabang').html(html);
                }
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
    
    function get_cabang_rfo() {
        $.ajax({
            url: '<?= site_url(ucfirst('admin/cabang/get_cabang_rfo')) ?>',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                var html = '<option selected disabled>-- Please Select --</option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].kd_cabang + '">' + data[i].nama_cabang + '</option>';
                    $('#cabang').html(html);
                }
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
</script>