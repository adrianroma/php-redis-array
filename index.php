<?php
/**
 * 
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.arduino.com for more information.
 *
 * @category   Arduino
 * @package    Robot
 * @copyright  Copyright (c) 2014
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

?>
<?php

include '/var/www/arduino_robot/App/Core/Core.php';



$options['varsion']=true;

$engine=new App_Core_Core($options);


echo $engine->error();



//$connection = new Mongo();

$host='127.0.0.1';
$database='profesion';

$port='27017';

$username='adrian';

$password='papa700';


$connecting_string =  sprintf('mongodb://%s:%d/%s', $host, $port,$database);

$connection=  new MongoClient($connecting_string,array('username'=>$username,'password'=>$password));


$dbname = $connection->selectDB('profesion');

$collectionOriginal=$dbname->selectCollection('original');




$cursor= $collectionOriginal->find();


foreach($cursor as $document) {  
 var_dump($document);  
}  


echo "FIND---------------";
echo "</br>";

$search=array('name'=>'adrian romero vargas');

$findCursor= $collectionOriginal->find($search);


foreach ($findCursor as $document){
    
    var_dump($document);
}

echo "Find DBS";

$dbs=$connection->listDbs();

var_dump($dbs);




echo "Other Collection documents";


$collectionRelational=$dbname->selectCollection('relations');


$group=array("group"=>"family");
        
$members = array("members"=>1);

$relations= $collectionRelational->findOne($group,$members);

echo "MEMBERS _________________________________";

echo "<br>";

$result=$relations['members'];

$members=array("_id"=>array('$in'=>$result));

$whoMembers = $collectionOriginal->findOne($members);


var_dump($whoMembers);


echo "-----------------------------------------------------------------";

$collectionBox=$dbname->selectCollection('box');


//$zipCode=array("box"=>array('$in'=>array(42035)));

$zipCode = array("neighborhood"=>new MongoRegex("/^Plu/i"));

//$search = array('$in' =>array(array('neighborhood'=>new MongoRegex("/^A/i"))));

//$meZip = $collectionBox->findOne($zipCode);

$meZip = $collectionBox->find($zipCode);

foreach($meZip as $Zip){
    var_dump($Zip);
}


$redisClient = new Redis();

$redisClient->connect('127.0.0.1');

$redisClient->set('testkey', 1);

echo "SUGGERENCE";
echo "<br>";

echo $redisClient->get('suggerence');
echo "<br>";
echo "TEST..............";

$test[]="jojo";

$test[]="jiji";

var_dump($test);


echo "Var from Redis:".$redisClient->get('testkey');

?>