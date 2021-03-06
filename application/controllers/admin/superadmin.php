<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Superadmin extends MY_Controller{

	public function __construct(){ 
  		parent::__construct();
  		$this->cekLogin();
		$this->load->database();
		$this ->load-> model('m_superadmin');
	}

	public function index(){
		$data['count'] = $this->m_superadmin->jumlah_penghuni()->row();
		$data['isi'] = $this->m_superadmin->jumlah_kamarterisi()->row();
		$data['kamar'] = $this->m_superadmin->jumlah_kamar()->row();
		$data['Lantai'] = $this->m_superadmin->jumlah_berdasarkanlantai()->result();


		$this->load->view('v_topbar2');		
		$this->load->view('v_beranda',$data);
		$this->load->view('v_javascript');
		$this->load->view('v_endbar');   
	}

	public function data_penghuni(){
        $data['data']=$this ->m_superadmin->get_penghuni()->result();
        $data['kamar']=$this ->m_superadmin->get_kamar()->result();


		$this->load->view('v_topbar2');
		$this->load->view('v_data_penghuni',$data);
		$this->load->view('v_javascript');
		$this->load->view('v_data_penghuni_js');
		$this->load->view('v_endbar');

	}

	public function delete_penghuni(){
		$id_penghuni= $this->input->post('id_penghuni');
		$this->m_superadmin->delete_penghuni($id_penghuni);
		echo json_encode($id_penghuni);
	}

	public function delete_kamar(){
		$id_kamar= $this->input->post('id_kamar');
		$this->m_superadmin->delete_kamar($id_kamar);
		echo json_encode($id_kamar);
	}

	public function nokamar(){
		$lantai=$this->input->post('lantai');
 		$nomor = $this->m_superadmin->cari_nomor($lantai)->result(); 
 		echo '<option> Nomor </option>';
 		foreach ($nomor as $r){
		echo '<option value='.$r->no_kamar.'>'.$r->no_kamar.'</option>'; 
 		}
 	}
 	public function nokamar_kosong(){
		$lantai=$this->input->post('lantai');
 		$nomor = $this->m_superadmin->cari_nomor_kosong($lantai)->result(); 
 		echo '<option> Nomor </option>';
 		foreach ($nomor as $r){
		echo '<option value='.$r->no_kamar.'>'.$r->no_kamar.'</option>'; 
 		}
 	}

 	public function data_all_penghuni(){
 		$data=$this->m_superadmin->get_penghuni()->result();
 		echo json_encode($data);
 	}
 	public function lihat_penghuni(){
 		$id=$this->input->get('id');
 		$data=$this->m_superadmin->get_penghuni_by_id($id);
 		echo json_encode($data);
 	}
 	public function lihat_kamar(){
 		$id=$this->input->get('id');
 		$data=$this->m_superadmin->get_kamar_by_id($id);
 		echo json_encode($data);
 	}
 	public function update_penghuni(){
 		$id=$this->input->post('id_penghuni');
 		$lantai=$this->input->post('lantai');
 		$no_kamar=$this->input->post('no_kamar');
 		$query = $this->m_superadmin->cari_id_kamar($lantai,$no_kamar);
 		$data = array(
			'id_kamar' => $query->id_kamar,
			'nama_depan' => $this->input->post('nama_depan'),
			'nama_belakang' => $this->input->post('nama_belakang'),
			'no_ktp' => $this->input->post('no_ktp'),
			'plat_nomor'=>$this->input->post('plat'),
			'alamat'=>$this->input->post('alamat'),
			'no_telp'=>$this->input->post('no_hp'),
			'tempat_lahir'=>$this->input->post('ttl'),
			'tanggal_lahir'=>$this->input->post('tgl'),
		);
		$this->db->where('id_penghuni',$id);
		$this->db->update('tb_penghuni',$data);
 	}

 	public function update_kamar(){
 		$id=$this->input->post('id_kamar');
 		$lantai=$this->input->post('lantai');
 		$no_kamar=$this->input->post('no_kamar');
 		$query = $this->m_superadmin->cari_id_kamar($lantai,$no_kamar);
 		$data = array(
			'id_kamar' => $query->id_kamar,
			'kamar_mandi'=>$this->input->post('kamar_mandi'),
			'luas_kamar'=>$this->input->post('luas_kamar'),
		);
		$this->db->where('id_kamar',$id);
		$this->db->update('tb_kamar',$data);
	}

 		public function tambah_pengeluaran(){
 		$this->load->view('v_topbar2');
 		$this->load->view('v_tambah_pengeluaran');
 		$this->load->view('v_javascript');
 		$this->load->view('v_tambah_pengeluaran_js');
 		$this->load->view('v_endbar');
 	}

 	public function proses_tambah_pengeluaran(){
 		$data = array(
 			'keterangan' =>$this->input->post('keterangan') ,
 			'nominal' =>$this->input->post('nominal'),
 			'tgl_kredit' =>$this->input->post('tgl_kredit')
 		);
 		$this->db->insert('tb_kredit',$data);

 	}
 	public function tambah_pemasukan(){
 		$this->load->view('v_topbar2');
 		$this->load->view('v_tambah_pemasukan');
 		$this->load->view('v_javascript');
 		$this->load->view('v_tambah_pemasukan_js');
 		$this->load->view('v_endbar');
 	}

 	public function proses_tambah_pemasukan(){
 		$data = array(
 			'keterangan' =>$this->input->post('keterangan') ,
 			'nominal' =>$this->input->post('nominal'),
 			'tgl_pemasukan' =>$this->input->post('tgl_pemasukan')
 		);
 		$this->db->insert('tb_pemasukan',$data);
 	}

 	public function tambah_pembayaran(){
 		$data['kamar']=$this ->m_superadmin->get_kamar()->result();

 		$this->load->view('v_topbar2');
 		$this->load->view('v_tambah_pembayaran',$data);
 		$this->load->view('v_javascript');
 		$this->load->view('v_tambah_pembayaran_js');
 		$this->load->view('v_endbar');
 	}
 	public function proses_tambah_pembayaran(){
 		$lantai=$this->input->post('lantai');
 		$no_kamar=$this->input->post('no_kamar');
 		$query = $this->m_superadmin->cari_id_kamar($lantai,$no_kamar);
 		$id_kamar = $query->id_kamar;
 		$tagihan= $this->m_superadmin->cari_id_tagihan($id_kamar);
 		$id_tagihan = $tagihan->id_tagihan;
 		$bulan_awal = $this->input->post('bulan_awal');
 		$bulan_akhir = $this->input->post('bulan_akhir');
 		$bulan = $this->input->post('bulan');
 		$query_nominal_tagihan= $this->m_superadmin->cari_nominal($id_tagihan);
 		$nominal_tagihan= $query_nominal_tagihan->jumlah_tagihan;
 		$jumlah_pembayaran=($nominal_tagihan*$bulan);
 		if($bulan_awal==$bulan_akhir){
 			$keterangan=("Pembayaran kos kamar ".$lantai." No ".$no_kamar." bulan ".$bulan_akhir." ");
 		} else{
 			$keterangan=("Pembayaran kos ".$lantai." No ".$no_kamar." bulan ".$bulan_awal." - ".$bulan_akhir);
 		}
 		$data = array(
 			'id_tagihan' => $id_tagihan ,
 			'keterangan' => $keterangan ,
 			'bulan'	=> $bulan ,
 			'tgl_pembayaran' => $this->input->post('tanggal_pembayaran'),
 			'total_pembayaran' => $jumlah_pembayaran,
 			 );
 		$this->db->insert('tb_pembayaran',$data);
 		$this->m_superadmin->ubah_status_tagihan($id_tagihan,$bulan_akhir);
 	}


 	public function tambah_penghuni(){
 		$lantai=$this->input->post('lantai');
 		$no_kamar=$this->input->post('no_kamar');
 		$query = $this->m_superadmin->cari_id_kamar($lantai,$no_kamar);
 		$data = array(
			'id_kamar' => $query->id_kamar,
			'nama_depan' => $this->input->post('nama_depan'),
			'nama_belakang' => $this->input->post('nama_belakang'),
			'no_ktp' => $this->input->post('no_ktp'),
			'plat_nomor'=>$this->input->post('plat'),
			'alamat'=>$this->input->post('alamat'),
			'no_telp'=>$this->input->post('no_hp'),
			'tempat_lahir'=>$this->input->post('ttl'),
			'tanggal_lahir'=>$this->input->post('tgl'),
		);
		$this->m_superadmin->insert_penghuni($data); // Calling Insert Model and its function.
 	}

 	public function tambah_kamar(){
 		$data = array(
			'no_kamar' => $this->input->post('no_kamar'),
			'lantai' => $this->input->post('lantai'),
			'kamar_mandi' => $this->input->post('kamar_mandi'),
			'luas_kamar' => $this->input->post('luas_kamar')			
		);
		$this->db->insert('tb_kamar',$data);
 	}
	 public function tambah_tagihan(){
		 $no=$this->input->post('no_kamar');
		 $lantai=$this->input->post('lantai');
		 $query = $this->m_superadmin->cari_id_kamar($lantai,$no);
 		 $id_kamar = $query->id_kamar;

		$data = array(
		   'id_kamar' => $id_kamar,
		   'jumlah_tagihan' => $this->input->post('tagihan'),
		   'batas' => $this->input->post('batas'),			
	   );
	   $this->db->insert('tb_tagihan',$data);
	   $this->m_superadmin->ubah_status_kamar($id_kamar);
	}
	public function ubah_status_kamar(){
		$id_kamar=$this->input->post('id');
		$this->m_superadmin->ubah_status_kosong($id_kamar);
		$this->m_superadmin->delete_penghuni_by_kamar($id_kamar);
		$this->m_superadmin->delete_tagihan_by_kamar($id_kamar);
	}
	public function data_kamar(){
		$data['data']=$this ->m_superadmin->get_all_kamar()->result();


		$this->load->view('v_topbar2');
		$this->load->view('v_data_kamar',$data);
		$this->load->view('v_javascript');
		$this->load->view('v_data_kamar_js');
		$this->load->view('v_endbar');

	}

	/*public function data_tagihan(){
		$data['data']=$this ->m_superadmin->get_penghuni()->result();
        $data['kamar']=$this ->m_superadmin->get_kamar()->result();


		$this->load->view('v_topbar2');
		$this->load->view('v_coba_penghuni',$data);
		$this->load->view('v_javascript');
		$this->load->view('v_endbar');
	}*/

	public function data_tagihan(){
		$data['data']=$this->m_superadmin->get_tagihan()->result();
		$data['kamar']=$this->m_superadmin->get_kamar()->result();

		$this->load->view('v_topbar2');
		$this->load->view('v_data_tagihan',$data); 
		$this->load->view('v_javascript');
		$this->load->view('v_data_tagihan_js');
		$this->load->view('v_endbar');
	}

	public function pemasukan(){
		$data['data']=$this->m_superadmin->get_pemasukan()->result();

		$this->load->view('v_topbar2');
		$this->load->view('v_pemasukan',$data);
		$this->load->view('v_javascript');
		$this->load->view('v_endbar');
	}

	public function pembayaran(){
		$data['data']=$this->m_superadmin->get_pembayaran()->result();

		$this->load->view('v_topbar2');
		$this->load->view('v_pembayaran',$data);

		$this->load->view('v_javascript');
		$this->load->view('v_endbar');
	}

	public function pengeluaran(){
		$data['data']=$this->m_superadmin->get_pengeluaran()->result();

		$this->load->view('v_topbar2');
		$this->load->view('v_pengeluaran',$data);
		$this->load->view('v_javascript');
		$this->load->view('v_endbar');
	}
	public function laporan(){
		$data['tahun']=$this->m_superadmin->get_laporan_year()->result();
		$data['data']=$this->m_superadmin->ambil_laporan()->result();

		$this->load->view('v_topbar2');
		$this->load->view('v_laporan',$data);
		$this->load->view('v_javascript');
		$this->load->view('v_laporan_js');
		$this->load->view('v_endbar');

	}
	public function pdf_laporan(){
		$this->load->library('pdf');
		$pdf = new FPDF('l','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Cell(190,7,'SEKOLAH MENENGAH KEJURUSAN NEEGRI 2 LANGSA',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,6,'NIM',1,0);
        $pdf->Cell(85,6,'NAMA MAHASISWA',1,0);
        $pdf->Cell(27,6,'NO HP',1,0);
        $pdf->Cell(25,6,'TANGGAL LHR',1,1);
        $pdf->SetFont('Arial','',10);
        $pdf->Output();
    }

    public function data_user(){
 		$data['data']=$this ->m_superadmin->get_manajemenuser()->result();

 		$this->load->view('v_topbar2');
 		$this->load->view('v_data_user',$data);
 		$this->load->view('v_javascript');
 		$this->load->view('v_tambah_pembayaran_js');
 		$this->load->view('v_endbar');
 	}



// coba insert tapi gagal sek an

 	// public function lihat_user(){
 	// 	$id=$this->input->get('id');
 	// 	$data=$this->m_superadmin->get_user_by_id($id);
 	// 	echo json_encode($data);
 	// }

 // 	public function tambah_user(){
 // 		$level=$this->input->post('level');
 // 		$data = array(
	// 		'id_kamar' => $query->id_kamar,
	// 		'username' => $this->input->post('username'),
	// 		'password' => $this->input->post('password'),
	// 	);
	// 	$this->db->insert('tb_user',$data);
 // 	}
	
	// public function delete_user(){
	// 	$id_user= $this->input->post('id_user');
	// 	$this->m_superadmin->delete_user($id_user);
	// 	echo json_encode($id_user);
	// }



}
?>