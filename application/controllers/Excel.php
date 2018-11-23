<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Xlsx;

class Excel extends CI_Controller {

	public function exportToServer()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'testing.xlsx';

		$writer->save($filename);

	}

	public function export()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Visitor');
		$sheet->setCellValue('C1', 'Tanggal Visit');
		$sheet->setCellValue('D1', 'No Inet');
		$sheet->setCellValue('E1', 'No Ref');
		$sheet->setCellValue('F1', 'Prioritas');			
		$sheet->setCellValue('G1', 'Alamat');
		$sheet->setCellValue('H1', 'Nomor');
		$sheet->setCellValue('I1', 'RT/RW');
		$sheet->setCellValue('J1', 'Kelurahan');
		$sheet->setCellValue('K1', 'MK Telp');
		$sheet->setCellValue('L1', 'MK Email');
		$sheet->setCellValue('M1', 'Tagihan N');
		$sheet->setCellValue('N1', 'Tagihan N1');
		$sheet->setCellValue('O1', 'Total Tagihan');
		$sheet->setCellValue('P1', 'Kategori Visit');
		$sheet->setCellValue('Q1', 'Nama Yang Ditemui');
		$sheet->setCellValue('R1', 'Keterangan');
		$sheet->setCellValue('S1', 'Last Update');

		$accessPoints = $this->db->get('ctb')->result_array();
		
		for($i=1;$i<=count($accessPoints);$i++){
			$z=$i+1;

			$sheet->setCellValue('A'.$z,$accessPoints[$i-1]['id']);
			$sheet->setCellValue('B'.$z,$accessPoints[$i-1]['nama_visitor']);
			$sheet->setCellValue('C'.$z,$accessPoints[$i-1]['tgl_visit']);
			$sheet->setCellValue('D'.$z,$accessPoints[$i-1]['no_inet']);
			$sheet->setCellValue('E'.$z,$accessPoints[$i-1]['no_ref']);			
			$sheet->setCellValue('F'.$z,$accessPoints[$i-1]['prioritas']);
			$sheet->setCellValue('G'.$z,$accessPoints[$i-1]['alamat']);
			$sheet->setCellValue('H'.$z,$accessPoints[$i-1]['nomor']);
			$sheet->setCellValue('I'.$z,$accessPoints[$i-1]['rt_rw']);
			$sheet->setCellValue('J'.$z,$accessPoints[$i-1]['kelurahan']);
			$sheet->setCellValue('K'.$z,$accessPoints[$i-1]['mk_tlp']);
			$sheet->setCellValue('L'.$z,$accessPoints[$i-1]['mk_email']);
			$sheet->setCellValue('M'.$z,$accessPoints[$i-1]['tagihan_n']);
			$sheet->setCellValue('N'.$z,$accessPoints[$i-1]['tagihan_n1']);
			$sheet->setCellValue('O'.$z,$accessPoints[$i-1]['total_tagihan']);
			$sheet->setCellValue('P'.$z,$accessPoints[$i-1]['kategori_visit']);
			$sheet->setCellValue('Q'.$z,$accessPoints[$i-1]['nama_yang_ditemui']);
			$sheet->setCellValue('R'.$z,$accessPoints[$i-1]['keterangan']);
			$sheet->setCellValue('S'.$z,$accessPoints[$i-1]['last_update']);

		}
		
		$writer = new Xlsx($spreadsheet);

		$filename = 'Data_ctb_'.date("d-m-Y").'_'.date("h:i:sa");

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output');

	}

	public function importPage(){
		if(isset($_SESSION['username'])){
			$this->load->view('import_page');
		} else {
			$this->load->view('forbidden_page');
		}
	}

	public function upload(){

		$date = new DateTime();


		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'xls|xlsx|csv';
        $config['max_size']             = 2048;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['file_name']			= $date->getTimestamp();
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('import_page', $error);
        }
        else
        {
        	$inputFileType = 'Xlsx';
        	$inputFileName = './uploads/'.$config['file_name'].'.xlsx';

        	$reader = IOFactory::createReader($inputFileType);
        	$reader->setReadDataOnly(true);
        	$spreadsheet = $reader->load($inputFileName);

        	$sheetData = $spreadsheet->getActiveSheet()->toArray(null,true);
        	$shifted = array_shift($sheetData);
        	// print_r($sheetData);
        	// print_r($shifted);
				$last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get('ctb')->row();
				$last_id = 0;
				if(isset($last_row)){
					$last_id = $last_row->id+1;
				} else {
					$last_id = 1;
				}
        		// print_r($last_id);
        	// insert to DB
        		$data_batch = array();
        	for($i=0;$i<count($sheetData);$i++){
				$data_batch[] = array(
							'id' => $last_id,
							'nama_visitor' => $sheetData[$i][1],
							'tgl_visit' => $sheetData[$i][2],
							'no_inet' => $sheetData[$i][3],
							'no_ref' => $sheetData[$i][4],
							'prioritas' => $sheetData[$i][5],
							'alamat' => $sheetData[$i][6],
							'nomor' => $sheetData[$i][7],
							'rt_rw' => $sheetData[$i][8],
							'kelurahan' => $sheetData[$i][9],
							'mk_tlp' => $sheetData[$i][10],
							'mk_email' => $sheetData[$i][11],
							'tagihan_n' => $sheetData[$i][12],
							'tagihan_n1' => $sheetData[$i][13],
							'total_tagihan' => $sheetData[$i][14],
							'kategori_visit' => $sheetData[$i][15],
							'nama_yang_ditemui' => $sheetData[$i][16],
							'keterangan' => $sheetData[$i][17]
						);
				$last_id++;
        	}
        	// print_r($data_batch);
        	$this->db->insert_batch('ctb',$data_batch);
        	redirect('auth');
        }
	}
}
