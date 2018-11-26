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
