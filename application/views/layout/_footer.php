<!-- jQuery -->
<script src="<?= base_url('assets/jquery/jquery-3.3.1.min.js') ?>"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?= base_url('assets/metisMenu/metisMenu.min.js') ?>"></script>
<!-- DataTables JavaScript -->
<script src="<?= base_url('assets/DataTables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables/js/dataTables.bootstrap.min.js') ?>"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= base_url('assets/js/sb-admin-2.js') ?>"></script>
<!-- Bootstrap-datepicker JavaScript -->
<script src="<?= base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
<!-- Numeral.Js -->
<script src="<?= base_url('assets/numeral/numeral.js') ?>"></script>
<!-- Bootstrap Validator -->
<script src="<?= base_url('assets/bootstrapvalidator/dist/js/bootstrapValidator.js') ?>"></script>
<!-- search select option bootstrap / bootstrap-select -->
<script src="<?= base_url('assets/bootstrap-select/js/bootstrap-select.min.js') ?>"></script>



<!-- from layout/_content -->
<script type="text/javascript">
    $('.input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        enableOnReadonly: false
    });

    // function ImgPreview(userfile, idPriview) {
    //     var gb = userfile.files;
    //     for (var i = 0; i < gb.length; i++) {
    //         var gbPriview = gb[i];
    //         var imgType = /image.*/;
    //         var priview = document.getElementById(idPriview);
    //         var reader = new FileReader();
    //         if (gbPriview.type.match(imgType)) {
    //             // jika tipe data sesuai
    //             priview.file = gbPriview;
    //             reader.onload = (function(elemet) {
    //                 return function(e) {
    //                     elemet.src = e.target.result;
    //                 };
    //             })(preview);
    //             // membaca data URL gambar
    //             reader.readAsDataURL(gbPriview);
    //         } else {
    //             // membaca tipe data tidak sesuai
    //             alert('Tipe file tidak sesuai');
    //         }
    //     }
    // }

    // $(document).ready(function() {
    //     $('#multiple').multiselect({
    //         nonSelectedText: '-- Pilih --',
    //         enableFiltering: true,
    //         enableCaseInsensitiveFiltering: true,
    //         maxHeight: 250,
    //         buttonWidth: '380px'
    //     });
    // });
</script>
<!-- ./from layout/_content -->

<?php $url = $this->uri->segment(2);
switch ($url) {
    case 'user':
        $this->load->view('admin/js/user-valid');
        break;
    case 'cabang':
        $this->load->view('admin/js/cabang-valid');
        break;
    case 'koperasi':
        $this->load->view('maker/js/kop-valid');
        break;
    case 'input':
        $this->load->view('maker/js/input-valid');
        break;
    case 'induk':
        $this->load->view('maker/js/induk-valid');
        break;
    case 'anak':
        $this->load->view('maker/js/anak-valid');
        break;
    case 'link':
        $this->load->view('maker/js/link-valid');
        break;
    case 'jaminan':
        $this->load->view('maker/js/jaminan-valid');
        break;
    case 'asset':
        $this->load->view('maker/js/asset-valid');
        break;
    case 'kontrak':
        $this->load->view('maker/js/kontrak-valid');
        break;
    default:
        break;
} ?>

    </body>

    </html>