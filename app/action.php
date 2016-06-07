<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ads
 *
 * @author aromerov
 */
class app_action {
    //put your code here
    private $data;
    
    public function __construct(app_data $data, app_redis $cache) {
        $this->data = $data;
        $this->cache = $cache;
        
         $this->data->core->Action();
         if(isset($this->data->core->parameters['set'])){
             
          $string = $this->data->core->parameters['set'];
           
          $data = utf8_decode(urldecode($string));
             
          $dataJSON = json_decode($data,TRUE);
           
          var_dump($dataJSON);
           
           
           echo "<a>EXISTE</a>";
         }
        
        
//        echo "<pre>";
//        echo $this->data->core->curPageUrl('full');
//        echo "</pre>";
      
//         echo "<pre>";
//        echo $this->data->core->Action();
//        echo "</pre>";       

        
        
       $Values = $this->data->helper->getConfigValues($this->cache->set);
        
       echo "<pre>";
       var_dump($Values);
       echo "</pre>";
        //$config = $this->data->helper->getConfig();
        
        //var_dump($config);
        
    }  

    
    
}
