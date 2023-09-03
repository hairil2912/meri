<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Dasbor_model;

class Dasbor extends BaseController
{
	public function index()
	{
		checklogin();
		
		$model = new Dasbor_model();
        $tempo = $model->getDataJatuhTempo();


		$data = [	'title'			=> 'Dashboard Aplikasi',
					'tempo'			=> $tempo,
					'content'		=> 'admin/dasbor/index'
				];
		echo view('admin/layout/wrapper',$data);
	}
}