<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Siswa_model;
use App\Models\MarkModel;

class Mark extends BaseController
{

	
	public function index()
	{
		checklogin();		
		$data = [	'title'			=> 'Dashboard Aplikasi',
					'content'		=> 'mark/index'
				];
		echo view('admin/layout/wrapper',$data);
	}
	

	public function saveMark()
    {
        // Handle saving the marked point (x, y), selected shape, and notes
        $x = $this->request->getPost('x');
        $y = $this->request->getPost('y');
        $shape = $this->request->getPost('shape');
        $notes = $this->request->getPost('notes');

        // Save the marked point and related data to your database or storage

        // Return a response indicating success or failure
        $response = [
            'success' => true,
            'message' => 'Mark saved successfully.'
        ];

        return $this->response->setJSON($response);
    }

}