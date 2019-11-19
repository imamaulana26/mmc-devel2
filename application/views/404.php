<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Imam Maulana Ibrahim">

    <title>CI - Multiposting Murabahah Chaneling</title>

	<link href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

	<style type="text/css">
		body{ padding-top: 70px; }
		.jumbotron{ height: 500px; }
		h1, p{ padding-top: 50px; }
	</style>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="text-center">404 Not Found</h1>
			<p class="text-center">The page you requested was not found.</p>
			<p class="text-center">
				<button class="btn btn-primary" onclick="goBack()">
					<i class="glyphicon glyphicon-chevron-left"></i> Back
				</button>
			</p>
		</div>
	</div>

	<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.go(-1);
		}
	</script>
</body>
</html>