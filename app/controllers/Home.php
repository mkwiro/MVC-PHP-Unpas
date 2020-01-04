<?php
/**
 *
 */
class Home extends Controller
{
  public function index()
  {
    $data['judul'] ='Home';
    $data['nama'] = $this->model('User_model')->getUser(); //pemanggilan model kemudian instansiasi
    $this->view('template/header', $data); //mengambil header View dengan data judul diatas
    $this->view('home/index', $data);
    $this->view('template/footer');
  }
}



 ?>
