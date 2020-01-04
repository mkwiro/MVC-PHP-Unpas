<?php
/**
 *ambil data url
 */
class App
{
//property class
  protected $controller ='Home';
  protected $method ='index';
  protected $params = [];

  function __construct()
  {
    $url = $this->parseURL();

//controller
    if (file_exists('../app/controllers/' . $url[0] . '.php')) { //cek apakah filenya ada di folder controller
      $this->controller = $url[0]; //array url [0] dijadikan controller
      unset($url[0]); //unset (kebalikan isset) array url [0]
    }
    require '../app/controllers/' . $this->controller . '.php';
    $this->controller= new $this->controller;

    //method
    //cek method ada gak di url, kalau gak ada ke method default
    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) { //cek didalam controller ada method gak? url[1]
        $this->method=$url[1];//array method di url dimasukkan dalam variable method
        unset($url[1]);
      }
    }

    //Parameter
    if (!empty($url )) {
      $this->params = array_values($url);
    }

//jalankan controller $ method, serta kirimkan parameter jika addslashes
call_user_func_array([$this->controller, $this->method], $this->params);

  }

  public function parseURL()
  {
    if (isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/'); //menghapus tanda / di akhir url
      $url = filter_var($url, FILTER_SANITIZE_URL);//memfilter url dari karakter aneh (hack)
      $url = explode('/', $url); //memecah url yang diinput dengan delimiter / dan menjadikannya array
      return $url;
    }
  }
}


class FPGrowth
{
  public $frequentItem;
  public $minimumSupportCount;
  public $minConfidence;
  public $supportCount;
  public $orderedFrequentItem;
  public $FPTree;

  function __construct()
  {
    $this->frequentItem = array();
    $this->minimumSupportCount = 3;
    $this->minConfidence = 60 * 0.01;
    $this->supportCount 	= array();
    $this->orderedFrequentItem = array();
  }
  public function set($t)
  {
    if(is_array($t))
    {
      $this->frequentItem[] 	= $t;
    }
  }
//get transaksi array
  public function get()
  {
    echo "<pre>";
    var_dump($this->frequentItem);
    // print_r($this->frequentItem);
    echo "</pre>";
  }

public function countSupportCount()
{
    foreach ($this->frequentItem as $key => $value) {
        foreach ($value as $k => $v) {
          if (empty($this->supportCount[$v])) {
            $this->supportCount[$v]=1;
          }else {
            $this->supportCount[$v]= $this->supportCount[$v] +1;
          }
        }
    }

}
public function getSupportCount()
{
  echo "<pre>";
  var_dump($this->supportCount);
  echo "</pre>";
}

public function orderBySupportCount()
{
  ksort($this->supportCount);
  arsort($this->supportCount);
}
public function removeByMinimumSupport($supportCount)
{
  $this->supportCount=[];//construck ini dipecah dijadikan array asosiatif
  foreach ($supportCount as $key => $value) {//supportcount diambil valuenya
    if ($value >= $this->minimumSupportCount) {//supportcount yang valuenya sama dengan minimum support
      $this->supportCount[$key]=$value; //pilih this->supportcount key yang valuenya itu
    }
  }

}

public function orderFrequentItem($frequentItem, $supportCount)
{
  foreach ($frequentItem as $k => $v) {
    $ordered =[];
    foreach ($supportCount as $key => $value) {
      if (isset($v[$key])) { //cek true false yang ada antara frequentitem dan supportcount
        $ordered[$key]=$v[$key];
      }
    }
$this->orderedFrequentItem[$k]=$ordered;
  }
}

public function getOrderedFrequentItem()
{
  echo "<pre>";
  var_dump($this->orderedFrequentItem);
  echo "</pre>";
}

public function buildFPTree($orderedFrequentItem)
{
  $FPTree[] 	= array(
    'item'	=> 'null',
    'count'	=> 0,
    'child'	=> null,
  );
  $FPTree2[] 	= array();
  if(is_array($orderedFrequentItem))
  {
    $i 	= 0;
    foreach ($orderedFrequentItem as $orderedFrequentItemKey => $orderedFrequentItemValue) {
var_dump($FPTree);
var_dump($orderedFrequentItemKey);
var_dump($orderedFrequentItemValue);

      $FPTreeTemp 	= $FPTree[0];
      $FPTreeTempKey 	= array(0);

var_dump($FPTreeTemp);
var_dump($FPTreeTempKey);

      foreach ($orderedFrequentItemValue as $itemKey => $itemValue) {

var_dump($itemKey);
var_dump($itemValue);

        array_push($FPTreeTempKey, $itemValue);

var_dump($FPTreeTempKey);
var_dump(count($FPTreeTempKey));

//switch untuk membuat fp tree dari array multidimensional
//jumlah case dibuat bedasarkan prediksi jumlah banyaknya varian brand yang akan terjadi dalam satu transaksi

        switch ((count($FPTreeTempKey))) {
          case 2:
            if(empty($FPTree[0]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$itemValue] 	= array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$itemValue]['count'] = $FPTree[0]['child'][$itemValue]['count'] + 1;
            }
            break;

          case 3:
            if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue] = array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] + 1;
            }
            break;

          case 4:
            if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue] 	= array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] + 1;
            }
            break;

          case 5:
            if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue] 	= array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] + 1;
            }
            break;

          default:

            break;
        }
      }
    }
  }
  return $FPTree;
}


public function getFPTree()
{
  echo "<pre>";
  print_r($this->FPTree);
  echo "</pre>";
}
}

 ?>
