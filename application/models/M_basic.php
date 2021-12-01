<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_basic extends CI_Model
{

	public function getData($t, $w = null)
	{
		if ($w != null) {
			$this->db->where($w);
		}

		if ($t == "cart") {
			$this->db->join('barang', 'barang.id = cart.id_barang', 'left');
		}

		return $this->db->get($t);
	}

	public function dataBarang($number, $offset)
	{
		return $this->db->get('barang', $number, $offset);
	}

	public function ins($t, $data)
	{
		$this->db->insert($t, $data);
	}

	public function upd($t, $data, $w)
	{
		$this->db->update($t, $data, $w);
	}

	public function del($t, $w = null)
	{
		$this->db->where($w);
		$this->db->delete($t);
	}

	public function view()
	{
		$this->load->library('pagination'); // Load librari paginationnya

		$query = "SELECT * FROM barang where stok > 0"; // Query untuk menampilkan semua data barang

		$config['base_url'] = base_url('Home/index');
		$config['total_rows'] = $this->db->query($query)->num_rows();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;

		// Style Pagination
		// Agar bisa mengganti stylenya sesuai class2 yg ada di bootstrap
		$config['full_tag_open']   = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';
		$config['full_tag_close']  = '</ul></nav>';

		$config['first_link']      = 'First';
		$config['first_tag_open']  = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';

		$config['last_link']       = 'Last';
		$config['last_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']  = '</span></li>';

		$config['next_link']       = '<span class="page-link">Next</span> ';
		$config['next_tag_open']   = '<li class="page-item">';
		$config['next_tag_close']  = '</li>';

		$config['prev_link']       = ' <span class="page-link">Prev</span> ';
		$config['prev_tag_open']   = '<li class="page-item">';
		$config['prev_tag_close']  = '</li>';

		$config['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close']   = '</a></li>';

		$config['num_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']   = '</span></li>';
		// End style pagination

		$this->pagination->initialize($config); // Set konfigurasi paginationnya

		$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
		$query .= " LIMIT " . $page . ", " . $config['per_page'];

		$data['limit'] = $config['per_page'];
		$data['total_rows'] = $config['total_rows'];
		$data['pagination'] = $this->pagination->create_links(); // Generate link pagination nya sesuai config diatas
		$data['barang'] = $this->db->query($query)->result();

		return $data;
	}
}

/* End of file M_basic.php */
