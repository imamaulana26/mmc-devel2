<script type="text/javascript">
    $(document).ready(function() {
        var msg = 'This field is required and can\'t be empty';
        var numb = /^[0-9]+$/;
        var char = /^[A-Z. ]+$/;

        $('#formValid').bootstrapValidator({
            message: 'This value is not valid',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nip_user: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: numb,
                            message: 'Please enter only number characters'
                        },
                        stringLength: {
                            max: 15
                        }
                    }
                },
                nama_user: {
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
                email: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: /^[a-z0-9]+$/
                        },
                        stringLength: {
                            max: 50
                        }
                    }
                },
                jabatan: {
                    validators: {
                        notEmpty: {
                            message: msg
                        }
                    }
                },
                cabang: {
                    validators: {
                        notEmpty: {
                            message: msg
                        }
                    }
                },
                akses: {
                    validators: {
                        notEmpty: {
                            message: msg
                        }
                    }
                },
                // 'jaringan[]': {
                //     validators: {
                //         notEmpty: {
                //             message: msg
                //         }
                //     }
                // }
            }
        });
    });
</script>