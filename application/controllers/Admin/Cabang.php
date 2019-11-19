<?php defined('BASEPATH') or exit('No direct script access allowed');
class Cabang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');

        $model = array('m_cabang');
        foreach ($model as $mod) {
            $this->load->model($mod);
        }
        $email = $this->session->userdata('email');
        if (empty($email)) {
            $this->session->sess_destroy();
            redirect('login');
        }
    }

    function get_cabang()
    {
        $data = $this->db->get('tbl_cabang')->result_array();
        echo json_encode($data);
        exit;
    }

    function index()
    {
        $isi = array(
            'konten' => 'admin/v_cabang'
        );

        ob_start('ob_gzhandler');
        $this->load->view('layout/_header');
        $this->load->view('layout/_content', $isi);
    }

    function add_cabang()
    {
        $isi = array(
            'konten' => 'admin/add_cabang'
        );

        ob_start('ob_gzhandler');
        $this->load->view('layout/_header');
        $this->load->view('layout/_content', $isi);
    }

    function edit_cabang($id)
    {
        $isi = array(
            'konten' => 'admin/edit_cabang',
            'data' => $this->m_cabang->getData($id)
        );

        ob_start('ob_gzhandler');
        $this->load->view('layout/_header');
        $this->load->view('layout/_content', $isi);
    }

    function save()
    {
        $id = $this->input->post('id');
        $method = $this->input->post('method');

        $data = array(
            'kd_cabang' => 'ID' . $this->input->post('kd_cabang'),
            'nama_cabang' => $this->input->post('nama_cabang'),
            'area' => $this->input->post('area'),
            'region' => $this->input->post('region')
        );

        if ($method == 'add') {
            $qry = $this->db->get_where('tbl_cabang', ['kd_cabang' => $data['kd_cabang']]);
            if ($qry->num_rows() > 0) {
                $this->session->set_flashdata('Error', "Data cabang <b>" . $data['kd_cabang'] . "</b> sudah tersedia!");
            } else {
                $this->db->insert('tbl_cabang', $data);
                $this->session->set_flashdata('Info', "Data cabang <b>" . $data['kd_cabang'] . " - " . $data['nama_cabang'] . "</b> berhasil disimpan!");
            }
        } else {
            $this->db->update('tbl_cabang', $data, ['id' => $id]);
            $this->session->set_flashdata('Info', "Data cabang <b>" . $data['kd_cabang'] . " - " . $data['nama_cabang'] . "</b> berhasil diubah!");
        }
        redirect(ucfirst('admin/cabang'));
    }


    function print_cabang()
    {
        global $title;
        $fpdf = new PDF('L');
        $title = 'Laporan Daftar Cabang';
        $fpdf->SetTitle($title);
        $fpdf->AliasNbPages();

        $fpdf->AddPage();
        
        // load data cabang
        $cabang = $this->db->get('tbl_cabang')->result_array();
        // set body table
        $fpdf->SetFont('Times', '', 10);
        $no = 1;
        foreach ($cabang as $dt) {
            $fpdf->Cell(25);
            $fpdf->Cell(10, 6, $no++, 1, 0, 'C');
            $fpdf->Cell(35, 6, $dt['kd_cabang'], 1, 0, 'L');
            $fpdf->Cell(80, 6, $dt['nama_cabang'], 1, 0, 'L');
            $fpdf->Cell(80, 6, $dt['area'], 1, 0, 'L');
            $fpdf->Cell(20, 6, $dt['region'], 1, 1, 'C');
        }
        // give the name file
        $fpdf->Output('I', 'Cabang.pdf');
    }
}
