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
		$date = new DateTime();

		print_r($_FILES);

		$configImage['image_library'] = 'gd2';
		$configImage['source_image'] = $_FILES['userfile']['tmp_name'];
		$configImage['create_thumb'] = TRUE;
		$configImage['maintain_ratio'] = TRUE;
		$configImage['width']         = 400;
		$configImage['height']       = 300;
		$configImage['new_image']	 = './uploads/';

		$this->load->library('image_lib',$configImage);

		$location_explode = explode('/', $configImage['source_image']);
		$filename = $location_explode[count($location_explode)-1];

		// $this->image_lib->resize();

		
		// $config['upload_path']          = './uploads/';
  //       $config['allowed_types']        = 'jpeg|jpg';
  //       $config['max_size']             = 2000;
  //       $config['max_width']            = 6000;
  //       $config['max_height']           = 4000;
  //       $config['file_name']			= $date->getTimestamp();
  //       $this->load->library('upload', $config);

        if ( ! $this->image_lib->resize())
        {
                $this->db->where('id',$id);
				$data = $this->db->get('ctb')->row_array();
				$data['error'] = array('error' => $this->upload->display_errors());
                $this->load->view('edit_page', $data);
        }
        else
        {
        	$inputFileName = 'uploads/'.$filename.'_thumb';
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
						'mk_tlp' => $_POST['mk_tlp'],
						'mk_email' => $_POST['mk_email'],
						'tagihan_n' => $_POST['tagihan_n'],
						'tagihan_n1' => $_POST['tagihan_n1'],
						'total_tagihan' => $_POST['total_tagihan'],
						'kategori_visit' => $_POST['kategori_visit'],
						'keterangan' => $_POST['keterangan'],
						'nama_yang_ditemui' => $_POST['nama_yang_ditemui'],
						'foto_path'	=> $inputFileName,
						'last_update' => $timestamps->format('d-m-Y H:i:s')
					);
			$this->db->update('ctb',$data);
			redirect('auth/index');
        	
        }		
	}

	public function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('ctb');
		redirect('auth/index');
	}

	function compressImage($source_image, $compress_image) {
		$image_info = getimagesize($source_image);
		if ($image_info['mime'] == 'image/jpeg') {
			$source_image = imagecreatefromjpeg($source_image);
			imagejpeg($source_image, $compress_image, 75);
		} elseif ($image_info['mime'] == 'image/gif') {
			$source_image = imagecreatefromgif($source_image);
			imagegif($source_image, $compress_image, 75);
		} elseif ($image_info['mime'] == 'image/png') {
			$source_image = imagecreatefrompng($source_image);
			imagepng($source_image, $compress_image, 6);
		}
		return $compress_image;
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
