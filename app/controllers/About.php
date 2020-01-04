<?php
/**
 *
 */
class About extends Controller
{
  public function index($nama="M K Wiro", $pekerjaan="Mahasiswa") //defaultnya disini
  {
    //memanggil view yang ada di about/index $data diisi dengan array yang dikirim diatas
    $data['nama']=$nama;
    $data['pekerjaan']=$pekerjaan;
    $data['judul']='About Me';
    $this->view('template/header', $data);//mengambil header View dengan data judul diatas
    $this->view('about/index', $data); //$data menangkap data yang dikirim
    $this->view('template/footer');//mengambil footer view
  }
  public function page()
  {
    //memanggil view yang ada di about/index
    $data['judul'] = 'Pages';
    $this->view('template/header', $data);
    $this->view('about/page');
    $this->view('template/footer');
  }
}


 ?>
