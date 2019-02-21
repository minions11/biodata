<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

	}

	// List all your items
	public function index()
	{
		$data['biodata'] = $this->db->query('SELECT * FROM biodata')->result();
		$this->load->view('tampil',$data);
	}
	public function tambah()
	{
		$this->load->view('v_add');
	}

	// Add a new item
	public function add()
	{
		$config['upload_path']   = './images/';
		$config['allowed_types'] = 'gif|jpg|png';
		
		$this->load->library('upload', $config);
		
		if ( $this->upload->do_upload('foto')){

			$img = $this->upload->data();
			$file_name = $img['file_name'];
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat') ;
			$kelas = $this->input->post('kelas');
			$namasekolah = $this->input->post('namasekolah');
			$data = array(
				'nama' => $nama,
				'alamat' => $alamat,
				'kelas' => $kelas,
				'namasekolah' => $namasekolah,
				'foto' => $file_name
			);
			$this->m_biodata->input_data($data,'biodata');
			redirect('welcome/index');
		}
		

	}
	public function edit($id)
	{
		$where = array('id' => $id);
		$data['biodata'] = $this->db->get_where('biodata',$where)->result();
		$this->load->view('ubah', $data);
	}

	//Update one item
	public function update()
	{
		$id = $this->uri->segment(3);

		$config['upload_path'] = './images/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);
		
		if (! $this->upload->do_upload('foto'))
		{
			echo $this->upload->display_errors();
		}else{
			$id = $this->input->post('id');
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$kelas = $this->input->post('kelas');
			$namasekolah = $this->input->post('namasekolah');
			$img = $this->upload->data();
			$file_name = $img['file_name'];

			$data = array(
				'nama' => $nama,
				'alamat' => $alamat,
				'kelas' => $kelas,
				'namasekolah' => $namasekolah,
				'foto' =>$file_name

			);
			$where = array('id' => $id);
			$this->m_biodata->update_data($where,$data,'biodata');
			redirect();
		}
	
	}

	//Delete one item
	public function delete($id)
	{
		$where = array('id' => $id);
		$this->m_biodata->hapus_data($where,'biodata');
		redirect();
	}
}

/* End of file Welcome.php */
/* Location: ./application/controllers/Welcome.php */
