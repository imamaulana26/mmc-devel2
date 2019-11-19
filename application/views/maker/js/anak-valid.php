<script type="text/javascript">
	$(document).ready(function(){
		var msg = 'This field is required and can\'t be empty';
        var numb = /^[0-9]+$/;
        var char = /^[A-Z ]+$/;

		$('#formValid').bootstrapValidator({
			message: 'This value is not valid',
            excluded: ':disabled',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				gol_piutang: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				jenis_guna: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				sifat_pinjam: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				tipe_guna: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				status: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				sektor_ekon: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				}
			}
		});
	});
</script>