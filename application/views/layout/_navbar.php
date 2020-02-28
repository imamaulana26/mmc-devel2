<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <strong class="navbar-brand">Sistem Multiposting Murabahah Channeling</strong>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <?= $this->session->userdata('nama_user') ?> (<?= $this->session->userdata('akses_user') ?>) <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="<?= site_url(ucfirst('admin/user/profil')) ?>"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
            <li class="divider"></li>
            <li><a href="<?= site_url(ucfirst('login/logout')) ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <?php $akses = $this->session->userdata('akses_user');
            if($akses == 'Admin'){ ?>
                <li><a href="<?= site_url(ucfirst('admin/dashboard')) ?>"><i class="fa fa-desktop fa-fw"></i> Dashboard</a></li>
                <li><a href="#"><i class="fa fa-database fa-fw"></i> Input Data<sapn class="fa arrow"></sapn></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url(ucfirst('admin/user')) ?>"><i class="fa fa-users fa-fw"></i> Management Users</a></li>
                        <li><a href="<?= site_url(ucfirst('admin/cabang')) ?>"><i class="fa fa-building fa-fw"></i> Management Cabang</a></li>
                    </ul>
                </li>
                <li><a href="<?= site_url(ucfirst('admin/user/log')) ?>"><i class="fa fa-history fa-fw"></i> Daftar Log History</a></li>
            <?php } else if($akses == 'Maker'){ ?>
                <li><a href="<?= site_url(ucfirst('maker/dashboard')) ?>"><i class="fa fa-desktop fa-fw"></i> Dashboard</a></li>
                <li><a href="#"><i class="fa fa-list fa-fw"></i> Data Pembiayaan<sapn class="fa arrow"></sapn></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?= site_url(ucfirst('maker/koperasi')) ?>"><i class="fa fa-file-text fa-fw"></i> Data Koperasi</a></li>
                        <li><a href="<?= site_url(ucfirst('maker/input')) ?>"><i class="fa fa-file-text fa-fw"></i> Input Data Pembiayaan</a></li>
                    </ul>
                </li>
            <?php } else{
                if($this->session->userdata('akses_user') == 'Checker'){
                    echo "<li><a href='".site_url(ucfirst('checker/dashboard'))."'><i class='fa fa-desktop fa-fw'></i> Dashboard</a></li>";
                } else{
                    echo "<li><a href='".site_url(ucfirst('approval/dashboard'))."'><i class='fa fa-desktop fa-fw'></i> Dashboard</a></li>";
                } ?>
                <li><a href="<?= site_url(ucfirst('maker/koperasi')) ?>"><i class="fa fa-university fa-fw"></i> Daftar Koperasi</a></li> 
            <?php } ?>
			<li><a href="<?= site_url(ucfirst('pto')) ?>" ><i class="glyphicon glyphicon-exclamation-sign"></i> Petunjuk Penggunaan</a></li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->