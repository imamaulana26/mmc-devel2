<div class="row">
	<div class="col-md-12">
		<h1 class="page-header">Step 7 : Pendaftaran Agent</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
		<?php foreach($data->result() as $row){ ?>
			<form method="post" id="formValid" action="<?= site_url(ucfirst('maker/agent/simpanData')) ?>" class="form-horizontal">
				<div class="panel-body">
					<input type="hidden" name="nip" value="<?= $row->nip ?>">
					<input type="hidden" name="no_fos" value="<?= $row->no_fos ?>">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Nama Koperasi</label>
								<div class="col-md-8">
									<input type="text" class="form-control" value="<?= $row->nama_kop ?>" readonly>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Tanggal Expire</label>
								<div class="col-md-5">
									<div class="datepicker-center dateContainer">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-calendar"></i>
											</div>
											<input type="text" class="form-control" placeholder="yyyy-mm-dd" value="<?= $row->tgl_expired ?>" readonly>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">CIF Induk <span class="help-text"></span></label>
								<div class="col-md-4">
									<input type="text" class="form-control" value="<?= $row->cif_induk ?>" readonly>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Tenor Bank <span class="help-text"></span></label>
								<div class="col-md-2">
									<input type="text" name="tenor_bank" class="form-control" value="<?= $row->tenor ?>" readonly>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Rate Bank <span class="help-text"></span></label>
								<div class="col-md-3">
									<input type="text" name="rate_bank" class="form-control">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Rekening Agent <span class="help-text"></span></label>
								<div class="col-md-4">
									<input type="text" name="rek_agent" class="form-control">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Nomor PKS <span class="help-text"></span></label>
								<div class="col-md-5">
									<input type="text" class="form-control" value="<?= $row->no_pks ?>" readonly>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4">Nomor SKKP <span class="help-text"></span></label>
								<div class="col-md-5">
									<input type="text" name="no_skkp" class="form-control">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
	                		<div class="form-group">
	                			<label class="control-label col-md-4">Tgl. Keputusan Komite <span class="help-text"></span></label>
	                			<div class="col-md-5">
			                		<div class="datepicker-center">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="glyphicon glyphicon-calendar"></i>
											</div>
											<input type="text" name="tgl_komite" class="form-control" placeholder="yyyy-mm-dd">
										</div>
									</div>
			                	</div>
	                		</div>
	                	</div>
					</div>

				</div>
				<div class="panel-footer">
					<button type="submit" class="btn btn-primary" style="margin-left: 85%">
						Next <i class="glyphicon glyphicon-chevron-right"></i>
					</button>
				</div>
			</form>
		<?php } ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var msg = 'This field is required and can\'t be empty';
        var numb = /^[0-9]+$/;
        var char = /^[A-Z ]+$/;

		$('#formValid').bootstrapValidator({
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				nama_kop: {
					validators: {
						notEmpty: {
							message: msg
						},
						stringCase: {
							'case': 'upper'
						},
						stringLength: {
							max: 35
						}
					}
				},
				rate_bank: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: numb
						},
						stringLength: {
							max: 3
						}
					}
				},
				rek_agent: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: numb
						},
						stringLength: {
							max: 16
						}
					}
				},
				no_skkp: {
					validators: {
						notEmpty: {
							message: msg
						},
						stringCase: {
							'case': 'upper'
						},
						stringLength: {
							max: 35
						}
					}
				},
				tgl_komite: {
					validators: {
						notEmpty: {
							message: msg
						},
						date: {
							format: 'YYYY-MM-DD'
						}
					}
				},
			}
		});

		$('.input-group.date').on('changeDate show', function(e){
			$('#formValid').bootstrapValidator('revalidateField', 'tgl_komite');
		});
	});
</script>