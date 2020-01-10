<!DOCTYPE html>
<html lang="en" style="height: 100%">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Imam Maulana Ibrahim">
    <title>Multiposting Murabahah Channeling</title>

    <link href="<?= base_url('assets/images/logo-bsm.png') ?>" rel="shortcut icon">
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/sb-admin-2.css') ?>" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
</head>

<body style="height: 100%">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title text-center"><b>Login To BSM - MMC</b></h2>
                        <p class="text-muted text-center">(BSM Multiposting Murabahah Channeling)</p>
                    </div>
                    <div class="panel-body">
                        <?php $username = $this->session->userdata('username');
                        if ($username) {
                            redirect('NotFound');
                        }
                        $msg = $this->session->flashdata('msg');
                        if (isset($msg)) { ?>
                            <div class="alert alert-danger fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="Close">&times;</a>
                                <strong><?= $msg ?></strong>
                            </div>
                        <?php } ?>
                        <form action="<?= site_url(ucfirst('login/auth')) ?>" method="post" autocomplete="off">
                            <fieldset>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input class="form-control" placeholder="Username" name="username" type="text" required autofocus>
                                    <!-- <span class="input-group-addon">@bsm.co.id</span> -->
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input class="form-control" placeholder="Password" name="password" type="password" required>
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" name="submit" class="btn btn-success btn-block">Login</button><br>
                                <p class="text-muted text-center">Copyright &copy; 2018 PT. Bank Syariah Mandiri</p>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url('assets/js/sb-admin-2.js') ?>"></script>
</body>

</html>