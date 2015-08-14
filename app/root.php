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
class app_root extends app_data  {
    
    public $block;
    
    public function __construct() {
     
      parent::__construct(); 
      
      
      $key = $this->Action();

      $objectData =$this->getData($key);

      $this->Magic($key,$objectData);
      
      $this->toHTML();
        
    }
    
    public function toHTML(){
 
          echo $this->action;
          
          var_dump($this->get_html('object')->_head);
         
          include('./block/html/html.php');
          
          include('./block/html/css.php');
          
          $this->block=new block_html_css();
          $this->block=new block_html_html();
         
 
    }
    
    public function toREST(){
        
        
    }
    
  
}

