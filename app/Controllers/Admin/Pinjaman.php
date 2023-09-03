<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Pinjaman_model;
use App\Models\Nasabah_model;
use App\Models\User_model;
use App\Models\CicilanModel;
use Dompdf\Dompdf;
use GuzzleHttp\Client;


class Pinjaman extends BaseController
{

	public function buatpdf()
    {
        $dompdf = new Dompdf();
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Kuitansi Pinjaman</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .table th, .table td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                }
                .name {
                    text-align: right;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Kuitansi Pinjaman</h1>
                <p>Jumlah Pinjaman: Rp 2.000.000</p>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah Cicilan</th>
                    </tr>
                </thead>
                <tbody>';

        $totalCicilan = 10;
        $cicilanPerBulan = 260000;
        
        for ($bulan = 1; $bulan <= $totalCicilan; $bulan++) {
            $html .= '<tr>';
            $html .= '<td>' . $bulan . '</td>';
            $html .= '<td>Rp ' . number_format($cicilanPerBulan, 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }

        $html .= '
                </tbody>
            </table>
            
            <p class="name">Nama Peminjam: [Nama Peminjam]</p>
        </body>
        </html>';

        // Generate PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();

        $client = new Client();

        $response = $client->request('POST', 'http://103.150.191.56:3000/send/file', [
            'headers' => [
                'Authorization' => 'Basic bmltZGE6bmltZGExMjM=',
            ],
            'multipart' => [
                [
                    'name' => 'phone',
                    'contents' => '6282349782444@s.whatsapp.net',
                ],
                [
                    'name' => 'caption',
                    'contents' => 'tes ya',
                ],
                [
                    'name' => 'file',
                    'contents' => $pdfContent,
                    'filename' => 'sample.pdf',
                ],
            ],
        ]);

        $responseBody = $response->getBody()->getContents();

        return $responseBody;
    }
	
	public function kirimfile()
    {
        $client = new Client();

        $response = $client->request('POST', 'http://103.150.191.56:3000/send/file', [
            'headers' => [
                'Authorization' => 'Basic bmltZGE6bmltZGExMjM=',
            ],
            'multipart' => [
                [
                    'name' => 'phone',
                    'contents' => '6282349782444@s.whatsapp.net',
                ],
                [
                    'name' => 'caption',
                    'contents' => 'tes ya',
                ],
                [
                    'name' => 'file',
                    'contents' => fopen('path/to/sample.pdf', 'r'),
                    'filename' => 'sample.pdf',
                ],
            ],
        ]);

        $responseBody = $response->getBody()->getContents();

        return $responseBody;
    }



	// index
	public function index()
	{
		checklogin();
		$m_pinjaman 		= new Pinjaman_model();
		$m_nasabah 	= new Nasabah_model();
		$pinjaman 		= $m_pinjaman->listing();
		$total 			= $m_pinjaman->total();



		$data = [	'title'			=> 'Total Pinjaman  ('.$total.')',
					'pinjaman'		=> $pinjaman,
					'content'		=> 'admin/pinjaman/index'
				];
 
		echo view('admin/layout/wrapper',$data);
	}





	public function kirim($id_pinjaman)
    {

		checklogin();
		$m_pinjaman = new Pinjaman_model();
		$pinjaman = $m_pinjaman->wa($id_pinjaman);



		$message = '';

		$message = "Assamualaikum " . $pinjaman[0]['nama'] ."\n";
		$message .= "Ini Adalah Pesan Whatsapp Otomatis oleh CRK \n\n";
		$message .= "Berikut Rincian Transaksi Pinjaman yang disepakati \n\n";
		$message .= "Nama Nasabah: *" . $pinjaman[0]['nama'] . "*\n";
		$message .= "Tanggal Transaksi: *" . tanggal_bulan($pinjaman[0]['tgl_pinjaman']) . "*\n";
		$message .= "Total Pinjam: " . angka($pinjaman[0]['totalpinjam']) . "\n";
		$message .= "Angsuran Bulanan: " . angka($pinjaman[0]['angsuran_bulanan']) . "\n";
		$message .= "Jangka Waktu: " . $pinjaman[0]['bulan'] . " Bulan\n";
		$message .= "Note : Limit Pembayaran akan jatuh Tanggal 10 setiap Bulan  \n\n";
		$message .= "Terima kasih  \n";
		$message .= "Mohon untuk tidak membalas pesan ini \n";
		$message .= "Ttd CRK Pinjaman \n";


		$no_wa = $pinjaman[0]['no_wa'];
		if (substr($no_wa, 0, 1) === '0') {
			// Jika dimulai dengan "0", tambahkan "62"
			$no_wa = '62' . substr($no_wa, 1);
		}

		$postData = array(
			'phone' =>  $no_wa .'@s.whatsapp.net',
			'message' => $message
		);


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wa.crk.my.id/send/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic bmltZGE6bmltZGExMjM='
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

       
			
		$responseData = json_decode($response, true);

		if ($responseData && isset($responseData['code'])) {
			if ($responseData['code'] === 'SUCCESS') {
				$this->session->setFlashdata('sukses', 'Berhasil kirim Whatsapp');
				return redirect()->to(base_url('admin/pinjaman'));
			} else {
				$this->session->setFlashdata('warning', 'Gagal kirim Whatsapp');
				return redirect()->to(base_url('admin/pinjaman'));
			}
		}
	}

// Controller cronkirimwa
public function cronkirimwa()
{
    checklogin();
    $transaksiModel = new Pinjaman_model();
    $transaksiData = $transaksiModel->getDataJatuhTempo(); // Mengambil data dari model

	
    foreach ($transaksiData as $data) {
        $this->kirimwa($data); // Memanggil fungsi kirimwa untuk mengirim pesan dengan data yang sesuai
        sleep(20); // Delay 5 detik sebelum pengiriman pesan berikutnya
		// print_r($data);
	}
	// die;
}

// Controller kirimwa
public function kirimwa($data)
{
    checklogin();


	$message = "Halo *" . $data['nama'] . "*\n"
	. "Cicilan Anda sebesar " . angka($data['angsuran_perbulan']) . "\n"
	. "Jatuh tempo pada tanggal " . $data['j_tempo'];
	

    $no_wa = $data['no_wa'];
    if (substr($no_wa, 0, 1) === '0') {
        // Jika dimulai dengan "0", tambahkan "62"
        $no_wa = '62' . substr($no_wa, 1);
    }

    $postData = array(
        'phone' => $no_wa . '@s.whatsapp.net',
        'message' => $message
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://wa.crk.my.id/send/message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($postData),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic bmltZGE6bmltZGExMjM='
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $responseData = json_decode($response, true);
}


	


	public function rincian()
	{
		checklogin();
		$transaksiModel = new Pinjaman_model();
        $transaksiData = $transaksiModel->getTransaksi();



		$data = [	'title'			=> 'Rincian Transaksi',
					'transaksiData' => $transaksiData,
					'content'		=> 'admin/pinjaman/rincian'
				];

		echo view('admin/layout/wrapper',$data);
	}


	public function datatables()
    {
		$transaksiModel = new Pinjaman_model();

        $builder = $transaksiModel->getTransaksi();
        $data = $builder->get()->getResult();

        $response = [];
        foreach ($data as $row) {
            $response[] = [
                'id_pinjaman' => $row->id_pinjaman,
                'tgl_transaksi' => $row->tgl_transaksi,
                'nama' => $row->nama,
                'jenis_transaksi' => $row->jenis_transaksi,
                'masuk' => $row->masuk,
                'keluar' => $row->keluar
            ];
        }

        return $this->response->setJSON(['data' => $response]);
    }


		// detail
		public function detail($id_pinjaman)
		{  
			checklogin();
			$m_pinjaman 		= new Pinjaman_model();
			$m_nasabah 	= new Nasabah_model();
			$pinjaman 		= $m_pinjaman->detail($id_pinjaman);
			$detail 		= $m_pinjaman->detail_nasabah($id_pinjaman);
			$total 			= $m_pinjaman->total();
	
	
	
			$data = [	'title'			=> 'Angsuran Detail  ('.$m_pinjaman->detail_nasabah($id_pinjaman)['nama'].')',
						'pinjaman'		=> $pinjaman,
						'detail'		=> $detail,
						'content'		=> 'admin/pinjaman/detail'
					];
			echo view('admin/layout/wrapper',$data);
		}



	
	public function update_cicilan(){ 
		$model = new CicilanModel();
	
		$idCicilan = $this->request->getPost('id_pinjaman');
		$idPinjamanDetail = $this->request->getPost('id_pinjaman_detail');
		$nilBayar = $this->request->getPost('nil_bayar');
		$status = $this->request->getPost('status');
		$tglbayar = $this->request->getPost('tgl_bayar');
	
		$avatarFile = $this->request->getFile('gambar');
	
		if ($avatarFile->isValid() && !$avatarFile->hasMoved()) { // Periksa apakah file gambar valid
			// Image upload
			$namabaru = str_replace(' ', '-', $avatarFile->getName());
			$avatarFile->move(WRITEPATH . '../assets/upload/image/', $namabaru);
			// Create thumb
			$image = \Config\Services::image()
				->withFile(WRITEPATH . '../assets/upload/image/' . $namabaru)
				->fit(100, 100, 'center')
				->save(WRITEPATH . '../assets/upload/image/thumbs/' . $namabaru);
			
			// masuk database
			$data = [
				'nil_bayar' => $nilBayar,
				'status' => $status,
				'bukti' => $namabaru,
				'tgl_bayar' => $tglbayar
			];
			$model->update($idPinjamanDetail, $data);
		} else {
			$data = [
				'nil_bayar' => $nilBayar,
				'tgl_bayar' => $tglbayar,
				'status' => $status
				
			];
			$model->update($idPinjamanDetail, $data);
		}
	
		$this->session->setFlashdata('sukses', 'Data telah diedit');
		return redirect()->to(base_url('admin/pinjaman/detail/' . $idCicilan));
	}


	// Tambah
	public function tambah()
	{
		checklogin();
		$m_nasabah 	= new Nasabah_model();
		$m_pinjaman 		= new Pinjaman_model();
		$nasabah 		= $m_nasabah->listing();

		
		// Start validasi
		if($this->request->getMethod() === 'post' && $this->validate(
			[
				'judul_berita' 	=> 'required',
				'gambar'	 	=> [
					                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= str_replace(' ','-',$avatar->getName());
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
			
	        	$data = array(
	        		'id_user'		=> $this->session->get('id_user'),
	        		'tgl_pinjaman'		=> date('Y-m-d',strtotime($this->request->getVar('tgl_pinjaman'))),
					'id_nasabah'	=> $this->request->getVar('id_nasabah'),
					'judul_berita'	=> $this->request->getVar('judul_berita'),
					'ringkasan'		=> $this->request->getVar('ringkasan'),
					'pinjaman'	=> $this->request->getVar('pinjaman'),
					'persen'	=> $this->request->getVar('persen'),
					'bulan'		=> $this->request->getVar('bulan'),
					'bukti1' 		=> $namabaru,
					'tanggal'			=> $this->request->getVar('tanggal'),
					'angsuran_pokok'			=> $this->request->getVar('pokok'),
					'angsuran_bunga'			=> $this->request->getVar('bunga'),
					'totalpinjam' => $this->request->getVar('totalpinjam'),
					'totalbunga' => $this->request->getVar('totalbunga'),
					'pembulatan' => $this->request->getVar('pembulatan'),
					'angsuran_bulanan' => $this->request->getVar('angsuran_bulanan'),
					'angsuran_nonbunga' => $this->request->getVar('angsuran_tanpabulat'),
				);
	        	$m_pinjaman->tambah($data);

	 // Mengisi tabel t_pinjaman_detail
	 $pinjamanId = $m_pinjaman->insertID(); // Ambil ID pinjaman yang baru saja disimpan

	 $pinjaman = $this->request->getVar('pinjaman');
	 $persen = $this->request->getVar('persen');
	 $bulan = $this->request->getVar('bulan');
	 $tanggal = $this->request->getVar('tanggal');
	 $bulanSekarang = date('Y-m-d', strtotime($this->request->getVar('tgl_pinjaman')));
	 $bungaBulanan = ($pinjaman * ($persen / 100) / 12);
	 $pokokBulanan = ($pinjaman / $bulan);
	 
	 for ($i = 0; $i < $bulan; $i++) {
		 $bulanBerjalan = $i + 1;
		 
		 // Tambahkan bulan berjalan ke tanggal pinjaman
		 $j_tempo = date('Y-m-'.$tanggal, strtotime($bulanSekarang . ' +' . $bulanBerjalan . ' months'));
		 
		 $detailData = array(
			 'id_pinjaman'   => $pinjamanId,
			 'bulan'         => $bulanBerjalan,
			 'bunga'         => $bungaBulanan,
			 'nil_pokok'     => $pokokBulanan,
			 'angsuran_perbulan'     => $this->request->getVar('angsuran_tanpabulat'),
			 'pembulatan_angsuran'     => $this->request->getVar('pembulatan'),
			 'angsuranbulat'  => $this->request->getVar('angsuran_bulanan'),
			 'status'        => 'Belum Bayar',
			 'nil_bayar'     => 0,
			 'j_tempo'       => $j_tempo,
		 );
	 

	
			$m_pinjaman->tambahdetail($detailData);
		}

	        	return redirect()->to(base_url('admin/pinjaman/index/'))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
				
	        	$data = array(
	        		'id_user'		=> $this->session->get('id_user'),
					'id_nasabah'	=> $this->request->getVar('id_nasabah'),
	        		'tgl_pinjaman'		=> date('Y-m-d',strtotime($this->request->getVar('tgl_pinjaman'))),
					'bukti1' 		=> $namabaru,
					'judul_berita'	=> $this->request->getVar('judul_berita'),
					'ringkasan'		=> $this->request->getVar('ringkasan'),
					'pinjaman'	=> $this->request->getVar('pinjaman'),
					'persen'	=> $this->request->getVar('persen'),
					'bulan'		=> $this->request->getVar('bulan'),
					'tanggal'			=> $this->request->getVar('tanggal'),
					'angsuran_pokok'			=> $this->request->getVar('pokok'),
					'angsuran_bunga'			=> $this->request->getVar('bunga'),
					'totalpinjam' => $this->request->getVar('totalpinjam'),
					'totalbunga' => $this->request->getVar('totalbunga'),
					'pembulatan' => $this->request->getVar('pembulatan'),
					'angsuran_bulanan' => $this->request->getVar('angsuran_bulanan'),
					'angsuran_nonbunga' => $this->request->getVar('angsuran_tanpabulat'),
				);
	        	$m_pinjaman->tambah($data);

			 // Mengisi tabel t_pinjaman_detail
			 $pinjamanId = $m_pinjaman->insertID(); // Ambil ID pinjaman yang baru saja disimpan

			 $pinjaman = $this->request->getVar('pinjaman');
			 $persen = $this->request->getVar('persen');
			 $bulan = $this->request->getVar('bulan');
			 $tanggal = $this->request->getVar('tanggal');
			 $bulanSekarang = date('Y-m-d', strtotime($this->request->getVar('tgl_pinjaman')));
			 $bungaBulanan = ($pinjaman * ($persen / 100) / 12);
			 $pokokBulanan = ($pinjaman / $bulan);
			 
			 for ($i = 0; $i < $bulan; $i++) {
				 $bulanBerjalan = $i + 1;
				 
				 // Tambahkan bulan berjalan ke tanggal pinjaman
				 $j_tempo = date('Y-m-'.$tanggal, strtotime($bulanSekarang . ' +' . $bulanBerjalan . ' months'));
				 
				 $detailData = array(
					 'id_pinjaman'   => $pinjamanId,
					 'bulan'         => $bulanBerjalan,
					 'bunga'         => $bungaBulanan,
					 'nil_pokok'     => $pokokBulanan,
					 'angsuran_perbulan'     => $this->request->getVar('angsuran_tanpabulat'),
					 'pembulatan_angsuran'     => $this->request->getVar('pembulatan'),
					 'angsuranbulat'  => $this->request->getVar('angsuran_bulanan'),
					 'status'        => 'Belum Bayar',
					 'nil_bayar'     => 0,
					 'j_tempo'       => $j_tempo,
				 );
			 
	 
			
					$m_pinjaman->tambahdetail($detailData);
				}

	        	return redirect()->to(base_url('admin/pinjaman/index/'))->with('sukses', 'Data Berhasil di Simpan');	        }
	    }


		$data = [	'title'			=> 'Tambah Pinjaman',
					'nasabah'		=> $nasabah,
					'content'		=> 'admin/pinjaman/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}



	// edit
	public function edit($id_berita)
	{
		checklogin();
		$m_nasabah 	= new Nasabah_model();
		$m_pinjaman 		= new Pinjaman_model();
		$kategori 		= $m_nasabah->listing();
		$berita 		= $m_pinjaman->detail($id_berita);
		// Start validasi
		if($this->request->getMethod() === 'post' && $this->validate(
			[
				'judul_berita' 	=> 'required',
				'gambar'	 	=> [
					                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= str_replace(' ','-',$avatar->getName());
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
	        	$data = array(
	        		'id_berita'		=> $id_berita,
	        		'id_user'		=> $this->session->get('id_user'),
					'id_kategori'	=> $this->request->getVar('id_kategori'),
					'slug_berita'	=> strtolower(url_title($this->request->getVar('judul_berita'))),
					'judul_berita'	=> $this->request->getVar('judul_berita'),
					'ringkasan'		=> $this->request->getVar('ringkasan'),
					'isi'			=> $this->request->getVar('isi'),
					'status_berita'	=> $this->request->getVar('status_berita'),
					'jenis_berita'	=> $this->request->getVar('jenis_berita'),
					'keywords'		=> $this->request->getVar('keywords'),
					'icon'			=> $this->request->getVar('icon'),
					'gambar' 		=> $namabaru,
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_pinjaman->edit($data);
       		 	return redirect()->to(base_url('admin/pinjaman/jenis_berita/'.$this->request->getVar('jenis_berita')))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
	        	$data = array(
	        		'id_berita'		=> $id_berita,
	        		'id_user'		=> $this->session->get('id_user'),
					'id_kategori'	=> $this->request->getVar('id_kategori'),
					'slug_berita'	=> strtolower(url_title($this->request->getVar('judul_berita'))),
					'judul_berita'	=> $this->request->getVar('judul_berita'),
					'ringkasan'		=> $this->request->getVar('ringkasan'),
					'isi'			=> $this->request->getVar('isi'),
					'status_berita'	=> $this->request->getVar('status_berita'),
					'jenis_berita'	=> $this->request->getVar('jenis_berita'),
					'keywords'		=> $this->request->getVar('keywords'),
					'icon'			=> $this->request->getVar('icon'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_pinjaman->edit($data);
       		 	return redirect()->to(base_url('admin/pinjaman/jenis_berita/'.$this->request->getVar('jenis_berita')))->with('sukses', 'Data Berhasil di Simpan');
	        }
	    }

		$data = [	'title'			=> 'Edit Berita: '.$berita['judul_berita'],
					'kategori'		=> $kategori,
					'berita'		=> $berita,
					'content'		=> 'admin/pinjaman/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}
	
	// Delete
	public function delete($id_berita)
	{
		checklogin();
		$m_pinjaman = new Pinjaman_model();
		$data = ['id_berita'	=> $id_berita];
		$m_pinjaman->delete($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/pinjaman'));
	}
}