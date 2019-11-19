<script type="text/javascript">
    $(document).ready(function() {
        var msg = 'This field is required and can\'t be empty';
        var numb = /^[0-9]+$/;
        var char = /^[A-Z ]+$/;

        $('#form-cabang').bootstrapValidator({
            message: 'This value is not valid',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                kd_cabang: {
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
                nama_cabang: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: char,
                            message: 'Please enter only uppercase characters'
                        }
                    }
                },
                area: {
                    validators: {
                        notEmpty: {
                            message: msg
                        },
                        regexp: {
                            regexp: char,
                            message: 'Please enter only uppercase characters'
                        }
                    }
                },
                region: {
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