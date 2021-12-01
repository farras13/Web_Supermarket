<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('M_basic', 'm');
	}

	public function index()
	{
		$data['cart'] = $this->m->getData('cart', null)->result();
		$this->load->view('cart', $data);
	}

	public function plus($id)
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
		}

		$this->session->set_flashdata('toast', 'success:Barang masuk dalam cart anda');
		redirect('Cart', 'refresh');
	}

	public function min($id)
	{
		$w = array('id' => $id,);
		$old = $this->m->getData('barang', $w)->row();

		$qty = $old->stok + 1;
		$data = array('stok' => $qty,);
		$this->m->upd('barang', $data, $w);

		$cart = $this->m->getData('cart', ['id_barang' => $id])->row();
		if (!empty($cart)) {
			$w = array('id_barang' => $id,);
			$stk = $cart->qty - 1;
			$sb = $cart->subtotal - $old->harga;
			$data = array(
				'qty' => $stk,
				'subtotal' => $sb,
			);
			$this->m->upd('cart', $data, $w);
		}

		$this->session->set_flashdata('toast', 'success:Barang masuk dalam cart anda');
		redirect('Cart', 'refresh');
	}

	public function out()
	{
		$old = $this->m->getData('cart')->result();
		foreach ($old as $o ) {
			$brg = $this->m->getData('barang', ['id' => $o->id_barang])->row();
			$stok = $brg->stok + $o->qty;
			$data = array(
				'stok' => $stok,
			);
			$this->m->upd('barang', $data, ['id' => $o->id_barang]);
			$this->m->del('cart', ['id_cart' => $o->id_cart]);
		}	
		
		$this->session->set_flashdata('toast', 'success:Checkout Berhasil');
		redirect('Cart', 'refresh');
	}

}

/* End of file Cart.php */
