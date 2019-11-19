<script type="text/javascript">
	var njop = document.getElementById('njop');
	njop.addEventListener('keyup', function(evt){
		njop.value = numeral(this.value).format('0,0');
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
				tipe_jaminan: {
					validators: {
						notEmpty: {
							message: msg
						}
					}
				},
				deskripsi: {
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
							max: 35
						}
					}
				},
                surat_bukti: {
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
				mata_uang: {
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
				negara: {
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
							max: 2
						}
					}
				},
				njop: {
					validators: {
						regexp: {
							regexp: /^[0-9,]+$/,
							message: 'Please enter only number characters'
						},
						stringLength: {
							max: 19
						}
						<?php /*callback: {
							callback: function(value, validator, $field){
								var val = $field.val();
								if(val != 0){
									return true;
								} else {
									return {
										valid: false,
										message: 'This value is not valid'
									}
								}
							}
						}*/ ?>
					}
				}
			}
		});
	});
</script>