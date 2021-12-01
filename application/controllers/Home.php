<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('M_basic', 'm');
	}


	public function index()
	{
		$data['model'] = $this->m->view();
		$data['tb'] = $this->m->getData('barang', null)->num_rows();
		$this->load->view('home', $data);
	}

	public function ins_data()
	{
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'JPEG|jpg|png';
		$config['file_name'] = $this->input->post('kode');

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('inputfile')) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('toast', 'error:Data berhasil di tambahkan');
			redirect('Home');
		} else {
			$data = array(
				'nama_barang' => $this->input->post('barang'),
				'harga' => $this->input->post('harga'),
				'stok' => $this->input->post('stok'),
				'kode' => $this->input->post('kode'),
				'gambar' => $this->upload->data('file_name')
			);
			$this->m->ins('barang', $data);
			$this->session->set_flashdata('toast', 'success:Data berhasil di tambahkan');
			redirect('Home', 'refresh');
		}
	}

	public function beli($id)
	{
		$w = array('id' => $id,);
		$old = $this->m->getData('barang', $w)->row();

		$qty = $old->stok - 1;
		$data = array('stok' => $qty,);
		$this->m->upd('barang', $data, $w);

		$cart = $this->m->getData('cart', ['id_barang' => $id])->row();
		if (!empty($cart)) {
			$w = array('id_barang' => $id,);
			$stk = $cart->qty + 1;
			$sb = $cart->subtotal + $old->harga;
			$data = array(
				'qty' => $stk,
				'subtotal' => $sb,
			);
			$this->m->upd('cart', $data, $w);
		} else {
			$stk = 1;
			$sb = $old->harga;
			$data = array(
				'id_barang' => $id,
				'qty' => $stk,
				'subtotal' => $sb,
			);
			$this->m->ins('cart', $data);
		}

		$this->session->set_flashdata('toast', 'success:Barang masuk dalam cart anda');
		redirect('Home', 'refresh');
	}
}

/* End of file Home.php */
