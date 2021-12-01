<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_basic extends CI_Model {

	public function getData($t, $w = null)
	{
		if ($w != null) {
			$this->db->where($w);
		}

		if ($t == "cart") {
			$this->db->join('barang', 'cart.id_barang = barang.id', 'left');
		}
		
		return $this->db->get($t);
	}

	public function ins($t, $data)
	{
		$this->db->insert($t, $data);
	}

	public function upd($t, $data, $w)
	{
		$this->db->update($t, $data, $w);
	}

	public function del($t, $w)
	{
		$this->db->where($w);
		$this->db->delete($t);
	}

}

/* End of file M_basic.php */
