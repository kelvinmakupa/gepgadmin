<?php
class revo{
public $link;
public function __construct()
{
  
 $this->link =  mysqli_connect('localhost', 'gepg_admin', 'g3pga6m1n$@321', 'gepg_admin');
}
 

public function fetch($id, $control_number){
    
    $query = "update tbl_billing set control_number='{$control_number}' where bill_id={$id}";
    $res = mysqli_query($this->link,$query);
    echo $res." - ". $control_number."  \r\n";
   
} 

public function run(){
    $query = "select * from after_balaa";
    $res = mysqli_query($this->link, $query);
     while($data = mysqli_fetch_array($res)){
         $this->fetch($data['bill_id'],$data['control_number']);
        
     }
}

}

$obj = new revo();
$obj->run();



?>
