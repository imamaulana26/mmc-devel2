<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Step 7 : Pendaftaran Kontrak (LD)</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<p class="text-danger">*) Saya <b><?= $this->session->userdata('nama_user') ?></b>, dengan ini menyatakan sebenar-benarnya bahwa apa yang saya input pada Aplikasi ini sesuai dengan dokumen yang ada dan dapat dipertanggung jawabkan.</p>

			<div class="panel panel-default">
				<?php foreach ($data->result() as $row) { ?>
					<form method="post" id="formValid" action="<?= site_url(ucfirst('maker/kontrak/simpanData')) ?>" class="form-horizontal" autocomplete="off">
						<div class="panel-body">
							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#tab-1">Layar Input Pembiayaan Financing</a></li>
								<li><a data-toggle="tab" href="#tab-2">Data Statis Pembiayaan Murabahah</a></li>
							</ul>
							<div class="tab-content">
								<input type="hidden" name="no_fos" value="<?= $row->no_fos ?>">
								<input type="hidden" name="nip" value="<?= $row->nip_member_kop ?>">
								<input type="hidden" name="method" value="add"><br>
								<div id="tab-1" class="tab-pane fade in active">

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Nomor CIF <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="<?= $row->cif ?>" readonly>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Tgl. Angsuran</label>
												<div class="col-md-2">
													<input type="text" class="form-control" value="<?= $row->tgl_angsuran ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Mata Uang</label>
												<div class="col-md-3">
													<input type="text" class="form-control" value="<?= $row->mata_uang ?>" readonly>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Tipe Produk <span class="help-text"></span></label>
												<div class="col-md-8">
													<select name="tipe_produk" class="form-control selectpicker" data-live-search="true">
														<option value="MUR0019" selected>MUR0019</option>
														<?php foreach ($produk as $li) {
																echo "<option value='$li->id'>" . $li->id . " - " . $li->deskripsi . "</option>";
															} ?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Kode Unit Kerja <span class="help-text"></span></label>
												<div class="col-md-6">
													<select name="kode_unit" class="form-control selectpicker">
														<?php $list = array(38 => 'BBG B to B', 39 => 'BBG B to C');
															foreach ($list as $key => $li) {
																if ($key == 38) {
																	echo "<option value='$key' selected>" . $key . " - " . $li . "</option>";
																} else {
																	echo "<option value='$key' disabled>" . $key . " - " . $li . "</option>";
																}
															} ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Nilai Maksimal Penggunaan</label>
												<div class="col-md-5">
													<input type="text" id="maks_guna" class="form-control" value="<?= number_format($row->nom_max_guna, 0, '.', ',') ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Kode AO Marketing <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="<?= $row->kode_ao ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Kode AO Risk Officer</label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="<?= $row->kode_fao ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Kode AO Pimpinan Cabang</label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="<?= $row->kode_pim ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Tipe Angsuran <span class="help-text"></span></label>
												<div class="col-md-6">
													<select name="tipe_angsuran" class="form-control selectpicker">
														<?php $tipe = array('Efektif Tetap', 'Efektif Sliding', 'Flat', 'Proposional', 'Irregular', 'Anuitas Ulang Tahun');
															foreach ($tipe as $key => $id) {
																if ($key + 1 == 1) {
																	echo "<option value='" . ($key + 1) . "' selected>" . ($key + 1) . " - " . $id . "</option>";
																} else {
																	echo "<option value='" . ($key + 1) . "' disabled>" . ($key + 1) . " - " . $id . "</option>";
																}
															} ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Tenor (bulan) <span class="help-text"></span></label>
												<div class="col-md-2">
													<input type="text" class="form-control" id="tenor" value="<?= $row->tenor ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Pengusul Pembiayaan <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" name="pengusul" class="form-control">
												</div>
											</div>
										</div>
										<!-- <div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Rate Fee Agent</label>
										<div class="col-md-2">
											<input type="text" class="form-control" readonly>
										</div>
										<p class="text-muted control-label">akan disuplai corebanking</p>
									</div>
								</div> -->
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Pemutus Pembiayaan <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" name="pemutus" class="form-control">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Rekening Agent</label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="<?= $row->rek_agent ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Segmentasi Produk <span class="help-text"></span></label>
												<div class="col-md-6">
													<select name="segmen_produk" class="form-control selectpicker">
														<?php $list = array('CONS' => 'Konsumer (Konsumtif)', 'INV' => 'Investasi (Produktif)', 'WCAP' => 'Modal Kerja (Produktif)');
															foreach ($list as $key => $li) {
																$select = '';
																if ($key == 'CONS') $select = 'selected';
																echo "<option value='$key' " . $select . ">" . $key . " - " . $li . "</option>";
															} ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Rekening Pokok <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="<?= $row->rek_pokok ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Rekening Nasabah <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" class="form-control" value="<?= $row->rek_nsbh ?>" readonly>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Rekening Margin <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" name="rek_margin" class="form-control" value="<?= $row->rek_pokok ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<!-- <div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Total Biaya</label>
										<div class="col-md-5">
											<input type="text" name="total_biaya" id="total_biaya" class="form-control" readonly>
										</div>
									</div>
								</div> -->
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Rekening Biaya <span class="help-text"></span></label>
												<div class="col-md-4">
													<input type="text" name="rek_biaya" class="form-control" value="<?= $row->rek_nsbh ?>">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Penanda Wakalah <span class="help-text"></span></label>
												<div class="col-md-8">
													<label class="radio-inline">
														<input type="radio" name="wakalah" value="NO">NO
													</label>
													<label class="radio-inline">
														<input type="radio" name="wakalah" value="YES" checked>YES
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Tipe Margin <span class="help-text"></span></label>
												<div class="col-md-8">
													<label class="radio-inline">
														<input type="radio" name="tipe_margin" value="1" checked>1 - Margin Single
													</label>
													<label class="radio-inline">
														<input type="radio" name="tipe_margin" value="2">2 - Margin Bertingkat
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">% Margin</label>
												<div class="col-md-3">
													<input type="text" name="margin" id="margin" class="form-control" placeholder="Ex. 15.00">
												</div>
												<p class="control-label text-muted">(Rate Bank + Fee Agent)</p>
											</div>
										</div>
										<!-- <div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Total Margin</label>
										<div class="col-md-5">
											<input type="text" name="total_margin" id="total_margin" class="form-control" readonly>
										</div>
									</div>
								</div> -->
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Biaya Teratribusi <span class="help-text"></span></label>
												<div class="col-md-8">
													<label class="radio-inline">
														<input type="radio" name="teratribusi" value="N" checked>NO
													</label>
													<label class="radio-inline">
														<input type="radio" name="teratribusi" value="Y">YES
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Kode Biaya <a href="#" class="btn-add-1">+</a></label>
												<div class="col-md-7 multiple-form-group-1">
													<div style="margin-bottom: 10px">
														<select name="kode_biaya[]" class="form-control selectpicker">
															<option selected disabled>-- Pilih --</option>
															<?php $list = array('FINAPP' => 'Biaya Penilalaian', 'FINDIS' => 'Biaya Pencairan Murabahah', 'FININS' => 'Biaya Asuransi', 'FINNTRY' => 'Biaya Notaris', 'FINOTH' => 'Biaya Lain - lain', 'FINSMTP' => 'Biaya Materai');
																foreach ($list as $key => $li) {
																	echo "<option value='" . $key . "'>" . $key . " - " . $li . "</option>";
																} ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Nilai Biaya</label>
												<div class="col-md-5 multiple-form-group-2">
													<div style="margin-bottom: 10px">
														<input type="number" name="nilai_biaya[]" class="form-control">
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>

								<div id="tab-2" class="tab-pane fade in"><br>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Status Piutang <span class="help-text"></span></label>
												<div class="col-md-8">
													<label class="radio-inline">
														<input type="radio" name="stat_piutang" value="10">10 - Dlm Rangka Restrukturisasi
													</label>
													<label class="radio-inline">
														<input type="radio" name="stat_piutang" value="20" checked>20 - Bkn Dlm Rangka Restrukturisasi
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Orientasi Penggunaan</label>
												<div class="col-md-8">
													<label class="radio-inline">
														<input type="radio" name="orientasi" disabled>[None]
													</label>
													<label class="radio-inline">
														<input type="radio" name="orientasi" value="1">1 - Ekspor
													</label>
													<label class="radio-inline">
														<input type="radio" name="orientasi" value="9" checked>9 - Lainnya
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Sifat Piutang</label>
												<div class="col-md-8">
													<label class="radio-inline">
														<input type="radio" name="piutang" disabled>[None]
													</label>
													<label class="radio-inline">
														<input type="radio" name="piutang" value="1" checked>1 - Dengan Akad
													</label>
													<label class="radio-inline">
														<input type="radio" name="piutang" value="9">9 - Tanpa Akad
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Kategori Portofolio <span class="help-text"></span></label>
												<div class="col-md-4">
													<select name="portofolio" class="form-control selectpicker">
														<?php $list = array(10 => 'Tagihan Kepada Pemerintah Indonesia', 11 => 'Tagihan Kepada Pemerintah Negara Lain', 12 => 'Tagihan kpd Bank Pembangunan Multilateral', 13 => 'Tagihan kpd Bank Pembangunan Multilateral Lainnya', 14 => 'Tagihan kpd Bank Jk. Pendek (Antarbank =< 3 bulan)', 15 => 'Tagihan kpd Bank Jk. Panjang (Antarbank > 3 bulan)', 16 => 'Tagihan kpd Entitas Sektor Publik (BUMN,BUMD,Pemda)', 35 => 'Tagihan Kepada Korperasi', 36 => 'Tagihan kpd Usaha Mikro/Kecil & Portofolio Ritel', 37 => 'Pembiayaan KPR Rumah Tgl - Financing To Value <70%', 38 => 'Pembiayaan KPR Rumah Tinggal - 70% < FTV < 80%', 39 => 'Pembiayaan KPR Rumah Tinggal - 80% < FTV < 95%', 40 => 'Pembiayaan PNS/Pensiunan (TNI/POLRI,& BUMN/BUMD)', 42 => 'Pembiayaan Beragun Properti Komersial', 60 => 'Pembiayaan NPF (Past Due > 90 hari) KPR', 62 => 'Pembiayaan NPF (Past due > 90 hari) Selain KPR', 70 => 'Eksposur Sekuritisasi');
															foreach ($list as $key => $li) {
																if ($key == 35) {
																	echo "<option value='$key' selected>" . $key . " - " . $li . "</option>";
																} else {
																	echo "<option value='$key' disabled>" . $key . " - " . $li . "</option>";
																}
															} ?>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Lokasi Proyek <span class="help-text"></span></label>
												<div class="col-md-6">
													<?php foreach ($lokasi as $lok) {
															if ($lok->id == $row->lokasi_proyek) { ?>
															<input type="text" class="form-control" value="<?= $lok->id ?> - <?= $lok->deskripsi ?>" readonly>
													<?php }
														} ?>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Sektor Ekonomi <span class="help-text"></span></label>
												<div class="col-md-6">
													<?php foreach ($sektor as $sek) {
															if ($sek->id == $row->sektor_ekonomi) { ?>
															<input type="text" class="form-control" value="<?= $sek->id ?> - <?= $sek->deskripsi ?>" readonly>
													<?php }
														} ?>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Jenis Penggunaan <span class="help-text"></span></label>
												<div class="col-md-4">
													<?php foreach ($li_guna as $key => $li) {
															if ($key == $row->jenis_guna) {
																echo "<input type='text' class='form-control' value='$key - $li' readonly>";
															}
														} ?>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-2">Nomor Akad <span class="help-text"></span></label>
												<div class="col-md-3">
													<input type="text" name="no_akad" class="form-control">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Tanggal Akad <span class="help-text"></span></label>
												<div class="col-md-5">
													<div class="datepicker-center">
														<div class="input-group date">
															<div class="input-group-addon">
																<i class="glyphicon glyphicon-calendar"></i>
															</div>
															<input type="text" name="tgl_akad" class="form-control" placeholder="yyyy-mm-dd">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="btn-groups">
										<a href="<?= site_url(ucfirst('maker/asset/edit_asset/')) . $row->no_fos ?>" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
										<button type="submit" class="btn btn-primary pull-right">
											Finish <i class="glyphicon glyphicon-ok"></i>
										</button>
									</div>
								</div>
							</div>
					</form>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layout/_footer'); ?>