<?php error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_induk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

	}

	public function simpan()
	{
		$tanggal = $this->input->post("tanggal");
		$noFaktur = $this->input->post("noFaktur");
		$total_debet = $this->cart->total();
		$total_kredit = $this->cart->total_items();
		$data_array = $this->cart->contents();
		foreach ($data_array as $key) {
			$this->db->query("INSERT INTO cart(no,faktur_no,rekening,nama_perkiraan,keterangan_buku_besar,debet,kredit) VALUES('".$key['no']."','".$noFaktur."','".$key['rekening']."','".$key['nama_perkiraan']."','".$key['keterangan_buku_besar']."','".$key['debet']."','".$key['kredit']."')");
		}
		$aquery = $this->db->query('INSERT INTO transaksi_induk(tanggal_transaksi,total_debet,total_kredit,no_faktur) VALUES("'.$tanggal.'","'. $total_debet .'","'.$total_kredit.'","'.$noFaktur.'")');
		if ($aquery) {
			$cb = 'const toast = Swal.mixin({
						toast: true,
						position: "bottom-end",
						showConfirmButton: false,
						timer: 3000
					});

						toast({
						type: "success",
						title: "Data saved in successfully"
					})';
		}else{
			$cb = 'const toast = Swal.mixin({
						toast: true,
						position: "bottom-end",
						showConfirmButton: false,
						timer: 3000
					});

						toast({
						type: "error",
						title: "Data saved in unsuccessfully"
					})';
		}
	}

	// List all your items
	public function index()
	{
		$data['title'] = "Transaksi";
		$data['rekening'] = $this->db->get('ref_rekening')->result();
		$this->load->view('skin/header');
		$this->load->view('skin/navbar');
		$this->load->view('skin/sidebar',$data);
		$this->load->view('transaksi_induk/index',$data);
		$this->load->view('skin/control_sidebar');
		$this->load->view('skin/footer');
	}

	public function view_laporan()
	{
		$data['title'] = "View";
		$data['items'] = $this->db->query('SELECT * FROM transaksi_induk')->result();
		$this->load->view('skin/header');
		$this->load->view('skin/navbar');
		$this->load->view('skin/sidebar',$data);
		$this->load->view('transaksi_induk/view_laporan',$data);
		$this->load->view('skin/control_sidebar');
		$this->load->view('skin/footer');
	}

	// Add a new item
	public function add()
	{
		$noF = $this->input->post('noF');
		$no = $this->input->post('no');
		$rekening = $this->input->post('rekening');
		$nama_perkiraan = $this->input->post('nama_perkiraan');
		$keterangan_buku_besar = $this->input->post('keterangan_buku_besar');
		$debet = $this->input->post('debet');
		$kredit = $this->input->post('kredit');
		$tombol = $this->input->post('tombol');
		
		$data = array(
			'id'      => 'sku_'.$no,
	        'qty'     => '1',
	        'price'   => $debet,
	        'name'    => $nama_perkiraan,
	        'no' => $no,
			'rekening' => $rekening,
			'nama_perkiraan' => $nama_perkiraan,
			'keterangan_buku_besar' => $keterangan_buku_besar,
			'debet' => $debet,
			'kredit' => $kredit
		);
		$this->cart->insert($data);
		echo $this->show_cart();
		// if (isset($tombol)) {
		// 	$this->db->insert('cart', $data);
		// }
	}

	public function show_cart()
	{
		$output = '';
		$array = $this->cart->contents();
        foreach ($array as $items) {
            $output .='
                <tr id="'.$items['rowid'].'">
                    <td>'.$items['no'].'</td>
                    <td>'.$items['rekening'].'</td>
                    <td>'.$items['nama_perkiraan'].'</td>
                    <td>'.$items['keterangan_buku_besar'].'</td>
                    <td>'.number_format($items['debet']).'</td>
                    <td>'.number_format($items['kredit']).'</td>
                    <td><button type="button" id="'.$items['rowid'].'" class="hapus_cart btn btn-danger btn-xs center-block">Hapus</button></td>
                </tr>
            ';
        }
        $output .= '
            <tr>
                <th colspan="4">Total</th>
                <th>'.'Rp '.number_format($this->cart->total()).'</th>
                <th colspan="2">'.'Rp '.number_format($this->cart->total_items()).'</th>
            </tr>
        ';

        return $output;
	}

	//load data cart
	function load_cart(){ 
        echo $this->show_cart();
    }

    public function getitem()
    {
    	$id = $this->input->post('rowid');
    	$array = $this->cart->get_item($id);
	    echo json_encode($array);
    }

    public function getdetail()
    {
    	$output = '';
    	$id = $this->input->post('trid');
    	$query = $this->db->query('SELECT c.no as no,c.faktur_no as no_faktur,c.rekening as rekening,c.nama_perkiraan as nama_perkiraan,c.keterangan_buku_besar as keterangan_buku_besar,c.debet as debet,c.kredit as kredit,t.tanggal_transaksi as tanggal_transaksi,t.total_debet as total_debet,t.total_kredit as total_kredit from cart c LEFT JOIN transaksi_induk t on c.faktur_no = t.no_faktur WHERE c.faktur_no = "'.$id.'"')->result();
		$items = $this->db->query('SELECT * FROM transaksi_induk WHERE no_faktur = "'.$id.'"')->row();
    	$output .= '
	    	<thead>
	        	<tr>
	        		<th>No</th>
	        		<th>Rekening</th>
	        		<th>Nama Perkiraan</th>
	        		<th>Keterangan Buku Besar</th>
	        		<th>Debet</th>
	        		<th>Kredit</th>
	        	</tr>
	        </thead>
        ';
    	foreach ($query as $data) {
            $output .='
                <tbody>
	                <tr id="'.$data->no_faktur.'">
	                    <td>'.$data->no.'</td>
	                    <td>'.$data->rekening.'</td>
	                    <td>'.$data->nama_perkiraan.'</td>
	                    <td>'.$data->keterangan_buku_besar.'</td>
	                    <td>'.number_format($data->debet).'</td>
	                    <td>'.number_format($data->kredit).'</td>
	                </tr>
	            </body>
            ';
        }
        $output .= '
        	<tfoot>
	            <tr>
	                <th colspan="4">Total</th>
	                <th>'.'Rp '.number_format($items->total_kredit).'</th>
	                <th colspan="2">'.'Rp '.number_format($items->total_debet).'</th>
	            </tr>
            </tfoot>
        ';
        echo $output;
        return $output;
    }

	//Update one item
	public function update( $id = NULL )
	{

	}

	public function delete_cart()
	{
		$data = array(
			'rowid' => $this->input->post('row_id'), 
			'qty' => 0, 
		);
		$this->cart->update($data);
		echo $this->show_cart();
	}

	//Delete one item
	public function delete()
	{
		$this->cart->destroy();
		$this->index();
	}
}

/* End of file transaksi_induk.php */
/* Location: ./application/controllers/transaksi_induk.php */
