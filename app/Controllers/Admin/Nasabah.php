<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Nasabah_model;

class Nasabah extends BaseController
{

	// mainpage
	public function index()
	{
		checklogin();
		$m_nasabah 			= new Nasabah_model();
		$nasabah 				= $m_nasabah->listing();
		$total 				= $m_nasabah->total();


		// Start validasi
		if($this->request->getMethod() === 'post' && $this->validate(
			[
				'nama' 		=> 'required',
				'gambar'	 	=> [
					                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= str_replace(' ','-',$avatar->getName());
	            $avatar->move(WRITEPATH . '../assets/upload/nasabah/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/nasabah/'.$namabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/nasabah/thumbs/'.$namabaru);
	        	// masuk database
	        	// masuk database
				$data = [	
							
							'nama'			=> $this->request->getPost('nama'),
							'alamat'		=> $this->request->getPost('alamat'),
							'no_wa'		=> $this->request->getPost('telepon'),
							'gambar'		=> $namabaru,
						];
				$m_nasabah->tambah($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/nasabah'));
			}else{
				// masuk database
				$data = [								
					'nama'			=> $this->request->getPost('nama'),
				'alamat'		=> $this->request->getPost('alamat'),
				'no_wa'		=> $this->request->getPost('telepon'),
				'gambar'		=> $namabaru,
						];
				$m_nasabah->tambah($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/nasabah'));
			}
	    }else{
			$data = [	'title'			=> 'Data Staff: '.$total['total'],
						'staff'			=> $nasabah,
						'content'		=> 'admin/nasabah/index'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// edit
	public function edit($id_staff)
	{
		checklogin();
		$m_kategori_staff 	= new Kategori_staff_model();
		$m_nasabah 			= new Staff_model();
		$staff 				= $m_nasabah->detail($id_staff);
		$kategori_staff 	= $m_kategori_staff->listing();

		// Start validasi
		if($this->request->getMethod() === 'post' && $this->validate(
			[
				'nama' 		=> 'required',
				'gambar'	 	=> [
					                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= str_replace(' ','-',$avatar->getName());
	            $avatar->move(WRITEPATH . '../assets/upload/nasabah/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/nasabah/'.$namabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/nasabah/thumbs/'.$namabaru);
	        	// masuk database
	        	// masuk database
				$data = [	'id_staff'		=> $id_staff,
							'id_user'		=> $this->session->get('id_user'),
							'id_kategori_staff'	=> $this->request->getPost('id_kategori_staff'),
							'urutan'	=> $this->request->getPost('urutan'),
							'nama'			=> $this->request->getPost('nama'),
							'jabatan'		=> $this->request->getPost('jabatan'),
							'alamat'		=> $this->request->getPost('alamat'),
							'telepon'		=> $this->request->getPost('telepon'),
							'website'		=> $this->request->getPost('website'),
							'email'			=> $this->request->getPost('email'),
							'keahlian'		=> $this->request->getPost('keahlian'),
							'gambar'		=> $namabaru,
							'status_staff'	=> $this->request->getPost('status_staff'),
							'tempat_lahir'	=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'	=> date('Y-m-d',strtotime($this->request->getPost('tanggal_lahir'))),
						];
				$m_nasabah->edit($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah disimpan');
				return redirect()->to(base_url('admin/nasabah'));
			}else{
				// masuk database
				$data = [	'id_staff'		=> $id_staff,
							'id_user'		=> $this->session->get('id_user'),
						
							'urutan'	=> $this->request->getPost('urutan'),
							'nama'			=> $this->request->getPost('nama'),
							'jabatan'		=> $this->request->getPost('jabatan'),
							'alamat'		=> $this->request->getPost('alamat'),
							'telepon'		=> $this->request->getPost('telepon'),
							'website'		=> $this->request->getPost('website'),
							'email'			=> $this->request->getPost('email'),
							'keahlian'		=> $this->request->getPost('keahlian'),
							// 'gambar'		=> $namabaru,
							'status_staff'	=> $this->request->getPost('status_staff'),
							'tempat_lahir'	=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'	=> date('Y-m-d',strtotime($this->request->getPost('tanggal_lahir'))),
						];
				$m_nasabah->edit($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah disimpan');
				return redirect()->to(base_url('admin/nasabah'));
			}
	    }else{
			$data = [	'title'			=> 'Edit Data Staff: '.$staff['nama'],
						'staff'			=> $staff,
					
						'content'		=> 'admin/nasabah/edit'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// delete
	public function delete($id_nasabah)
	{
		checklogin();
		$m_nasabah = new Nasabah_model();
		$data = ['id_nasabah'	=> $id_nasabah];
		$m_nasabah->delete($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/nasabah'));
	}
}