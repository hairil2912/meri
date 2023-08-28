<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Pinjaman_model;
use App\Models\Nasabah_model;
use App\Models\User_model;
use App\Models\CicilanModel;

class Pinjaman extends BaseController
{
	
	



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