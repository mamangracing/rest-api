<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'Libraries/REST_Controller.php';
require APPPATH . 'Libraries/Format.php';


class Mahasiswa extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mahasiswa_model','mahasiswa');
	}

	public function index_get()	
	{
		$id = $this->get('id');
		if ($id=== null) {
			$mahasiswa = $this->mahasiswa->getMahasiswa();
		} else {
			$mahasiswa = $this->mahasiswa->getMahasiswa($id);
		}
		

		if ($mahasiswa) {
			$this->response([
                    'status' => true,
                    'data' => $mahasiswa
                ], REST_Controller::HTTP_OK);
		} else {
			$this->response([
                    'status' => false,
                    'message' => 'id tidak terdaftar'
                ], REST_Controller::HTTP_NOT_FOUND);
		}
	}


	public function index_delete()
	{
		$id = $this->input->get('id');

		if ($id === null) {
			$this->response([
                    'status' => false,
                    'message' => 'provide an id!'
                ], REST_Controller::HTTP_BAD_REQUEST);	
		} else{
			if ($this->mahasiswa->deleteMahasiswa($id) > 0 ) {
				// ok
				$this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'berhasil terhapus'
                ], REST_Controller::HTTP_CREATED);
			} else {
				// id not found
				$this->response([
                    'status' => false,
                    'message' => 'gagal terhapus!'
                ], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}

	public function index_post()
	{
		$data = [
			'nrp' => $this->input->get('nrp'),
			'nama' => $this->input->get('nama'),
			'email' => $this->input->get('email'),
			'jurusan' => $this->input->get('jurusan')
		];

		if ($this->mahasiswa->createMahasiswa($data) > 0){
			$this->response([
                    'status' => true,
                    'message' => 'Berhasil menambah datas'
                ], REST_Controller::HTTP_CREATED);
		} else {
				$this->response([
                    'status' => false,
                    'message' => 'gagal menambah data'
                ], REST_Controller::HTTP_BAD_REQUEST); 
		} 

	}


	public function index_put()
	{
		$id = $this->input->get('id');
		$data = [
			'nrp' => $this->input->get('nrp'),
			'nama' => $this->input->get('nama'),
			'email' => $this->input->get('email'),
			'jurusan' => $this->input->get('jurusan')
		];

		if ($this->mahasiswa->updateMahasiswa($data, $id) > 0){
			$this->response([
                    'status' => true,
                    'message' => 'data mahasiswa berhasil di update'
                ], REST_Controller::HTTP_CREATED);
		} else {
				$this->response([
                    'status' => false,
                    'message' => 'gagal update data'
                ], REST_Controller::HTTP_BAD_REQUEST); 
		}
	}	
}