<script type="text/javascript">
	$(document).ready(function(){
		var rate_bank = document.getElementById('rate_bank');
		var tenor = document.getElementById('tenor');
		var maks_guna = document.getElementById('maks_guna');
		var sum_margin = document.getElementById('total_margin');
		var margin = document.getElementById('margin');
		

		var list = {'FINAPP': 'Biaya Penilalaian','FINDIS': 'Biaya Pencairan Murabahah','FININS': 'Biaya Asuransi','FINNTRY': 'Biaya Notaris','FINOTH': 'Biaya Lain - lain','FINSMTP': 'Biaya Materai'};

		var max = 5;
		var wrapper1 = $('.multiple-form-group-1');
		var wrapper2 = $('.multiple-form-group-2');
		var add_field1 = $('.btn-add-1');

		var opt = "<option selected disabled>-- Pilih --</option><option value='FINAPP'>FINAPP - Biaya Penilalaian</option><option value='FINDIS'>FINDIS - Biaya Pencairan Murabahah</option><option value='FININS'>FININS - Biaya Asuransi</option><option value='FINNTRY'>FINNTRY - Biaya Notaris</option><option value='FINOTH'>FINOTH - Biaya Lain - lain</option><option value='FINSMTP'>FINSMTP - Biaya Materai</option>";
		var text = "<div class='input-group' style='margin-bottom: 10px'><select name='kode_biaya[]' class='form-control selectpicker'>"+opt+"</select><div class='input-group-addon btn btn-danger btn-remove'>-</div></div>";

		var text1 = "<div class='input-group' style='margin-bottom: 10px'><input type='number' name='nilai_biaya[]' class='form-control'><div class='input-group-addon btn btn-remove btn-danger'>-</div></div>";


		$(add_field1).click(function(evt){
			evt.preventDefault();
			if($('#formValid').find(':visible[name="kode_biaya[]"]').length < max){
				$(wrapper1).append(text);
				$(wrapper2).append(text1);
			} else{
				alert('You Reached the limits');
			}
		});

		$('body').on('click', '.btn-remove', function(evt){
			$(this).parents('.input-group').remove();
		});

		$('body').on('click', '.removeBtn-2', function(evt){
			$(this).parents('.form-group').remove();
		});

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
				tgl_angsuran: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				kode_unit: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				tipe_produk: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				segmen_produk: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				tipe_angsuran: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				pengusul: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: numb
						},
						stringLength: {
							max: 10
						}
					}
				},
				pemutus: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: numb
						},
						stringLength: {
							max: 10
						}
					}
				},
				rate_agent: {
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
				rek_biaya: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: numb
						},
						stringLength: {
							max: 10
						}
					}
				},
				margin: {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: /^[0-9.]+$/
						}
					}
				},
				kode_biaya: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				nilai_biaya: {
                    validators: {
                        regexp: {
                            regexp: /^[0-9,]+$/,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            max: 19
                        },
                        callback: {
                            callback: function(value, validator, $field){
                                var val = $field.val()
                                if(val != 0){
                                    return true;
                                } else{
                                    return {
                                        valid: false,
                                        message: 'This value is not valid'
                                    }
                                }
                            }
                        }
                    }
                },
                no_akad: {
					validators: {
						notEmpty: {
							message: msg
						},
						stringLength: {
							max: 30
						},
						stringCase: {
							'case': 'upper'
						}
					}
				},
				tgl_akad: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				}
			}
		});

		$('.input-group.date').on('changeDate show', function(e){
			$('#formValid').bootstrapValidator('revalidateField', 'tgl_akad');
		});
	});
</script>