<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Step 2 - Fasilitas Induk</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<p class="text-danger">*) Saya <b><?= $this->session->userdata('nama_user') ?></b>, dengan ini menyatakan sebenar-benarnya bahwa apa yang saya input pada Aplikasi ini sesuai dengan dokumen yang ada dan dapat dipertanggung jawabkan.</p>
			
			<div class="panel panel-default">
				<?php foreach ($data->result() as $row) { ?>
					<form method="post" id="formValid" action="<?= site_url(ucfirst('maker/induk/simpanData')) ?>" class="form-horizontal">
						<div class="panel-body">
							<input type="hidden" name="no_fos" value="<?= $row->no_fos ?>">
							<input type="hidden" name="nip" value="<?= $row->nip_member_kop ?>">
							<input type="hidden" name="method" value="add">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Nama Nasabah</label>
										<div class="col-md-8">
											<input type="text" class="form-control" value="<?= $row->nama_nsbh ?>" readonly>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Mata Uang <span class="help-text"></span></label>
										<div class="col-md-3">
											<input type="text" name="uang" class="form-control" value="IDR">
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Tanggal Nota</label>
										<div class="col-md-5">
											<div class="datepicker-center">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-calendar"></i>
													</div>
													<input type="text" class="form-control" placeholder="yyyy-mm-dd" value="<?= $row->tgl_nota ?>" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Maksimal Penggunaan</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="maks_guna" id="maks_guna" value="<?= number_format($row->sisa_nom, 0, '.', ',') ?>" readonly>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Tanggal SP3</label>
										<div class="col-md-5">
											<div class="datepicker-center">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-calendar"></i>
													</div>
													<input type="text" name="tgl_cair" class="form-control" placeholder="yyyy-mm-dd" value="<?= $row->tgl_sp3 ?>" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Nominal Fasilitas</label>
										<div class="col-md-6">
											<input type="text" class="form-control" value="<?= number_format($row->nom_fasilitas, 0, '.', ',') ?>" readonly>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Tanggal Pencairan</label>
										<div class="col-md-5">
											<div class="datepicker-center">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-calendar"></i>
													</div>
													<input type="text" name="tgl_cair" class="form-control" placeholder="yyyy-mm-dd" value="<?= $row->tgl_cair == '0000-00-00' ? '' : $row->tgl_cair ?>" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Segmentasi Kriteria </label>
										<div class="col-md-8">
											<select name="segmen" class="form-control selectpicker">
												<?php $list = array('BPR/BPRS', 'Lembaga keuangan mikro (KJKS, BMT)', 'Koperasi utk tujuan konsumer', 'Koperasi utk tujuan produktif', 'Multifinance dgn pola chanelling', 'Pembiayaan program', 'Pembiayaan dgn pola kemitraan', 'BUMD & anak perusahaan', 'BUMN & anak perusahaan', 'Lembaga pendidikan', 'Lembaga negara non-kementrian', 'Rumah sakit/klinik', 'Pembiayaan konsumer', 'Pembiayaan produktif dgn GAS tertentu', 'Badan usaha');
													foreach ($list as $key => $li) {
														if (($key + 1) == 13) {
															echo "<option data-tokens='" . ($key + 1) . "' selected>" . ($key + 1) . " - " . $li . "</option>";
														} else {
															echo "<option data-tokens='" . ($key + 1) . "' disabled>" . ($key + 1) . " - " . $li . "</option>";
														}
													} ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 col-md-offset-6">
									<div class="form-group">
										<label class="control-label col-md-4">Rating Internal <span class="help-text"></span></label>
										<div class="col-md-3">
											<select name="rating_int" class="form-control selectpicker">
												<?php $list = array('NO', 'A', 'AA', 'AAA', 'BBB');
													foreach ($list as $li) {
														if ($li == 'NO') {
															echo "<option data-tokens='$li' selected>" . $li . "</option>";
														} else {
															echo "<option data-tokens='$li' disabled>" . $li . " - Rating " . $li . "</option>";
														}
													} ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Tanggal Jatuh Tempo</label>
										<div class="col-md-5">
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
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Rating Eksternal </label>
										<div class="col-md-5">
											<input type="text" name="rating_eks" class="form-control" value="169 - Tidak ada rating" readonly>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Frekuensi Review</label>
										<div class="col-md-5">
											<div class="datepicker-center">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="glyphicon glyphicon-calendar"></i>
													</div>
													<input type="text" class="form-control" placeholder="yyyy-mm-dd" readonly>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Status Pernikahan <span class="help-text"></span></label>
										<div class="col-md-5">
											<select name="sts_nikah" id="sts_nikah" class="form-control selectpicker">
												<?php $arr = array('Single', 'Menikah', 'Cerai');
													foreach ($arr as $arr) {
														echo "<option value='" . $arr . "'>" . $arr . "</option>";
													} ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div id="status" style="display: none">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Nama Pasangan</label>
											<div class="col-md-8">
												<input type="text" name="nama_pasangan" class="form-control">
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Tempat Lahir Pasangan</label>
											<div class="col-md-5">
												<input type="text" name="tempat_pasangan" class="form-control">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Tanggal Lahir Pasangan</label>
											<div class="col-md-5">
												<div class="datepicker-center">
													<div class="input-group date">
														<div class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i>
														</div>
														<input type="text" name="tgl_pasangan" class="form-control" placeholder="yyyy-mm-dd">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="panel-footer">
							<div class="btn-groups">
								<a href="<?= site_url(ucfirst('maker/input/edit_input/')) . $row->no_fos ?>" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
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

<script>
	$('.selectpicker').selectpicker('refresh');

	$('#sts_nikah').change(function() {
		if ($(this).val() == 'Menikah') {
			$('#status').css('display', 'block');
		} else {
			$('#status').css('display', 'none');
		}
	});
</script>