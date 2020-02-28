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

    function index()
    {
        $isi = array(
            'konten' => 'admin/v_cabang'
        );

        ob_start('ob_gzhandler');
        $this->load->view('layout/_header');
        $this->load->view('layout/_content', $isi);
    }

    public function list_region()
    {
        $list = $this->db->select('*')->from('tbl_region')->order_by('nm_region', 'asc')->get()->result_array();
        echo json_encode($list);
        exit;
    }

    public function list_area()
    {
        $list = $this->db->get('tbl_area')->result_array();
        echo json_encode($list);
        exit;
    }

    // management region
    private function validate_region()
    {
        $data = array();
        $data['inputerror'] = array();
        $data['error'] = array();
        $data['status'] = true;

        if ($this->input->post('kode_region') == '') {
            $data['inputerror'][] = 'kode_region';
            $data['error'][] = 'Kode region harus diisi';
            $data['status'] = false;
        } else if (!preg_match('/^[0-9]+$/', $this->input->post('kode_region'))) {
            $data['inputerror'][] = 'kode_region';
            $data['error'][] = 'Kode region tidak valid';
            $data['status'] = false;
        }

        if ($this->input->post('nama_region') == '') {
            $data['inputerror'][] = 'nama_region';
            $data['error'][] = 'Nama region harus diisi';
            $data['status'] = false;
        } else if (!preg_match('/^[A-Z ]+$/', $this->input->post('nama_region'))) {
            $data['inputerror'][] = 'nama_region';
            $data['error'][] = 'Nama region tidak valid, haruf huruf kapital';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function save_region()
    {
        $this->validate_region();

        $data = array(
            'kd_region' => 'ID' . $this->input->post('kode_region'),
            'nm_region' => $this->input->post('nama_region')
        );
        $this->db->insert('tbl_region', $data);
        echo json_encode(['status' => true]);
        exit();
    }

    public function edit_region($id)
    {
        $data = $this->db->get_where('tbl_region', ['kd_region' => $id])->row_array();
        echo json_encode($data);
        exit();
    }

    public function update_region()
    {
        $this->validate_region();

        $this->db->update('tbl_region', ['nm_region' => $this->input->post('nama_region')], ['kd_region' => 'ID' . $this->input->post('kode_region')]);
        echo json_encode(['status' => true]);
        exit();
    }

    public function delete_region($id)
    {
        $get_ro = $this->db->get_where('tbl_region', ['kd_region' => $id])->row_array();
        $this->db->delete('tbl_region', ['kd_region' => $id]);
        echo "<script type='text/javascript'>alert('Data region " . $get_ro['nm_region'] . " berhasil terhapus');";
        echo "window.location.href='" . site_url(ucfirst('admin/cabang')) . "';</script>";
    }
    // management region

    // management area
    private function validate_area()
    {
        $data = array();
        $data['inputerror'] = array();
        $data['error'] = array();
        $data['status'] = true;

        if ($this->input->post('nm_region') == '') {
            $data['inputerror'][] = 'nm_region';
            $data['error'][] = '';
            $data['status'] = false;
        }

        if (is_array($_POST['kd_area'])) {
            foreach ($_POST['kd_area'] as $key => $val) {
                if ($val == '') {
                    $data['inputerror'][] = 'kd_area[' . $key . ']';
                    $data['error'][] = 'Kode area harus diisi';
                    $data['status'] = false;
                } else if (!preg_match('/^[0-9]+$/', $val)) {
                    $data['inputerror'][] = 'kd_area[' . $key . ']';
                    $data['error'][] = 'Kode area tidak valid, harus numberic';
                    $data['status'] = false;
                }
            }

            foreach ($_POST['nm_area'] as $key => $val) {
                if ($val == '') {
                    $data['inputerror'][] = 'nm_area[' . $key . ']';
                    $data['error'][] = 'Nama area harus diisi';
                    $data['status'] = false;
                } else if (!preg_match('/^[A-Z ]+$/', strtoupper($val))) {
                    $data['inputerror'][] = 'nm_area[' . $key . ']';
                    $data['error'][] = 'Nama area tidak valid, harus alphabet';
                    $data['status'] = false;
                }
            }
        } else {
            if ($this->input->post('kd_area') == '') {
                $data['inputerror'][] = 'kd_area';
                $data['error'][] = 'Kode area harus diisi';
                $data['status'] = false;
            } else if (!preg_match('/^[0-9]+$/', $this->input->post('kd_area'))) {
                $data['inputerror'][] = 'kd_area';
                $data['error'][] = 'Kode area tidak valid, harus numberic';
                $data['status'] = false;
            }

            if ($this->input->post('nm_area') == '') {
                $data['inputerror'][] = 'kd_area';
                $data['error'][] = 'Kode area harus diisi';
                $data['status'] = false;
            } else if (!preg_match('/^[A-Z ]+$/', strtoupper($this->input->post('nm_area')))) {
                $data['inputerror'][] = 'kd_area';
                $data['error'][] = 'Kode area tidak valid, harus numberic';
                $data['status'] = false;
            }
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function save_area()
    {
        $this->validate_area();

        for ($i = 0; $i < count($_POST['kd_area']); $i++) {
            $batch[] = array(
                'kd_area' => 'ID' . $_POST['kd_area'][$i] . 'a',
                'nm_region' => $this->input->post('nm_region'),
                'nm_area' => strtoupper($_POST['nm_area'][$i])
            );
        }
        $this->db->insert_batch('tbl_area', $batch);
        echo json_encode(['status' => true]);
        exit();
    }

    public function edit_area($id)
    {
        $data = $this->db->get_where('tbl_area', ['kd_area' => $id])->row_array();
        echo json_encode($data);
        exit();
    }

    public function update_area()
    {
        $this->validate_area();

        $id = 'ID' . $this->input->post('kd_area') . 'a';
        $data = array(
            'nm_region' => $this->input->post('nm_region'),
            'nm_area' => $this->input->post('nm_area')
        );

        $data = $this->db->update('tbl_area', $data, ['kd_area' => $id]);
        echo json_encode(['status' => true]);
        exit();
    }

    public function delete_area($id)
    {
        $get_area = $this->db->get_where('tbl_area', ['kd_area' => $id])->row_array();
        $this->db->delete('tbl_area', ['kd_area' => $id]);
        echo "<script type='text/javascript'>alert('Data " . $get_area['nm_area'] . " berhasil terhapus');";
        echo "window.location.href='" . site_url(ucfirst('admin/cabang')) . "';</script>";
    }
    // management area

    // management cabang
    private function validate_cabang()
    {
        $data = array();
        $data['inputerror'] = array();
        $data['error'] = array();
        $data['status'] = true;

        if ($this->input->post('region') == '') {
            $data['inputerror'][] = 'region';
            $data['error'][] = '';
            $data['status'] = false;
        }

        if ($this->input->post('area') == '') {
            $data['inputerror'][] = 'area';
            $data['error'][] = '';
            $data['error'][] = 'Nama area harus diisi';
            $data['status'] = false;
        }

        if (is_array($_POST['kd_cabang'])) {
            foreach ($_POST['kd_cabang'] as $key => $val) {
                if ($val == '') {
                    $data['inputerror'][] = 'kd_cabang[' . $key . ']';
                    $data['error'][] = 'Kode cabang harus diisi';
                    $data['status'] = false;
                } else if (!preg_match('/^[0-9]+$/', $val)) {
                    $data['inputerror'][] = 'kd_cabang[' . $key . ']';
                    $data['error'][] = 'Kode cabang tidak valid, harus numberic';
                    $data['status'] = false;
                }
            }

            foreach ($_POST['nm_cabang'] as $key => $val) {
                if ($val == '') {
                    $data['inputerror'][] = 'nm_cabang[' . $key . ']';
                    $data['error'][] = 'Nama cabang harus diisi';
                    $data['status'] = false;
                } else if (!preg_match('/^[A-Z0-9 ]+$/', strtoupper($val))) {
                    $data['inputerror'][] = 'nm_cabang[' . $key . ']';
                    $data['error'][] = 'Nama cabang tidak valid, harus alphabet';
                    $data['status'] = false;
                }
            }
        } else {
            if ($this->input->post('kd_cabang') == '') {
                $data['inputerror'][] = 'kd_cabang';
                $data['error'][] = 'Kode cabang harus diisi';
                $data['status'] = false;
            } else if (!preg_match('/^[0-9]?$/', $this->input->post('kd_cabang'))) {
                $data['inputerror'][] = 'kd_cabang';
                $data['error'][] = 'Kode cabang tidak valid';
                $data['status'] = false;
            }

            if ($this->input->post('nm_cabang') == '') {
                $data['inputerror'][] = 'nm_cabang';
                $data['error'][] = 'Nama cabang harus diisi';
                $data['status'] = false;
            } else if (!preg_match('/^[A-Z0-9 ]+$/', strtoupper($this->input->post('nm_cabang')))) {
                $data['inputerror'][] = 'nm_cabang';
                $data['error'][] = 'Nama cabang tidak valid, harus huruf kapital';
                $data['status'] = false;
            }
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function edit_cabang($id)
    {
        $data = $this->db->get_where('tbl_cabang', ['kd_cabang' => $id])->row_array();
        echo json_encode($data);
        exit();
    }

    public function save_cabang()
    {
        $this->validate_cabang();

        for ($i = 0; $i < count($_POST['kd_cabang']); $i++) {
            $batch[] = array(
                'kd_cabang' => 'ID' . $_POST['kd_cabang'][$i],
                'nama_cabang' => strtoupper($_POST['nm_cabang'][$i]),
                'area' => 'ID' . $this->input->post('area') . 'a',
                'region' => $this->input->post('region')
            );
        }
        $this->db->insert_batch('tbl_cabang', $batch);
        echo json_encode(['status' => true]);
        exit();
    }

    public function update_cabang()
    {
        $this->validate_cabang();

        $id = 'ID' . $this->input->post('kd_cabang');
        $data = array(
            'region' => $this->input->post('region'),
            'area' => 'ID' . $this->input->post('area') . 'a',
            'nama_cabang' => strtoupper($this->input->post('nm_cabang'))
        );

        $data = $this->db->update('tbl_cabang', $data, ['kd_cabang' => $id]);
        echo json_encode(['status' => true]);
        exit();
    }

    public function delete_cabang($id)
    {
        $get_cabang = $this->db->get_where('tbl_cabang', ['kd_cabang' => $id])->row_array();
        $this->db->delete('tbl_cabang', ['kd_cabang' => $id]);
        echo "<script type='text/javascript'>alert('Data " . $get_cabang['nm_cabang'] . " berhasil terhapus');";
        echo "window.location.href='" . site_url(ucfirst('admin/cabang')) . "';</script>";
    }
    // management cabang

    // function get_cabang()
    // {
    //     $data = $this->db->get('tbl_cabang')->result_array();
    //     echo json_encode($data);
    //     exit;
    // }

    // function add_cabang()
    // {
    //     $isi = array(
    //         'konten' => 'admin/add_cabang'
    //     );

    //     ob_start('ob_gzhandler');
    //     $this->load->view('layout/_header');
    //     $this->load->view('layout/_content', $isi);
    // }

    // function edit_cabang($id)
    // {
    //     $isi = array(
    //         'konten' => 'admin/edit_cabang',
    //         'data' => $this->m_cabang->getData($id)
    //     );

    //     ob_start('ob_gzhandler');
    //     $this->load->view('layout/_header');
    //     $this->load->view('layout/_content', $isi);
    // }

    // function save()
    // {
    //     $id = $this->input->post('id');
    //     $method = $this->input->post('method');

    //     $data = array(
    //         'kd_cabang' => 'ID' . $this->input->post('kd_cabang'),
    //         'nama_cabang' => $this->input->post('nama_cabang'),
    //         'area' => $this->input->post('area'),
    //         'region' => $this->input->post('region')
    //     );

    //     if ($method == 'add') {
    //         $qry = $this->db->get_where('tbl_cabang', ['kd_cabang' => $data['kd_cabang']]);
    //         if ($qry->num_rows() > 0) {
    //             $this->session->set_flashdata('Error', "Data cabang <b>" . $data['kd_cabang'] . "</b> sudah tersedia!");
    //         } else {
    //             $this->db->insert('tbl_cabang', $data);
    //             $this->session->set_flashdata('Info', "Data cabang <b>" . $data['kd_cabang'] . " - " . $data['nama_cabang'] . "</b> berhasil disimpan!");
    //         }
    //     } else {
    //         $this->db->update('tbl_cabang', $data, ['id' => $id]);
    //         $this->session->set_flashdata('Info', "Data cabang <b>" . $data['kd_cabang'] . " - " . $data['nama_cabang'] . "</b> berhasil diubah!");
    //     }
    //     redirect(ucfirst('admin/cabang'));
    // }
}
