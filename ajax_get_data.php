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

   $stmt2=$con->prepare("SELECT * FROM localStorage");
   $stmt2->execute();
   $objs = $stmt2->fetchAll();
   
  $i = 0;
  foreach($objs as $obj)
  {
    $i++;
    echo "<tr>";
        echo "<td>".$i."</td><td>" . $obj['event_type'] . "</td><td>" . $obj['event_target'] . "</td><td>" . $obj['event_time'] . "</td>";
    echo "</tr>";
  }

?>