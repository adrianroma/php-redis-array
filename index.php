<?php 
/*
 * Free Version
 * 
 * 
 */
?>
<?php
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
 ?>
<?php



foreach (glob("./*/*.php") as $filename)
{
    include $filename;
}

$web = new app_root();


echo "hello";


?>

