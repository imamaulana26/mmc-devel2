<script type="text/javascript">
	var nominal = document.getElementById('nominal');
    nominal.addEventListener('keyup', function(evt){
        nominal.value = numeral(this.value).format('0,0');
    });

    var omset = document.getElementById('gaji_thn');
    var gaji = document.getElementById('gaji');
    gaji.addEventListener('keyup', function(evt){
        gaji.value = numeral(this.value).format('0,0');

        var val = $(this).val().replace(',','');
        var new_val = val.split(',').join('');
        omset.value = numeral(new_val*12).format('0,0');
    });
	
	$('#tenor').keyup(function(e){
		var date = new Date();
		var tgl = new Date(date.getFullYear(), date.getMonth(), date.getDate()+(this.value*30.42));
		
		$('#tgl_jth_tempo').val(tgl.toISOString().substr(0,10));
        $('#tgl_angsuran').val($('#tgl_jth_tempo').val().substr(8,2));
        $('#tgl_expire').val($('#tgl_jth_tempo').val());
	});
	
    $('#tgl_nota').change(function(e){
        if((this.value > $('#tgl_komite').val() && $('#tgl_komite').val() != '') || (this.value > $('#tgl_sp3').val() && $('#tgl_sp3').val() != '') || (this.value > $('#tgl_pks').val() && $('#tgl_pks').val() != '') || (this.value > $('#tgl_jth_tempo').val() && $('#tgl_jth_tempo').val() != '')){
            alert('tgl. nota tidak boleh lebih besar dari tgl. komite / tgl. SP3 / tgl. PKS / tgl. jatuh tempo');
            this.value = '';
            $('#formValid').bootstrapValidator('updateStatus', 'tgl_nota', 'NOT_VALIDATED');
        }
    });

    $('#tgl_komite').change(function(e){
        if((this.value < $('#tgl_nota').val() && $('#tgl_nota').val() != '') || (this.value > $('#tgl_sp3').val() && $('#tgl_sp3').val() != '') || (this.value > $('#tgl_pks').val() && $('#tgl_pks').val() != '') || (this.value > $('#tgl_jth_tempo').val() && $('#tgl_jth_tempo').val() != '')){
            alert('tgl. komite tidak boleh lebih besar dari tgl. SP3 / tgl. PKS / tgl. jatuh tempo dan tidak boleh lebih kecil dari tgl. nota');
            this.value = '';
            $('#formValid').bootstrapValidator('updateStatus', 'tgl_komite', 'NOT_VALIDATED');
        }
    });

    $('#tgl_sp3').change(function(e){
        if((this.value < $('#tgl_nota').val() && $('#tgl_nota').val() != '') || (this.value < $('#tgl_komite').val() && $('#tgl_komite').val() != '') || (this.value > $('#tgl_pks').val() && $('#tgl_pks').val() != '') || (this.value > $('#tgl_jth_tempo').val() && $('#tgl_jth_tempo').val() != '')){
            alert('tgl. SP3 tidak boleh lebih besar dari tgl. PKS / tgl. jatuh tempo dan tidak boleh lebih kecil dari tgl. nota / tgl. komite');
            this.value = '';
            $('#formValid').bootstrapValidator('updateStatus', 'tgl_sp3', 'NOT_VALIDATED');
        }
    });

    $('#tgl_pks').change(function(e){
        if((this.value < $('#tgl_nota').val() && $('#tgl_nota').val() != '') || (this.value < $('#tgl_komite').val() && $('#tgl_komite').val() != '') || (this.value < $('#tgl_sp3').val() && $('#tgl_sp3').val() != '') || (this.value > $('#tgl_jth_tempo').val() && $('#tgl_jth_tempo').val() != '')){
            alert('tgl. PKS tidak boleh lebih besar dari tgl. jatuh tempo dan tidak boleh lebih kecil dari tgl. nota / tgl. komite / tgl. SP3');
            this.value = '';
            $('#formValid').bootstrapValidator('updateStatus', 'tgl_pks', 'NOT_VALIDATED');
        }
    });
	
	$('#tgl_jth_tempo').change(function(e){
        if((this.value < $('#tgl_nota').val() && $('#tgl_nota').val() != '') || (this.value < $('#tgl_komite').val() && $('#tgl_komite').val() != '') || (this.value < $('#tgl_sp3').val() && $('#tgl_sp3').val() != '') || (this.value < $('#tgl_pks').val() && $('#tgl_pks').val() != '')){
            alert('tgl. jatuh tempo harus lebih besar dari nota / tgl. komite / tgl. SP3/ tgl. PKS');
            this.value = '';
			$('#tgl_angsuran').val('');
			$('#tgl_expire').val('');
            $('#formValid').bootstrapValidator('updateStatus', 'tgl_jth_tempo', 'NOT_VALIDATED');
        } else{
			$('#tgl_angsuran').val(this.value.substr(8,2));
			$('#tgl_expire').val(this.value);
		}
    });

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
                nip: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        }
                    }
                },
                cif: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            min: 8,
                            max: 12
                        }
                    }
                },
                nama_nsbh: {
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
                            max: 65
                        }
                    }
                },
                nama_kop: {
                    validators: {
                        notEmpty: {
                            message: msg
                        }
                    }
                },
                rek_nsbh: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            min: 10,
                            max: 15
                        }
                    }
                },
                rek_pokok: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            min: 10,
                            max: 15
                        }
                    }
                },
                lokasi: {
                    validators: {
                        notEmpty: {
                            message: msg
                        }
                    }
                },
                tenor: {
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
                alamat: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        stringCase: {
                            'case': 'upper'
                        },
                        stringLength: {
                            min: 10,
                            max: 35
                        },
                        regexp: {
                            regexp: /^[A-Z0-9,./ ]+$/,
                            message: 'Invalid characters'
                        }
                    }
                },
                gaji: {
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
                nominal: {
                    validators: {
                        regexp: {
                            regexp: /^[0-9,]+$/,
                            message: 'Please enter only number characters'
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
                no_sp3: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: /^[A-Z0-9./-]+$/,
                            message: 'This field must contain alfanumberic and special characters'
                        },
                        stringLength: {
                            min: 5,
                            max: 30
                        }
                    }
                },
                kode_pim: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            min: 8,
                            max: 20
                        }
                    }
                },
                kode_ao: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            min: 8,
                            max: 20
                        }
                    }
                },
                kode_fao: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            min: 8,
                            max: 20
                        }
                    }
                },
                no_pks: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: /^[A-Z0-9./-]+$/,
                            message: 'This field must contain alfanumberic and special characters'
                        },
                        stringLength: {
                            min: 5,
                            max: 30
                        }
                    }
                },
                no_skkp: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: /^[A-Z0-9./-]+$/,
                            message: 'This field must contain alfanumberic and special characters'
                        },
                        stringLength: {
                            min: 5,
                            max: 30
                        }
                    }
                },
                tgl_sp3: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        date: {
                            format: 'YYYY-MM-DD'
                        }
                    }
                },
                tgl_nota: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        date: {
                            format: 'YYYY-MM-DD'
                        }
                    }
                },
                tgl_pks: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        date: {
                            format: 'YYYY-MM-DD'
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
				tgl_jth_tempo: {
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
        });

        <?php $array = array('tgl_sp3','tgl_pks','tgl_nota','tgl_komite');
        foreach($array as $val){ ?>
            $('.input-group.date').on('changeDate show', function(e){
                $('#formValid').bootstrapValidator('revalidateField', '<?= $val ?>');
            });
        <?php } ?>
    });
</script>