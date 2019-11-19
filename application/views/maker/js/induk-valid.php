<script type="text/javascript">
	var maks_guna = document.getElementById('maks_guna');
	maks_guna.addEventListener('keyup', function(evt) {
		maks_guna.value = numeral(this.value).format('0,0');
	});

	$(document).ready(function() {
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
				uang: {
					validators: {
						notEmpty: {
							message: msg
						},
						stringCase: {
							'case': 'upper'
						},
						regexp: {
							regexp: char
						},
						stringLength: {
							max: 3
						}
					}
				},
				maks_guna: {
					validators: {
						regexp: {
							regexp: /^[0-9,]+$/,
							message: 'Please enter only number characters'
						},
						stringLength: {
							max: 19
						},
						callback: {
							callback: function(value, validator, $field) {
								var val = $field.val();
								if (val != 0) {
									return true;
								} else {
									return {
										valid: false,
										message: 'This value is not valid'
									}
								}
							}
						}
					}
				},
				segmen: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				nama_pasangan: {
					enabled: false,
					validators: {
						notEmpty: {
							message: msg
						},
						stringCase: {
							'case': 'upper'
						},
						regexp: {
							regexp: char
						},
						stringLength: {
							max: 50
						}
					}
				},
				tempat_pasangan: {
					enabled: false,
					validators: {
						notEmpty: {
							message: msg
						},
						stringCase: {
							'case': 'upper'
						},
						regexp: {
							regexp: char
						},
						stringLength: {
							max: 20
						}
					}
				},
				tgl_pasangan: {
					enabled: false,
					validators: {
						notEmpty: {
							message: msg
						},
						date: {
							format: 'YYYY-MM-DD'
						}
					}
				}
			}
		}).on('change', '[name="sts_nikah"]', function() {
			var isEmpty = $(this).val() == 'Menikah';
			$('#formValid')
				.bootstrapValidator('enableFieldValidators', 'nama_pasangan', isEmpty)
				.bootstrapValidator('enableFieldValidators', 'tgl_pasangan', isEmpty)
				.bootstrapValidator('enableFieldValidators', 'tempat_pasangan', isEmpty);

			if ($(this).val() != 'Menikah') {
				$('#formValid')
					.bootstrapValidator('validateField', 'nama_pasangan')
					.bootstrapValidator('validateField', 'tgl_pasangan')
					.bootstrapValidator('validateField', 'tempat_pasangan');
			}
		}).on('status.field.bv', function(e, data) {
			if (data.bv.getSubmitButton()) {
				data.bv.disableSubmitButtons(false);
			}
		});

		$('.input-group.date').on('changeDate show', function(e) {
			$('#formValid').bootstrapValidator('revalidateField', 'tgl_pasangan');
		});
	});
</script>