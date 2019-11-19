<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Step 6 : Pendaftaran Asset Murabahah</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<p class="text-danger">*) Saya <b><?= $this->session->userdata('nama_user') ?></b>, dengan ini menyatakan sebenar-benarnya bahwa apa yang saya input pada Aplikasi ini sesuai dengan dokumen yang ada dan dapat dipertanggung jawabkan.</p>

			<div class="panel panel-default">
				<?php foreach ($data->result() as $row) { ?>
					<form method="post" id="formValid" action="<?= site_url(ucfirst('maker/asset/simpanData')) ?>" class="form-horizontal">
						<div class="panel-body">
							<input type="hidden" name="nip" value="<?= $row->nip_member_kop ?>">
							<input type="hidden" name="no_fos" value="<?= $row->no_fos ?>">
							<input type="hidden" id="cif" value="<?= $row->cif_induk ?>">
							<input type="hidden" id="rek" value="<?= $row->rek_nsbh ?>">
							<input type="hidden" id="kop" value="<?= $row->nama_kop ?>">
							<input type="hidden" id="nama" value="<?= $row->nama_nsbh ?>">
							<input type="hidden" name="method" value="add">

							<div class="form-group">
								<label class="control-label col-md-3">Nama Asset Yang Dibiayai/Dibeli <span class="help-text"></span></label>
								<div class="col-md-4">
									<input type="text" name="nama_asset" class="form-control" value="KONS MLTGN">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Keterangan Asset Yang Dibiayai/Dibeli <span class="help-text"></span></label>
								<div class="col-md-4">
									<input type="text" name="ket_asset" class="form-control" value="KONSUMTIF MULTIGUNA">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Nomor CIF <span class="help-text"></span></label>
								<div class="col-md-2">
									<input type="text" class="form-control" value="<?= $row->cif ?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Mata Uang <span class="help-text"></span></label>
								<div class="col-md-1">
									<input type="text" class="form-control" value="<?= $row->mata_uang ?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Nomor CIF Pemasok <span class="help-text"></span></label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="cif_pemasok" id="cif_pemasok" value="<?= $row->cif_induk ?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Nama Pemasok <span class="help-text"></span></label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="nama_pemasok" id="nama_pemasok" value="<?= $row->nama_kop ?>" readonly>
								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-md-3">Rekening Pemasok / Rekening Nasabah <span class="help-text"></span></label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="rek_pemasok" id="rek_pemasok" value="<?= $row->rek_nsbh ?>" readonly>
									<input type="checkbox" name="checkbox" id="checkbox" value="Y" onclick="toggleCheckbox();"><i class="text-muted"> Rekening Pemasok</i>
								</div>
								<div class="col-md-6">
									<h5><i class="text-muted"><?= $row->nama_nsbh ?></i></h5>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Harga Asset Yang Dibiayai / Dibeli <span class="help-text"></span></label>
								<div class="col-md-3">
									<input type="text" class="form-control" value="<?= number_format($row->nom_fasilitas, 0, '.', ',') ?>" readonly>
									<input type="hidden" name="harga" id="harga" value="<?= $row->nom_fasilitas ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Uang Muka</label>
								<div class="col-md-3">
									<input type="text" name="uang_muka" id="dp" class="form-control" value="0">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Jumlah Asset Yang Dibiayai / Dibeli <span class="help-text"></span></label>
								<div class="col-md-2">
									<input type="text" name="jumlah_asset" id="jumlah" class="form-control" onkeyup="return getTotal()">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Total Asset Yang Dibiayai / Dibeli</label>
								<div class="col-md-3">
									<input type="text" name="total_asset" id="total" class="form-control" readonly>
								</div>
							</div>

						</div>
						<div class="panel-footer">
							<div class="btn-groups">
								<a href="<?= site_url(ucfirst('maker/jaminan/edit_jaminan/')) . $row->no_fos ?>" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
								<button type="submit" class="btn btn-primary pull-right">
									Next <i class="glyphicon glyphicon-chevron-right"></i>
								</button>
							</div>
						</div>
					</form>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layout/_footer'); ?>