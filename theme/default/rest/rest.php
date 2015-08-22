<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php

if(isset($this->parameters['search'])){
  $search = $this->parameters['search'];    
}else{
  $search = '';  
}

if(isset($this->parameters['pop'])){
  $pop = $this->parameters['pop'];    
}else{
  $pop = '';  
}


if(isset($this->parameters['push'])){
  $push = $this->parameters['push'];    
}else{
  $push = '';  
}

if(isset($this->parameters['rotate'])){
  $rotate = $this->parameters['rotate'];    
}else{
  $rotate = '';  
}

$DATA = $this->restObject;
header('Content-type: text/javascript');
$json_string = json_encode($DATA, JSON_PRETTY_PRINT);
echo $json_string;


?>