<?php
$dsn="mysql:host=localhost;dbname=project"; 
     $user="root"; 
     $pass="";
     $option=array(
                 PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                 );
 
   $con = new PDO($dsn,$user,$pass,$option);
   $con->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
   $stmt=$con->prepare("use project");
   $stmt->execute();
       

   $requestPayload = file_get_contents("php://input");
   $objs = json_decode($requestPayload, true);
   for($i=0;$i<count($objs);$i++)
   {
       $stmt2=$con->prepare("INSERT INTO localStorage(event_type,event_target,event_time) VALUES(?,?,?)");
       $stmt2->execute(array($objs[$i]["eventType"],$objs[$i]["eventTarget"], $objs[$i]["eventTime"]));
       $objs[$i]["eventType"];
   }

   echo json_encode($objs);
   
?>