<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('M_basic', 'm');
	}
	

	public function index()
	{
		$data['barang'] = $this->m->getData('barang', null)->result();
		$data['tb'] = $this->m->getData('barang', null)->num_rows();
		$this->load->view('home', $data);
	}

	public function ins_data()
	{
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'JPEG|jpg|png';
		$config['file_name'] = $this->input->post('kode');
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('inputfile')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('toast', 'error:Data berhasil di tambahkan');
			redirect('Home');
		}
		else{
			$data = array(
				'nama_barang' => $this->input->post('barang'),
				'harga' => $this->input->post('harga'),
				'stok' => $this->input->post('stok'),
				'kode' => $this->input->post('kode'),
				'gambar' => $this->upload->data('file_name')
			);
			$this->m->ins('barang', $data);
			$this->session->set_flashdata('toast', 'success:Data berhasil di tambahkan');			
			redirect('Home','refresh');			
		}
		
	}

	public function beli($id)
	{
		
	}

}

/* End of file Home.php */
