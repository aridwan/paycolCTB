<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Crud extends CI_Controller {

	public function index(){
		
	}

	public function create(){
		if(isset($_SESSION['username'])){
			$this->load->view('create_page');
		} else {
			$this->load->view('forbidden_page');
		}
	}

	public function insert(){
		$last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('ctb')->row();
		$data = array(
					'id' => $last_row->id+1,
					'nama_visitor' => $_POST['nama_visitor'],
					'tgl_visit' => $_POST['tgl_visit'],
					'no_inet' => $_POST['no_inet'],
					'no_ref' => $_POST['no_ref'],
					'prioritas' => $_POST['prioritas'],
					'alamat' => $_POST['alamat'],
					'nomor' => $_POST['nomor'],
					'rt_rw' => $_POST['rt_rw'],
					'kelurahan' => $_POST['kelurahan'],
					'mk_tlp' => $_POST['mk_tlp'],
					'mk_email' => $_POST['mk_email'],
					'tagihan_n' => $_POST['tagihan_n'],
					'tagihan_n1' => $_POST['tagihan_n1'],
					'total_tagihan' => $_POST['total_tagihan'],
					'kategori_visit' => $_POST['kategori_visit'],
					'keterangan' => $_POST['keterangan'],
					'nama_yang_ditemui' => $_POST['nama_yang_ditemui'],
				);
		$this->db->insert('ctb',$data);
		redirect('auth/index');
	}

	public function edit($id){
		if(isset($_SESSION['username'])){
			$this->db->where('id',$id);
			$data = $this->db->get('ctb')->row();
			$this->load->view('edit_page',$data);
		} else {
			$this->load->view('forbidden_page');
		}
	}

	public function update($id){
		$this->db->where('id',$id);
		$timestamps = new DateTime();
		print_r($_POST);
		$data = array(
					'nama_visitor' => $_POST['nama_visitor'],
					'tgl_visit' => $_POST['tgl_visit'],
					'no_inet' => $_POST['no_inet'],
					'no_ref' => $_POST['no_ref'],
					'prioritas' => $_POST['prioritas'],
					'alamat' => $_POST['alamat'],
					'nomor' => $_POST['nomor'],
					'rt_rw' => $_POST['rt_rw'],
					'kelurahan' => $_POST['kelurahan'],
					'mk_tlp' => $_POST['mk_tlp'],
					'mk_email' => $_POST['mk_email'],
					'tagihan_n' => $_POST['tagihan_n'],
					'tagihan_n1' => $_POST['tagihan_n1'],
					'total_tagihan' => $_POST['total_tagihan'],
					'kategori_visit' => $_POST['kategori_visit'],
					'keterangan' => $_POST['keterangan'],
					'nama_yang_ditemui' => $_POST['nama_yang_ditemui'],
					'last_update' => $timestamps->format('d-m-Y H:i:s')
				);
		$this->db->update('ctb',$data);
		redirect('auth/index');
	}

	public function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('ctb');
		redirect('auth/index');
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
