<?php

require('init.php');

if(isset($config['mysql'])) {

$sql = "create table $table (

             id INT(11) NOT NULL PRIMARY KEY,

             ip VARCHAR(50) not null,

             hostname varchar(100) not null, 

             date_visit varchar(60) not null, 

             country varchar(100) not null, 

             city varchar(50) not null,

             woeid int(20) not null,

             postcode int(10),

             latitude FLOAT(20) not null,

             longitude FLOAT(20) not null ); ";

} else {

$sql = "create table $table (

             id INT(11) NOT NULL PRIMARY KEY,

             ip VARCHAR(50),

             hostname varchar2(100), 

             date_visit varchar2(60) not null, 

             country varchar2(100) not null, 

             city varchar2(50),

             woeid int(20) not null,

             postcode int(10),

             latitude REAL(20),

             longitude REAL(20) ); ";

}


       if(!$db->table_exists($table)) { 

             $db->query($sql); echo"Table <strong>$table</strong> created!"; 

       } else {

              echo"Table <strong>$table</strong> exists!"; 
       }

   


?>