<?php 
$servername ="MOHAMED-MAMDOUH";
$connectioninfo = array("Database"=>"webProject","UID"=>"ELKAHTEEB","PWD"=>"123456");
$conn = sqlsrv_connect($servername,$connectioninfo);
if(!$conn)
{
    die("connection failed:".sqlsrv_connect_error());
}
?>