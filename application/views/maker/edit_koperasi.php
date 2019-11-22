<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Pendaftaran Koperasi</h1>
		</div>
	</div>

	<p class="text-danger">*) Saya <b><?= $this->session->userdata('nama_user') ?></b>, dengan ini menyatakan sebenar-benarnya bahwa apa yang saya input pada Aplikasi ini sesuai dengan dokumen yang ada dan dapat dipertanggung jawabkan.</p>

	<form class="form-horizontal" method="post" id="formValid" action="<?= site_url(ucfirst('maker/koperasi/simpan')) ?>" autocomplete="off">

		<?php foreach ($data->result() as $dt) { ?>
			<div class="panel panel-default">
				<div class="panel-body">
					<input type="hidden" name="method" value="update">

					<?php if ($this->session->userdata('akses_user') == 'Reviewer') { ?>
						<div class="form-group">
							<label class="control-label col-md-2">Kode Koperasi</label>
							<div class="col-md-3">
								<input type="text" class="form-control" name="id_fasilitas" value="<?= $dt->id_fasilitas ?>">
							</div>
						</div>
					<?php } ?>

					<div class="form-group">
						<label class="control-label col-md-2">CIF Induk</label>
						<div class="col-md-2">
							<input type="text" class="form-control" name="cif_induk" value="<?= $dt->cif_induk ?>" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">NPWP</label>
						<div class="col-md-3">
							<input type="text" class="form-control" name="npwp" value="<?= $dt->npwp ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Nama Koperasi</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama_kop" value="<?= $dt->nama_kop ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Rekening Agent</label>
						<div class="col-md-2">
							<input type="text" class="form-control" name="rek_agent" value="<?= $dt->rek_agent ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Rekening Agent</label>
						<div class="col-md-2">
							<input type="text" class="form-control" name="rek_escrow" value="<?= $dt->rek_escrow ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Mata Uang</label>
						<div class="col-md-1">
							<input type="text" class="form-control" name="mata_uang" value="IDR" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Nominal Awal</label>
						<div class="col-md-3">
							<input type="text" class="form-control" value="<?= number_format($dt->nominal, 0, '.', ',') ?>" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Nominal Tersedia</label>
						<div class="col-md-3">
							<input type="text" class="form-control" name="nominal" id="nominal" value="<?= number_format($dt->sisa_nom, 0, '.', ',') ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Tenor Bank <a href="#" class="btn-add-1">+</a></label>
						<div class="col-md-2 multiple-form-group-1">
							<?php $exp = explode("::", $dt->tenor_bank);
								$jmlh = count($exp);
								if ($exp[0]) { ?>
								<div style="margin-bottom: 10px">
									<input type="text" name="tenor_bank[]" class="form-control" value="<?= $exp[0] ?>" placeholder="Ex. 12">
								</div>
							<?php }
								for ($i = 1; $i < $jmlh; $i++) { ?>
								<div class="input-group" style="margin-bottom: 10px">
									<input type="text" name="tenor_bank[]" value="<?= $exp[$i] ?>" class="form-control" placeholder="Ex. 12">
									<div class="input-group-addon btn btn-remove btn-danger">-</div>
								</div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">Rate Bank <a href="#" class="btn-add-2">+</a></label>
						<div class="col-md-2 multiple-form-group-2">
							<?php $exp = explode("::", $dt->rate_bank);
								$jmlh = count($exp);
								if ($exp[0]) { ?>
								<div style="margin-bottom: 10px">
									<input type="text" name="rate_bank[]" class="form-control" value="<?= $exp[0] ?>" placeholder="Ex. 15.00">
								</div>
							<?php }
								for ($i = 1; $i < $jmlh; $i++) { ?>
								<div class="input-group" style="margin-bottom: 10px">
									<input type="text" name="rate_bank[]" class="form-control" value="<?= $exp[$i] ?>" placeholder="Ex. 15.00">
									<div class="input-group-addon btn btn-remove btn-danger">-</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="btn-groups">
						<a href="<?= site_url(ucfirst('maker/koperasi')) ?>" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
						<button type="submit" class="btn btn-primary pull-right">
							Simpan <i class="glyphicon glyphicon-check"></i>
						</button>
					</div>
				</div>
			</div>
		<?php } ?>
	</form>
</div>

<?php $this->load->view('layout/_footer'); ?>