<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Data Koperasi</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<?php $akses = $this->session->userdata('akses_user');
			$info = $this->session->flashdata('Info');
			$error = $this->session->flashdata('Error');
			if (!empty($info)) { ?>
				<br>
				<div class="alert alert-success fade in">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<i class="fa fa-fw fa-check-square-o"></i> <?= $info ?>
				</div>
			<?php } ?>

			<?php if (!empty($error)) { ?>
				<br>
				<div class="alert alert-warning fade in">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<i class="fa fa-fw fa-exclamation-triangle"></i> <?= $error ?>
				</div>
			<?php } ?>

			<?php if ($this->session->userdata('akses_user') == 'Maker') { ?>
				<a href="<?= site_url(ucfirst('maker/koperasi/add_koperasi')) ?>" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Data Koperasi</a>
				<br><br>
			<?php } ?>
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-bordered table-hover" id="tbl_kop">
						<thead>
							<tr>
								<th>#</th>
								<th>CIF Induk</th>
								<th>Nama Koperasi</th>
								<th>Nama Cabang</th>
								<th>Rek. Agent</th>
								<th>Rek. Escrow</th>
								<th>Nominal Awal (Rp)</th>
								<th>Nom. Tersedia (Rp)</th>
								<th>Tenor Bank</th>
								<th>Rate Agent</th>
								<th>Kode Koperasi</th>
								<?php if ($akses != 'Checker') {
									echo "<th>Aksi</th>";
								} ?>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1;
							foreach ($data->result() as $dt) { ?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $dt->cif_induk ?></td>
									<td><?= $dt->nama_kop ?></td>
									<td><?= $dt->nama_cabang ?></td>
									<td><?= $dt->rek_agent ?></td>
									<td><?= $dt->rek_escrow ?></td>
									<td class="text-right"><?= number_format($dt->nominal, 0, '.', ',') ?></td>
									<td class="text-right"><?= number_format($dt->sisa_nom, 0, '.', ',') ?></td>
									<td><?php
											$exp = explode("::", $dt->tenor_bank);
											for ($i = 0; $i < count($exp); $i++) {
												echo $exp[$i] . " Bulan<br>";
											}
											?></td>
									<td><?php
											$exp = explode("::", $dt->rate_bank);
											for ($i = 0; $i < count($exp); $i++) {
												echo $exp[$i] . " %<br>";
											}
											?></td>
									<td><?= $dt->id_fasilitas ?></td>
									<?php if ($akses == 'Maker' || $akses == 'Reviewer') { ?>
										<td class="text-center">
											<a href="<?= site_url(ucfirst('maker/koperasi/edit_koperasi/')) . $dt->cif_induk ?>">
												<i class="glyphicon glyphicon-edit" title="Ubah Data"></i>
											</a>
										</td>
									<?php } ?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layout/_footer'); ?>

<script>
	$(document).ready(function() {
		$('#tbl_kop').DataTable({
			'ordering': false,
			'scrollY': 200,
			'scrollX': true
		});
	});
</script>