<script type="text/javascript">
	$(document).ready(function(){
		var nominal = document.getElementById('nominal');
	    nominal.addEventListener('keyup', function(evt){
	        nominal.value = numeral(this.value).format('0,0');
	    });

	    var max = 10;
		var wrapper1 = $('.multiple-form-group-1');
		var wrapper2 = $('.multiple-form-group-2');
		var add_field1 = $('.btn-add-1');
		var add_field2 = $('.btn-add-2');

		var text1 = "<div class='input-group' style='margin-bottom: 10px'><input type='text' name='tenor_bank[]' placeholder='Ex. 12' class='form-control'><div class='input-group-addon btn btn-danger btn-remove'>-</div></div>";

		var text2 = "<div class='input-group' style='margin-bottom: 10px'><input type='text' name='rate_bank[]' placeholder='Ex. 15.00' class='form-control'><div class='input-group-addon btn btn-remove btn-danger'>-</div></div>";


		$(add_field1).click(function(evt){
			evt.preventDefault();
			if($('#formValid').find(':visible[name="tenor_bank[]"]').length < max){
				$(wrapper1).append(text1);
			} else{
				alert('You Reached the limits');
			}
		});

		$(add_field2).click(function(evt){
			evt.preventDefault();
			if($('#formValid').find(':visible[name="rate_bank[]"]').length < max){
				$(wrapper2).append(text2);
			} else{
				alert('You Reached the limits');
			}
		});

		$('body').on('click', '.btn-remove', function(evt){
			$(this).parents('.input-group').remove();
		});

		var msg = 'This field is required and can\'t be empty';
        var numb = /^[0-9]+$/;
        var char = /^[A-Z ]+$/;
        var max_opt = 5;

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
						},
						regexp: {
							regexp: char
						}
					}
				},
				'tenor_bank[]': {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            max: 3
                        },
                        callback: {
                            callback: function(value, validator, $field){
                                var val = $field.val()
                                if(val >= 12 && val != 0){
                                    return true;
                                } else{
                                    return {
                                        valid: false,
                                        message: 'This value is not valid, value must be greater than 12'
                                    }
                                }
                            }
                        }
                    }
                },
				'rate_bank[]': {
					validators: {
						notEmpty: {
							message: msg
						},
						regexp: {
							regexp: /^[0-9.]+$/
						},
						stringLength: {
							max: 5
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
				rek_agent: {
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
                rek_escrow: {
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
				nominal: {
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
                npwp: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            min: 15,
                            max: 15
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
                cif_induk: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            max: 10
                        }
                    }
                }
			}
		});
	});
</script>