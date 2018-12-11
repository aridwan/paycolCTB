<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Auth extends CI_Controller {

	public function index(){
		if (isset($_SESSION['username'])){
			if ($_SESSION['username']['role'] == 'Administrator'){
				// $this->session->set_userdata(array('username'=>$username));
				$query = $this->db->query('SELECT * FROM ctb');
				$data['hasil'] = $query->result_array();
				$this->load->view('dashboard',$data);
			} else if ($_SESSION['username']['role'] == "Visitor"){
				$query = $this->db->query('SELECT * FROM ctb WHERE nama_visitor="'.$_SESSION['username']['nama'].'"');
				$data['hasil'] = $query->result_array();
				$this->load->view('dashboard',$data);
			} else {
				$data['error'] = 'Invalid Account';
				$this->load->view('login_page',$data);
			}
		}
		else {
			$this->load->view('login_page');
		}
	}

	public function login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->db->where('username',$username);
		$this->db->where('password',hash('ripemd160', $password));
		$session = $this->db->get('users')->result_array();
		if (isset($session[0])){
			$this->session->set_userdata(array('username'=>$session[0]));
			if ($_SESSION['username']['role'] == 'Administrator'){
				$query = $this->db->query('SELECT * FROM ctb');
				$data['hasil'] = $query->result_array();
				$this->load->view('dashboard',$data);
			} else {
				$query = $this->db->query('SELECT * FROM ctb WHERE nama_visitor="'.$_SESSION['username']['nama'].'"');
				$data['hasil'] = $query->result_array();
				$this->load->view('dashboard',$data);
			}
		} else {
			$data['error'] = 'Invalid Account';
			$this->load->view('login_page',$data);
		}
	}

	public function logout(){
		$this->session->unset_userdata('username');
		redirect('auth');
	}

	public function filtered()
	{
		// print_r($_GET);
		// if($_GET['tanggal']!=""){
			if ($_SESSION['username']['role'] == "Visitor"){
				$query = $this->db->query('SELECT * FROM ctb WHERE nama_visitor= "'.$_SESSION['username']['nama'].'" AND tgl_visit LIKE \'%'.$_GET['tanggal'].'\' AND no_inet LIKE \'%'.$_GET['no_layanan'].'%\' AND prioritas LIKE \'%'.$_GET['prioritas'].'%\'');
				$data['hasil'] = $query->result_array();
				// print_r($data);
				$this->load->view('dashboard',$data);
			} else {
				$query = $this->db->query('SELECT * FROM ctb WHERE tgl_visit LIKE \'%'.$_GET['tanggal'].'\' AND no_inet LIKE \'%'.$_GET['no_layanan'].'%\' AND prioritas LIKE \'%'.$_GET['prioritas'].'%\'');
				$data['hasil'] = $query->result_array();
				// print_r($data);
				$this->load->view('dashboard',$data);
			}
		// } else {
		// 	if ($_SESSION['username']['role'] == 'Administrator'){
		// 		// $this->session->set_userdata(array('username'=>$username));
		// 		$query = $this->db->query('SELECT * FROM ctb');
		// 		$data['hasil'] = $query->result_array();
		// 		$this->load->view('dashboard',$data);
		// 	} else if ($_SESSION['username']['role'] == "Visitor"){
		// 		$query = $this->db->query('SELECT * FROM ctb WHERE nama_visitor="'.$_SESSION['username']['nama'].'"');
		// 		$data['hasil'] = $query->result_array();
		// 		$this->load->view('dashboard',$data);
		// 	}
		// }
	}

	public function change_password(){
		$this->load->view('change_password_page');
	}

	public function update_password(){
		if ($_POST['new_password_repeat'] == $_POST['new_password']){
			$this->db->where('username',$_POST['username']);
			$this->db->where('password',hash('ripemd160', $_POST['old_password']));
			$user = $this->db->get('users')->row_array();
			if (isset($user)){
				$this->db->reset_query();
				$this->db->where('id',$user['id']);
				// print_r($user['password']);
				// echo "<br>";
				// print_r(hash('ripemd160', $_POST['old_password']));
				$data = array(
					'password' => hash('ripemd160', $_POST['new_password'])
				);
				$this->db->update('users',$data);
				redirect('auth');
			} else {
				$data['error'] = 'Username tidak ditemukan atau Password salah';
				$this->load->view('change_password_page',$data);
			}
		} else {
			$data['error'] = 'Ulangi password tidak sama';
			$this->load->view('change_password_page',$data);
		}
	}

	public function ajaxDashboard(){
		$this->load->model('AjaxModel');  
        $fetch_data = $this->AjaxModel->make_datatables($_POST['tanggal'],$_POST['no_layanan'],$_POST['prioritas']);  
        $data = array();  
        foreach($fetch_data as $row)  
        {  
            $sub_array = array();  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->id.'</a>';  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->nama_visitor.'</a>';  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->tgl_visit.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->no_inet.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->no_ref.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->prioritas.'</a>';  
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->alamat.'</a>';
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->customer.'</a>';
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->kelurahan.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->nama_yang_ditemui.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.$row->kategori_visit.'</a>'; 
            $sub_array[] = '<a data-toggle="modal" data-target="#detailModal'.$row->id.'">'.'testing'.'</a>'; 
            $sub_array[] = 	'<a href="'.base_url('index.php/crud/edit/').$row->id.'"><button type="button" name="update" id="'.$row->id.'" class="btn btn-primary btn-sm">Ubah</button></a>'.
            				'&nbsp'.
            				'<button type="button" name="update" id="'.$row->id.'" data-toggle="modal" data-target="#myModal'.$row->id.'"class="btn btn-danger btn-sm">Hapus</button>'.
	            				'<div class="modal fade" id="myModal'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	                        <div class="modal-dialog" role="document">
	                          <div class="modal-content">
	                            <div class="modal-header">
	                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                              <h4 class="modal-title" id="myModalLabel">Peringatan</h4>
	                            </div>
	                            <div class="modal-body">
	                              Apakah anda yakin akan menghapus data tersebut ?
	                            </div>
	                            <div class="modal-footer">
	                              <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
	                              <a href="'.base_url('index.php/crud/delete/'.$row->id).'"><button type="button" class="btn btn-danger">Hapus</button></a>
	                            </div>
	                          </div>
	                        </div>
	                      </div>'.
	                      '<div class="modal fade bs-example-modal-lg" id="detailModal'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Detail Access Point</h4>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Nama Visitor</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->nama_visitor.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Visit</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->tgl_visit.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">No Layanan</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->no_inet.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">No Ref</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->no_ref.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Prioritas</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->prioritas.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->alamat.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Customer</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->customer.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Nomor</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->nomor.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">RT/RW</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->rt_rw.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Kelurahan</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->kelurahan.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Telp</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->mk_tlp.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->mk_email.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Tagihan N</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->tagihan_n.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Tagihan N1</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->tagihan_n1.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Total Tagihan</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->total_tagihan.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Kategori Visit</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->kategori_visit.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Nama yang ditemui</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->nama_yang_ditemui.'
                                </div>
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Keterangan</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->keterangan.'
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-3">
                                  <label for="inputEmail3" class="col-sm-3 control-label">Last Update</label>
                                </div>
                                <div class="col-md-3">
                                  '.$row->last_update.'
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <div class="col-md-12">
                                <img src="'.base_url().$row->foto_path.'">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>';  
            // $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs">Delete</button>';  
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw"              =>     intval($_POST["draw"]),  
            "recordsTotal"      =>      $this->AjaxModel->get_all_data(),  
            "recordsFiltered"   =>     $this->AjaxModel->get_filtered_data($_POST['tanggal'],$_POST['no_layanan'],$_POST['prioritas']),  
            "data"              =>     $data  
        );  
        echo json_encode($output);  
	}

	public function download()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'testing';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');

	}
}
