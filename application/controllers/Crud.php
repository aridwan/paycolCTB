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
		$last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('access_point')->row();
		$data = array(
					'id' => $last_row->id+1,
					'merk' => $_POST['merk'],
					'type' => $_POST['tipe'],
					'sn' => $_POST['serial_number'],
					'mac_address' => $_POST['mac_address'],
					'status_ap' => $_POST['status_ap'],
					'paket_ap' => $_POST['drop_from'],
					'location_type' => $_POST['location_type'],
					'customer' => $_POST['customer'],
					'alamat' => $_POST['alamat'],
					'skema_bisnis' => $_POST['skema_bisnis'],
					'ssid' => $_POST['ssid'],
					'posisi_ap' => $_POST['posisi_ap'],
					'tahun_aktif' => $_POST['tahun_aktif'],
					'bulan_aktif' => $_POST['bulan_aktif'],
					'sto' => $_POST['sto'],
					'no_inet' => $_POST['no_inet'],
				);
		$this->db->insert('access_point',$data);
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
					'mk_telp' => $_POST['mk_tlp'],
					'mk_email' => $_POST['mk_email'],
					'tagihan_n' => $_POST['tagihan_n'],
					'tagihan_n1' => $_POST['tagihan_n1'],
					'total_tagihan' => $_POST['total_tagihan'],
					'kategori_visit' => $_POST['kategori_visit'],
					'keterangan' => $_POST['keterangan'],
					'last_update' => $timestamps->format('d-m-Y H:i:s')
				);
		$this->db->update('access_point',$data);
		redirect('auth/index');
	}

	public function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('access_point');
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
