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

require ('./lib/redis/Autoloader.php');

class app_core {

    public $hash;
    public $action;
    public $isRest;
    public $clearURL;
    public $parameters;
    public $longParameters;
    public $ip;
 
 
        public function __construct($string = '0000000') {
        $keyhash = md5($string);
        $this->hash = $keyhash;
    }

    /*
     * Generate on Fly Methods on PHP
     * 
     * 
     */

    public function __call($method, $args) {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        }
    }
    
    
     /*
     * Get Current Url On Page
     * 
     * @param $type full or short URL
     * 
     */
    
    public function curPageURL($type = '') {
        if ($type == 'full') {
            $pageURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        } else {
            $pageURL = "http://$_SERVER[HTTP_HOST]/";
        }
        return $pageURL;
    }
    
        /*
     * Get TRUE Request and Set Parameters;
     * 
     * 
     */

    public function Action() {

        if ($this->action == '') {
            $urlstring = $_SERVER['REQUEST_URI'];
            if (strpos($urlstring, '?type=rest') !== false) {
                $this->isRest = 1;
            } else {
                $this->isRest = 0;
            }

            if (strpos($urlstring, '?') !== false) {
                $this->clearURL = 0;
                $fullURL = explode('?', $urlstring);
                $urlstring = $fullURL[0];
                $parameterFull = explode('&', $fullURL[1]);
                foreach ($parameterFull as $key => $parameter) {
                    if (strpos($parameter, '=') !== false) {
                        $parameterData = explode('=', $parameter);
                        $this->parameters[$parameterData[0]] = $parameterData[1];
                    } else {
                        $this->longParameter[$key] = $parameter;
                    }
                }
            } else {
                $this->clearURL = 1;
            }

            $urlstring = substr($urlstring, 1);
            
            if ($urlstring == '') {
                echo 'URL: '.$urlstring;
                echo "<br>";
                $urlstring = 'default';
            }
            echo $urlstring;
            echo "<br>";
            $this->action = $urlstring;
            
            if($urlstring=='admin'){
                session_start();
                $_SESSION['user'] = 'default';
                $_SESSION['privilege'] = 'default';
                $_SESSION['area'] = 'default';
                $_SESSION['history'] = 'home,admin';
            }

        } else {
            $urlstring = $this->action;
        }
        

        
        return $urlstring;
    }

    /*
     * Get Current Ip Client
     * 
     * @return string ip adress
     */

    public function getIpClient() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        return $this->ip;
    }

}

