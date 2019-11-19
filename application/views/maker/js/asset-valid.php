<script type="text/javascript">
	function getTotal(){
		harga = document.getElementById('harga').value;
		jumlah = document.getElementById('jumlah').value;
		var uang_muka = $('#dp').val().replace(',','');
		var new_dp = uang_muka.split(',').join('');

		document.getElementById('total').value = numeral((harga*jumlah)-new_dp).format('0,0');
	}
	
	function toggleCheckbox() {
		if (document.getElementById("checkbox").checked){
			rek_pemasok.readOnly = false;
			cif_pemasok.readOnly = false;
			nama_pemasok.readOnly = false;
			rek_pemasok.value = "";
			cif_pemasok.value = "";
			nama_pemasok.value = "";
			<?php $array = array('rek_pemasok','cif_pemasok','nama_pemasok');
	        foreach($array as $val){ ?>
	            $('#formValid').bootstrapValidator('updateStatus', '<?= $val ?>', 'NOT_VALIDATED');
	        <?php } ?>
			$('h5').html('');
		} else {
			rek_pemasok.readOnly = true;
			cif_pemasok.readOnly = true;
			nama_pemasok.readOnly = true;
			rek_pemasok.value = $('#rek').val();
			cif_pemasok.value = $('#cif').val();
			nama_pemasok.value = $('#kop').val();
			<?php $array = array('rek_pemasok','cif_pemasok','nama_pemasok');
	        foreach($array as $val){ ?>
	            $('#formValid').bootstrapValidator('updateStatus', '<?= $val ?>', 'NOT_VALIDATED');
	        <?php } ?>
			$('h5').html('<i class="text-muted">'+$('#nama').val()+'</i>');
		}
	}

	var dp = document.getElementById('dp');
	dp.addEventListener('keyup', function(evt){
		dp.value = numeral(this.value).format('0,0');
	});

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
				nama_asset: {
					validators: {
						notEmpty: {
							message: msg
						},
						stringCase: {
							'case': 'upper'
						},
						stringLength: {
							max: 15
						}
					}
				},
				nama_pemasok: {
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
				cif_pemasok: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: numb
						},
						stringLength: {
							max: 15
						}
					}
				},
				rek_pemasok: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: numb
						},
						stringLength: {
							max: 15
						}
					}
				},
				ket_asset: {
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
				uang_muka: {
					validators: {
						regexp: {
							regexp: /^[0-9,]+$/,
							message: 'Please enter only number characters'
						},
						stringLength: {
							max: 19
						}
					}
				},
				jumlah_asset: {
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
				}
			}
		});
	});
</script>