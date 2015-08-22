<?php

/**
 *   PengoStores
 * 
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM8=~==~~~===7MMMMMMMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMO~~~~~~~~~~~~~~~~~~~MMMMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMM=~=~~~~~~~~~~~~~~~~~~~~~~~MMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMM8==~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~MMMMMMMMMM
 *   MMMMMMMMMMMMMM~~~~~~~~~~~~~~~~~~~~~~~~~~~~~=MMMMMM~MMMMMMMMM
 *   MMMMMMMMMMM~~~~~~~~~~~~~~~~~~~~~~~~~===MMMMMMMM=~~~~MMMMMMMM
 *   MMMMMMMMM=~~~~~~~~~~~~~~~~=~+7MMMMMMMMMMM$?M+=~~~~~~=MMMMMMM
 *   MMMMMMM?~~~~~~~~~~=MMMMMMMMMMMMMMMMMM???MD~~~~~~~~~~~=MMMMMM
 *   MMMMMM=~~~~~~~~~=MMMMMMMMMMMMMMMMM???IMM=~~~~~~~~~~~~~MMMMNM
 *   MMMMM=~~~~~~~~~7MMMMMMMMMM,.?MMM??OMMM=~~~~~~~~~~~~~~~+MMMMM
 *   MMMMZ~~~~~~~~~MMMMMMMMMMMMMMMMMMMMMMM~~~~~~~~~~~~~~~~~~MMMMM
 *   MMMM~~~~~~~~~MMMMMMMMMMMMMMMMMMMMMMM~~~~~~~~~~~~~~~~~~~MMMMM
 *   MMMM~~~~~~~=MMMMMMMMMMMMMMMMMMMMMMM~=~~~~~~~~~~~~~~~~~~MMMMM
 *   MMM8~~~~~~~NMMMM++MMMMMMMMMMMMMMMM=~~~~~~~~~~~~~~~~~~~~7MMMM
 *   MMM7~~~~~~~MMM++++=MMMMMMMMMMMMMM=~~~~~~~~~~~~~~~~~~~~~?MMMM
 *   MMMZ~~~~~=MMM?+++==MMMMMMMMMMMMMM~~~~~~~~~~~~~~~~~~~~~~?MMMM
 *   MMMM~~~~~~MM??++====MMMMMMMMMMMMM~~~~~~~~~~~~~~~~~~~~~~$MMMM
 *   MMMM~~~~~MM?+++===~~~MMMMMMMMMMMMM~=~~~~~~~~~~~~~~~~~~~MMMMM
 *   MMMM+~~~~MM?+~.....:~:8MMMMM~...OMM~~~~~~~~~~~~~~~~~~~~MMMMM
 *   DMMMM=~~~M=....... DMN   . ......MMM=~~~~~~~~~~~~~~~~~~MMMMM
 *   MMMMMM~~=MM.....MMMMMMMMN ........MM=~~~~~~~~~~~~~~~~~$MMMMM
 *   MMMMMM7~~MMM...MMMMMMMMMMM~ . . . .MM~~~~~~~~~~~~~~~~=MMMMMM
 *   MMMMMMM7~MMMMMMMMMMMMMMMMMMM. . .   MM=~~~~~~~~~~~~=~MMMMMMM
 *   MMMMMMMMOMMMMMMMMMMMMMMMMMMMM . .   .MM~~~~~~~~~~~~7MMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMM=.......,MM~~~~~~~~~=MMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMM. .    .,MM=~~~~=MMMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMM. .   ...MMM=~=MMMMMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMM..........MMMMMMMMMMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMM.........IMMMMMMMMMMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMM.......MMMMMMMMMMMMMMMMMMMMMMMM
 *   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 * 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the PengoStores License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.pengostores.com/license/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@pengostores.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Edit or add to this file under your own risk.
 * PengoStores will not provide  support to any developed extension
 * which has been modified after its official release.
 *
 * @author Adrian Romero <adrian@pengostores.com>
 * @package  Pengo 
 * @category Pengo_
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * 
 */

class app_data extends app_core {
    
    public $db;
    public $DB;
    public $object;
    public $numeric;
    public $history;
    public $current = array();
    public $methods = array();
    
    public function __construct($string = '0000000') {
        $keyhash = md5($string);
        $this->hash = $keyhash;
        $this->connection();
        $this->getConnection();
    }
    
    //put your code here
    /*
     * Generate A Instance Connection with Redis
     * 
     * In Heroku or Custom Database
     * 
     * @return Object Instance
     * 
     */  

    public function getConnection() {

        Predis\Autoloader::register();

        try {
            if (isset($_ENV['REDISCLOUD_URL'])) {
                $redis = new Predis\Client(array('host' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_HOST), 'port' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PORT), 'password' => parse_url($_ENV['REDISCLOUD_URL'], PHP_URL_PASS)));
                $this->db = $redis;

                $redis->client('setname', 'adrian');
                $this->nameConection = $redis->client('getname');
            } else {

                //$redis = new Predis\Client();
                $redis = new Predis\Client(array(
                            "scheme" => "tcp",
                            "host" => "127.0.0.1",
                            "port" => 6379,
                            "name" => "adrian"));
                $this->db = $redis;

                $redis->client('setname', 'adrian');
                $this->nameConection = $redis->client('getname');
            }
        } catch (Exception $e) {
            echo "<pre>";
            echo $e->getMessage();
            echo "</pre>";
        }
    }
    
    
    public function connection(){
        
        $host='127.0.0.1';
        $database='profesion';
        $port='27017';
        $username='adrian';
        $password='papa700';
        $connecting_string =  sprintf('mongodb://%s:%d/%s', $host, $port,$database);
        $connection=  new MongoClient($connecting_string,array('username'=>$username,'password'=>$password));
        $this->DB = $connection->selectDB('profesion');
  
    }
    
        /*
     * Build a Data array Structure from URL request
     * 
     * 
     * 
     */
    
    public function getData($keyRedis){
                        
              $redis =$this->db;
              $object = array();
              if($redis->exists($keyRedis)){
                $type = $redis->type($keyRedis);
               if($type=='hash'){
                $obj = $redis->hgetall($keyRedis);
                if(is_array($obj)){
                    foreach($obj as $ky=>$ob){
  
                        $kj = $keyRedis.'.'.$ky;         
                        if($redis->exists($kj)){
                            $_type = $redis->type($kj);
                           
                           if($_type=='hash'){ 
                           $sob = $redis->hgetall($kj);
                        foreach($sob as $k=>$sb){
                                $kr = $keyRedis.'.'.$ky.'.'.$k;
                            if($redis->exists($kr)){                             
                                $subObject = $this->getData($kr);
                                $sob[$k] = $subObject;
                            }else{
                                $sob[$k]=$sb;
                            }
                        }  
                        
                            $object[$ky] = $sob;                              
                           }else{
                              $_longList = $redis->llen($kj);
                              
                              $_obj = $redis->lrange($kj,0,$_longList);
                              
                              foreach($_obj as $k=>$sb){
                                  $kr = $keyRedis.'.'.$ky.'.'.$k;
                                 if($redis->exists($kr)){                             
                                 $subObject = $this->getData($kr);
                                 $_obj[$k] = $subObject;
                                 }else{
                                 $_obj[$k]=$sb;
                                 }                                  
                                  
                              }
                            $object[$ky] = $_obj;  
                           }
                            
                        }else{
                            $object[$ky] = $ob;
                        }
                    }
                }  
       
               return $object; 
               }else{
                   
                  $longList = $redis->llen($keyRedis);
                   
                  $obj = $redis->lrange($keyRedis,0,$longList); 
                  
                  foreach($obj as $ky=>$ob){
  
                        $kj = $keyRedis.'.'.$ky;         
                      
                        if($redis->exists($kj)){
                            
                           $_type = $redis->type($kj);
                           
                           if($_type=='hash'){ 
                           $sob = $redis->hgetall($kj);
                        foreach($sob as $k=>$sb){
                                $kr = $keyRedis.'.'.$ky.'.'.$k;
                            if($redis->exists($kr)){                             
                                $subObject = $this->getData($kr);
                                
                                $sob[$k] = $subObject;
                            }else{
                                $sob[$k]=$sb;
                            }
                        }   
                           
                            $object[$ky] = $sob;                              
                           }else{
                              $_longList = $redis->llen($kj);
                              
                              $_obj = $redis->lrange($kj,0,$_longList);
                             
                              foreach($_obj as $k=>$sb){
                                  $kr = $keyRedis.'.'.$ky.'.'.$k;
                                 if($redis->exists($kr)){                             
                                 $subObject = $this->getData($kr);
                                 
                                 $_obj[$k] = $subObject;
                                 }else{
                                 $_obj[$k]=$sb;
                                 }                                  
                                  
                              }
                            $object[$ky] = $_obj;  
                           }
                            
                            
                        }else{                        
                            $object[$ky] = $ob;
                        }
                        
                    }
                   
               return $object;    
               }
              }else{
                 
               return $object;    
              }       
    }
    
    public function Magic($KEY,$object){
                        
                         
                         $String = '(object)[';
      foreach($object as $key=>$values){
           
                            if(is_numeric($key)){
                                
                                 //var_dump($this->history);
                                 $key=$key;
                            }
                           
                             
                            if(!is_array($values)){
                             $_key = $key;
                             //$key ='_'.$key; 
                             
                             $String .='"'.$key.'"=>"'.$values.'",';  
                             $this->methods['get'.$key]='get'.$key;
                             eval('$this->get_'.$key.' = function ($parent="") {  $this->current["'.$key.'"]="'.$KEY.'"; $this->object="'.$values.'"; return "'.$values.'";  };');
                             eval('$this->set_'.$key.' = function(){ $redis = $this->db; echo "'.$KEY.'.'.$key.'";  };');
                            }else{
                          
                             $objectString = $this->Magic($key,$values); 
                             $_key = $key;
                             
                      
                             
                             //$key ='_'.$key;                            
                             $this->methods['get'.$key]='get'.$key; 
                             
                             $objectString = str_replace(array(']"'),array('],"'),$objectString);
                       
                             eval('$this->get_'.$key.' = function ($parent="") {  $this->current["'.$_key.'"]="'.$KEY.'"; $this->object='.$objectString.'; if($parent==""){return $this;}elseif($parent=="object"){ return (object)$this->object;}else{ return (array)'.$objectString.';}};');                              
                             eval('$this->set_'.$key.' = function(){ $redis = $this->db;  echo "'.$KEY.'.'.$key.'";  };');
                             $String .= '"'.$key.'"=>'.$objectString;                              
                             $String  = str_replace(array(",(object)","](object)",']"'),array(",","],",'],"'),$String);                              
                         }
                        
                         
                      }
                      $String .=']'; 
                      $String = str_replace(',]',']',$String);
      
      $this->history=$KEY.'';                
      return $String;
    }
    
    /*
     * Translate languages, Use default english 
     * @param $word string
     * @param $language string
     * @return $translateWord string 
     */
    
    public function translate($word,$language='english'){
        
       $redis = $this->db;
       if($redis->exists('translate:'.$language)){
            $translateWord = $redis->hget('translate:'.$language,$word);
       if($translateWord!=null){
            return $translateWord;
       }else{
            return $word;    
       }
       }else{
            return $word;    
       } 
    }

}

