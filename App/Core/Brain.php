<?php

/**
 * Brain is a feature that
 * 
 */
class App_Core_Brain { 
    
    /*
     * @param array $arguments;
     * 
     */
    
    public $arduinoVersion = '2014.01'; 
    public $arduinoRobotName ='001';
    public $arduinoEmulation=true;
    public $arduinoEngine="001";
    
    

    public function __construct(array $arguments = array()) {
      
      if($arguments['version']=true){  
       echo $this->arduinoVersion;  
      }
        
    }
    
    public static function set(){
        self::$arduinoEngine;
        
        
    }
    
    public function desicion(){
        return "Error";
    }
    
    
    public function objective(){
        
    }
    
    public function will(){
        
        
    }
    
    public function logic(){
        
    }
    
    public function like(){
        
        
        
    }
   
    public function sense(){
        
        
    }
    
    public function knowledge(){
        
        
    }

  
} 