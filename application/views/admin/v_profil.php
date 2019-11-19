<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1>User Profile</h1>
            <hr>
        </div>
    </div>
    <?php foreach ($data->result_array() as $dt) { ?>
        <div class="row">
            <label class="col-md-3">Log On</label>
            <p><?= $dt['log_on'] ?></p>
            <label class="col-md-3">Last Log In</label>
            <p><?= $dt['last_login'] ?></p>
        </div>
        <hr>
        <div class="row">
            <label class="col-md-3">NIP User</label>
            <p><?= $dt['nip_user'] ?></p>

            <label class="col-md-3">Nama Lengkap</label>
            <p><?= $dt['nama_user'] ?></p>

            <label class="col-md-3">Email User</label>
            <p style="color: #337ab7"><?= str_replace('syariahmandiri', 'bsm', $dt['email']) ?></p>

            <label class="col-md-3">Akses User</label>
            <p><?= $dt['akses_user'] ?></p>

            <label class="col-md-3">Jabatan</label>
            <p><?= $dt['jabatan'] ?></p>

            <label class="col-md-3">Nama Cabang</label>
            <p><?= $dt['nama_cabang'] ?></p>

            <?php if ($dt['jaringan'] != '') { ?>
                <label class="col-md-3">Jaringan Cabang</label>
                <ul class="col-md-6">
                    <?php $exp = explode("::", $dt['jaringan']);
                            $this->db->select('*')->from('tbl_cabang');
                            for ($i = 0; $i < count($exp); $i++) {
                                $this->db->or_where('kd_cabang', $exp[$i]);
                            }
                            $res = $this->db->get();
                            foreach ($res->result_array() as $res) {
                                echo "<li>".$res['nama_cabang']."</li>";
                            } ?>
                </ul>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php $this->load->view('layout/_footer') ?>