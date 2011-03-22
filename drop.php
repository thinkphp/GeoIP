<?php

require_once('init.php');

  if(isset($_GET['id']) && strlen($_GET['id'])>0 && $_GET['id'] !== 'all') {

       $id = $_GET['id'];

  if($db->table_exists($table)) { 
        
       $sql = "delete from $table where id='$id'";

       $result = $db->query($sql);

       if($result) {echo " Ok! Row with id=$id Deleted";}

                else {

                       echo"Unsuccessfully Run Query! I think ID doesn`t exist!";  

                     }       
    } else {

         echo"Table <strong>$table</strong> not exists.";
    }

  } else if(isset($_GET['id']) && strlen($_GET['id'])>0 && $_GET['id'] === 'all'){ 

   if($db->table_exists($table)) { 

       $result = $db->delete_table($table);

       if($result) {echo " Ok!";}

                else {

                       echo"Unsuccessfully Run Query!";  

                     }       
    } else {

         echo"Table <strong>$table</strong> not exists.";
    }


  } else {

         echo"You must provides an GET parameter (ex: index.php?id=2334343 or id=all)";
  }
?>