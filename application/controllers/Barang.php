<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Barang extends CI_Controller
{


	function __construct()
	{
		parent::__construct();

		$this->load->model('m_kategori');
		$this->load->model('m_barang');
		$this->load->library('Excel');
		///$this->load->library('barcode');
	}

	public function index()
	{
		$data['title'] = "Barang";
		$data['data'] = $this->m_barang->tampil_barang();
		$data['kat'] = $this->m_kategori->tampil_kategori();
		$this->load->view('template/header', $data);
		$this->load->view('template/sidebar', $data);
		$this->load->view('template/topbar', $data);
		$this->load->view('barang/index', $data);
		$this->load->view('template/footer', $data);
	}
	public function list_ajax()
	{
		$list = $this->m_barang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->barang_id;
			$row[] = $value->barang_nama;
			$row[] = $value->barang_satuan;
			$row[] = $value->barang_harpok;
			$row[] = $value->barang_harjul;
			$row[] = $value->barang_stok;
			$row[] = $value->barang_min_stok;
			$row[] = $value->kategori_nama;
			$row[] = $value->serial_number;
			$row[] =
				"
                  <div class='row ml-1'>
                <button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal-edit' onclick='get(" . "\"" . $value->id . "\")'>
                <i class='fas fa-edit fa-xs'>Edit</i>
                </button>
                <button type='button' class='btn btn-danger btn-sm' onclick='remove(" . "\"" . $value->id . "\")' >
                    <i class='fas fa-trash fa-xs'>Delete</i>
                </button>
            </div>
                                ";
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->m_barang->count_all(),
			"recordsFiltered" => $this->m_barang->count_filtered(),
		);
		echo json_encode($output);
	}

	function tambah_barang()
	{
		//  Cek jika ada gambar yang ingin di upload
		$upload_image = $_FILES['image']['name'];

		if ($upload_image) {
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max_size']    = 700;
			$config['upload_path'] = './assets/upload/';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$new_image = $this->upload->data('file_name');
				$this->m_barang->tambah_barang($new_image);
			} else {
				$this->session->set_flashdata('msg2', 'Gagal ditambahkan, photo tidak sesuai ketentuan');
				redirect('barang');
			}
		} else {
			$a = '-';
			$this->m_barang->tambah_barang($a);
		}

		$this->session->set_flashdata('msg', 'Berhasil ditambahkan');

		// $this->m_barang->tambah_barang();
		// $this->session->set_flashdata('msg','Berhasil');
		redirect('barang');
	}
	function update()
	{
		$id = $this->input->post('id');
		$data = $this->input->post();
		$res = $this->m_barang->update($id, $data);
		echo json_encode($res);
	}
	function get()
	{
		$id = $this->input->post('id');
		$res = $this->m_barang->get($id);
		echo json_encode($res);
	}
	function remove()
	{
		$id = $this->input->post('id');
		$res = $this->m_barang->remove($id);
		echo json_encode($res);
	}
	public function edit_barang1()
	{
		$id = $this->input->post('id');

		$data = $this->m_barang->GetById($id)->row();

		if ($_FILES and $_FILES['image']['name']) {
			$config['upload_path'] = './assets/upload/';
			$config['allowed_types'] = 'jpeg|png|jpg';
			$config['max_size'] = 700;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('image')) {
				$this->session->set_flashdata('msg2', 'Gagal Edit !!');
				redirect('barang');
			} else {
				unlink('assets/upload/' . $data->image);

				$file = $this->upload->data();
				$id = $this->input->post('id');
				$dataku = array(
					'barang_nama' => $this->input->post('nabar'),
					'barang_satuan' => $this->input->post('satuan'),
					'barang_harpok' => $this->input->post('harpok'),
					'barang_harjul' => $this->input->post('harjul'),
					'barang_stok' => $this->input->post('stok'),
					'barang_min_stok' => $this->input->post('min_stok'),
					'barang_kategori_id' => $this->input->post('kategori'),
					'serial_number' => $this->input->post('sn'),
					'image' => $file['file_name'],
				);

				$this->m_barang->UpdateGambar($id, $dataku);
			}
		} else {
			$id = $this->input->post('id');
			$dataku = array(
				'barang_nama' => $this->input->post('nabar'),
				'barang_satuan' => $this->input->post('satuan'),
				'barang_harpok' => $this->input->post('harpok'),
				'barang_harjul' => $this->input->post('harjul'),
				'barang_stok' => $this->input->post('stok'),
				'barang_min_stok' => $this->input->post('min_stok'),
				'barang_kategori_id' => $this->input->post('kategori'),
				'serial_number' => $this->input->post('sn'),
			);

			$this->m_barang->UpdateGambar($id, $dataku);
		}
		$this->session->set_flashdata('msg', 'Berhasil Edit !!');
		redirect('barang');
	}

	function hapus_barang()
	{

		$id = $this->input->post('barang_id');
		$this->m_barang->hapus_barang($id);
		$this->session->set_flashdata('msg', 'Berhasil');
		redirect('barang');
	}
	public function export()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = [
			'font' => ['bold' => true], // Set font nya jadi bold
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		];

		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = [
			'alignment' => [
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		];

		$sheet->setCellValue('A1', "DATA BARANG"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1

		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B3', "ID BARANG"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C3', "NAMA BARANG"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D3', "SATUAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E3', "HARGA POKOK"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('F3', "HARGA JUAL"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G3', "HARGA JUAL CABANG"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('H3', "BARANG STOK"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('I3', "BARANG MINIMAL STOK"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('J3', "TANGGAL INPUT"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('K3', "TANGGAL UPDATE"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('L3', "ID KATEGORI"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('M3', "SERIAL NUMBER"); // Set kolom E3 dengan tulisan "ALAMAT"

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A3')->applyFromArray($style_col);
		$sheet->getStyle('B3')->applyFromArray($style_col);
		$sheet->getStyle('C3')->applyFromArray($style_col);
		$sheet->getStyle('D3')->applyFromArray($style_col);
		$sheet->getStyle('E3')->applyFromArray($style_col);
		$sheet->getStyle('F3')->applyFromArray($style_col);
		$sheet->getStyle('G3')->applyFromArray($style_col);
		$sheet->getStyle('H3')->applyFromArray($style_col);
		$sheet->getStyle('I3')->applyFromArray($style_col);
		$sheet->getStyle('J3')->applyFromArray($style_col);
		$sheet->getStyle('K3')->applyFromArray($style_col);
		$sheet->getStyle('L3')->applyFromArray($style_col);
		$sheet->getStyle('M3')->applyFromArray($style_col);

		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$dataBarangs = $this->m_barang->getToExcel();

		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($dataBarangs as $data) { // Lakukan looping pada variabel siswa
			$sheet->setCellValue('A' . $numrow, $no);
			$sheet->setCellValue('B' . $numrow, $data->barang_id);
			$sheet->setCellValue('C' . $numrow, $data->barang_nama);
			$sheet->setCellValue('D' . $numrow, $data->barang_satuan);
			$sheet->setCellValue('E' . $numrow, $data->barang_harpok);
			$sheet->setCellValue('F' . $numrow, $data->barang_harjul);
			$sheet->setCellValue('G' . $numrow, $data->barang_harga_cabang);
			$sheet->setCellValue('H' . $numrow, $data->barang_stok);
			$sheet->setCellValue('I' . $numrow, $data->barang_min_stok);
			$sheet->setCellValue('J' . $numrow, $data->barang_tgl_input);
			$sheet->setCellValue('K' . $numrow, $data->barang_tgl_last_update);
			$sheet->setCellValue('L' . $numrow, $data->barang_kategori_id);
			$sheet->setCellValue('M' . $numrow, $data->serial_number);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('M' . $numrow)->applyFromArray($style_row);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(40); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('G')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('H')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('I')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('J')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('K')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('L')->setWidth(20); // Set width kolom E
		$sheet->getColumnDimension('M')->setWidth(20); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);

		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		// Set judul file excel nya
		$sheet->setTitle("DATA BARANG");

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Barang.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}
	public function import()
	{
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 4; $row <= $highestRow; $row++) {
					$barang_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$barang_nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$barang_satuan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$barang_harpok  = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$barang_harjul  = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$barang_harga_cabang  = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$barang_stok  = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$barang_min_stok  = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$barang_tgl_input  = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$barang_tgl_last_update = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$barang_kategori_id = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
					$serial_number  = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
					$temp_data[] = array(
						'barang_id'	=> $barang_id,
						'barang_nama'	=> $barang_nama,
						'barang_satuan'	=> $barang_satuan,
						'barang_harpok'	=> $barang_harpok,
						'barang_harjul'	=> $barang_harjul,
						'barang_harga_cabang'	=> $barang_harga_cabang,
						'barang_stok'	=> $barang_stok,
						'barang_min_stok'	=> $barang_min_stok,
						'barang_tgl_input'	=> $barang_tgl_input,
						'barang_tgl_last_update'	=> $barang_tgl_last_update,
						'barang_kategori_id'	=> $barang_kategori_id,
						'serial_number'	=> $serial_number,
					);
				}
			}
			$insert = $this->m_barang->addImportToExcel($temp_data);
			if ($insert) {
				$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
				redirect($_SERVER['HTTP_REFERER']);
			}
		} else {
			echo "Tidak ada file yang masuk";
		}
	}
	public function deleteAll()
	{
		$delete = $this->m_barang->deleteAll();
		if ($delete) {
			$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-warning"></span> Data Berhasil di Hapus');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			echo "Tidak ada file yang dihapus";
		}
	}
	public function listBarang()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$res = $this->m_barang->listBarang2($start, $end);
		echo json_encode($res);
	}
	public function listBarang_cabang()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$res = $this->m_barang->listBarang_cabang($start, $end);
		echo json_encode($res);
	}
	public function listBarang_pembelian()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$res = $this->m_barang->listBarang_pembelian($start, $end);
		echo json_encode($res);
	}
	function autoBarang()
	{
		if (isset($_GET['term'])) {
			$result = $this->m_barang->autoBarang($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row)
					$arr_result[] = $row->barang_nama;
				echo json_encode($arr_result);
			}
		}
	}
}
