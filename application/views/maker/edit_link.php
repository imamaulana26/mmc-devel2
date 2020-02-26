<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Step 4 - Pendaftaran Link Jaminan</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<p class="text-danger">*) Saya <b><?= $this->session->userdata('nama_user') ?></b>, dengan ini menyatakan sebenar-benarnya bahwa apa yang saya input pada Aplikasi ini sesuai dengan dokumen yang ada dan dapat dipertanggung jawabkan.</p>

			<div class="panel panel-default">
				<?php foreach ($data->result() as $row) { ?>
					<form method="post" id="formValid" action="<?= site_url(ucfirst('maker/link/simpanData')) ?>" class="form-horizontal" autocomplete="off">
						<div class="panel-body">
							<input type="hidden" name="nip" value="<?= $row->nip_member_kop ?>">
							<input type="hidden" name="no_fos" value="<?= $row->no_fos ?>">
							<input type="hidden" name="method" value="update">

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label col-md-4">Kode Jaminan <span class="help-text"></span></label>
										<div class="col-md-4">
											<select name="kode_jaminan" class="form-control selectpicker" data-live-search="true">
												<?php foreach ($list as $key => $li) {
														$select = '';
														if ($key == 10) $select = 'selected';
														echo "<option value='" . $key . "' $select>" . $key . " - " . $li . "</option>";
													} ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label col-md-4">CIF Induk</label>
										<div class="col-md-3">
											<input type="text" class="form-control" name="cif_induk" value="<?= $row->cif_induk ?>" readonly>
										</div>
										<h5><i class="text-muted"><?= $row->nama_kop ?></i></h5>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label col-md-4">CIF Nasabah</label>
										<div class="col-md-3">
											<input type="text" class="form-control" name="cif_nsbh" value="<?= $row->cif ?>" readonly>
										</div>
										<h5><i class="text-muted"><?= $row->nama_nsbh ?></i></h5>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label col-md-4">Alokasi <span class="help-text"></span></label>
										<div class="col-md-2">
											<input type="text" name="alokasi" class="form-control" value="<?= $row->alokasi ?>" readonly>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label col-md-4">Tanggal Pencairan</label>
										<div class="col-md-4">
											<div class="datepicker-center">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-calendar"></i>
													</div>
													<input type="text" name="tgl_cair" class="form-control" placeholder="yyyy-mm-dd" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label col-md-4">Frekuensi Review</label>
										<div class="col-md-4">
											<div class="datepicker-center">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-calendar"></i>
													</div>
													<input type="text" name="frek_review" class="form-control" placeholder="yyyy-mm-dd" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="control-label col-md-4">Tanggal Jatuh Tempo</label>
										<div class="col-md-4">
											<div class="datepicker-center">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-calendar"></i>
													</div>
													<input type="text" name="tgl_jth_tempo" class="form-control" placeholder="yyyy-mm-dd" value="<?= $row->tgl_jth_tempo ?>" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<div class="btn-groups">
								<a href="<?= site_url(ucfirst('maker/anak/edit_anak/')) . $row->no_fos ?>" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
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