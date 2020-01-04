<?php

/**
 *
 */
class controller
{

  public function view($view, $data =[])//menangkap method view dan data jika ada yang dikirim dari view
  {
    //memanggil view yang ada didalam folder View
    require '../app/views/' .$view . '.php';
  }

  public function model($model)
  {
    require '../app/models/' .$model . '.php';
    return new $model; //instansiasi model karena dia class
  }
}


 ?>
