<script type="text/javascript">
    var save_method;
    list_region();
    list_area();

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

        $('#tbl_cabang, #tbl_area').DataTable({
            'order': [],
            'columnDefs': [{
                'targets': [0, -1],
                'orderable': false
            }],
            'scrollY': 250
        });

        $('select').change(function() {
            $(this).parent().parent().removeClass('has-error');
        });

        $('#modal_region, #modal_office, #modal_office_edit, #modal_area, #modal_area_edit').on('show.bs.modal', function() {
            $('div').removeClass('has-error');
            $('span.help-block').empty();
        });
    });

    $(document).on('keydown', 'input', function() {
        $(this).css('text-transform', 'uppercase');
        $(this).parents().removeClass('has-error');
        $(this).next().empty();
    });

    // # check number javascript
    function CheckNumeric() {
        return event.keyCode >= 48 && event.keyCode <= 57;
    }
    // # check number javascript

    // management region
    function add_region() {
        save_method = 'add';
        $('#form_region')[0].reset();
        $('#modal_region').modal('show');
        $('#title_region').text('Tambah Daftar Region');
    }

    function save_region() {
        var url = '';
        if (save_method == 'add') url = "<?= site_url(ucfirst('admin/cabang/save_region')) ?>";
        else url = "<?= site_url(ucfirst('admin/cabang/update_region')) ?>";

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: $('#form_region').serialize(),
            success: function(data) {
                if (data.status) {
                    if (save_method == 'add') alert('Data region berhasil ditambah');
                    else alert('Data region berhasil diubah');
                    $('#modal_region').modal('hide');
                    location.reload();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error[i]);
                    }
                }
            }
        });
    }

    function edit_region(id) {
        save_method = 'update';
        $('#form_region')[0].reset();
        $('#title_region').text('Ubah Daftar Region');

        $.ajax({
            url: "<?= site_url(ucfirst('admin/cabang/edit_region/')) ?>" + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('#modal_region').modal('show');
                $('[name="kode_region"]').val(data.kd_region.substring(2));
                $('[name="nama_region"]').val(data.nm_region);
            }
        });
    }
    // management region

    // management area
    var id = 1;
    $('#add').click(function() {
        var html = '<div id="copy">';
        html += '<div class="btn btn-default" id="del" onclick="hapus()"><i class="fa fa-fw fa-minus"></i></div>';
        html += '<div class="form-group">';
        html += '<label class="control-label col-md-3">Kode Area</label>';
        html += '<div class="col-md-4">';
        html += '<input type="text" class="form-control" name="kd_area[' + id + ']" id="kd_area" onkeypress="return CheckNumeric()">';
        html += '<span class="help-block"></span>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label class="control-label col-md-3">Nama Area</label>';
        html += '<div class="col-md-6">';
        html += '<input type="text" class="form-control" name="nm_area[' + id + ']" id="nm_area">';
        html += '<span class="help-block"></span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#clone').append(html);
        id++;
    });

    function hapus() {
        $('#del').parents('#copy').remove();
    }

    function list_region() {
        $.ajax({
            url: '<?= site_url(ucfirst('admin/cabang/list_region')) ?>',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                html = '<option disabled selected>-- Please Select --</option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].nm_region + '">' + data[i].nm_region + '</option>';
                }
                $('#nm_region').html(html);
                $('#nm_region_edit').html(html);
                $('#region').html(html);
                $('#region_edit').html(html);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

    $('#region, #region_edit').change(function() {
        id = $(this).val();
        $.ajax({
            url: '<?= site_url(ucfirst('admin/cabang/get_area/')) ?>' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                html = '<option disabled selected>-- Please Select --</option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].kd_area + '">' + data[i].nm_area + '</option>';
                }
                $('#area').html(html);
                $('#area_edit').html(html);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });

    function add_area() {
        save_method = 'add';
        $('#form_area')[0].reset();
        $('#modal_area').modal('show');
        $('#title_area').text('Tambah Daftar Area');
        $('.selectpicker').selectpicker('refresh');
    }

    function save_area() {
        var url = '',
            data;
        if (save_method == 'add') {
            data = $('#form_area').serialize();
            url = "<?= site_url(ucfirst('admin/cabang/save_area')) ?>";
        } else {
            data = $('#form_area_edit').serialize();
            url = "<?= site_url(ucfirst('admin/cabang/update_area')) ?>";
        }

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: data,
            success: function(data) {
                if (data.status) {
                    if (save_method == 'add') alert('Data area berhasil ditambah');
                    else alert('Data area berhasil diubah');
                    $('#modal_area, #modal_area_edit').modal('hide');
                    location.reload();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        if (data.error[i] == '') {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        } else {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error[i]);
                        }
                    }
                }
            }
        });
    }

    function edit_area(id) {
        save_method = 'update';
        $('#form_area_edit')[0].reset();
        $('#title_area_edit').text('Ubah Daftar Area');

        $.ajax({
            url: "<?= site_url(ucfirst('admin/cabang/edit_area/')) ?>" + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('#modal_area_edit').modal('show');
                $('#nm_region_edit').val(data.nm_region);
                $('#kd_area_edit').val(data.kd_area.substring(2, 9));
                $('#nm_area_edit').val(data.nm_area);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
    // management region

    // management cabang
    function list_area() {
        $.ajax({
            url: '<?= site_url(ucfirst('admin/cabang/list_area')) ?>',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                html = '<option disabled selected>-- Please Select --</option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].kd_area + '">' + data[i].nm_area + '</option>';
                }
                $('#area').html(html);
                $('#area_edit').html(html);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

    var id_cabang = 1;
    $('#add_cabang').click(function() {
        var html = '<div id="copy_cabang">';
        html += '<div class="btn btn-default" id="del_cabang" onclick="hapus_cabang()"><i class="fa fa-fw fa-minus"></i></div>';
        html += '<div class="form-group">';
        html += '<label class="control-label col-md-3">Kode Cabang</label>';
        html += '<div class="col-md-4">';
        html += '<input type="text" class="form-control" name="kd_cabang[' + id_cabang + ']" id="kd_cabang" onkeypress="return CheckNumeric()">';
        html += '<span class="help-block"></span>';
        html += '</div>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label class="control-label col-md-3">Nama Cabang</label>';
        html += '<div class="col-md-8">';
        html += '<input type="text" class="form-control" name="nm_cabang[' + id_cabang + ']" id="nm_cabang">';
        html += '<span class="help-block"></span>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#clone_cabang').append(html);
        id_cabang++;
    });

    function hapus_cabang() {
        $('#del_cabang').parents('#copy_cabang').remove();
    }

    function add_cabang() {
        save_method = 'add';
        $('#form_office')[0].reset();
        $('#modal_office').modal('show');
        $('#title_office').text('Tambah Daftar Cabang');
    }

    function save_office() {
        var url = '',
            data;
        if (save_method == 'add') {
            data = $('#form_office').serialize();
            url = "<?= site_url(ucfirst('admin/cabang/save_cabang')) ?>";
        } else {
            data = $('#form_office_edit').serialize();
            url = "<?= site_url(ucfirst('admin/cabang/update_cabang')) ?>";
        }

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: data,
            success: function(data) {
                if (data.status) {
                    if (save_method == 'add') alert('Data cabang berhasil ditambah');
                    else alert('Data cabang berhasil diubah');
                    $('#modal_office, #modal_office_edit').modal('hide');
                    location.reload();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        if (data.error[i] == '') {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        } else {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error[i]);
                        }
                    }
                }
            }
        });
    }

    function edit_cabang(id) {
        save_method = 'update';
        $('#form_office_edit')[0].reset();
        $('#title_office_edit').text('Ubah Daftar Cabang');

        $.ajax({
            url: "<?= site_url(ucfirst('admin/cabang/edit_cabang/')) ?>" + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('#modal_office_edit').modal('show');
                $('#area_edit').val(data.area);
                $('#region_edit').val(data.region);
                $('#kd_cabang_edit').val(data.kd_cabang.replace('ID', ''));
                $('#nm_cabang_edit').val(data.nama_cabang);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }
    // management cabang
</script>