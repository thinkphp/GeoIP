<?php

    require_once('init.php');

       #$db->query('INSERT INTO geoip(id,ip,hostname,country,city,postcode,latitude,longitude) VALUES(4,"127.0.0.1","adonix.cs.unibuc.ro","Romania","Bucharest","232434","03000","44.3","24.1")');

       if($db->table_exists($table)) {

          if($config['mysql']) {

          $sql = "INSERT INTO $table (id,ip,hostname,date_visit,country,city,woeid,postcode,latitude,longitude) VALUES('".time()."','".$ip."','".$host."',now(),'".$json->CountryName."','".$json->City."','".$woeid."','".$postcode."','".$json->Latitude."','".$json->Longitude."')";
 
          $db->query($sql);

          }

          else if($config['sqlite'] === 3) {

          $sql = "INSERT INTO $table (id,ip,hostname,date_visit,country,city,woeid,postcode,latitude,longitude) VALUES('".time()."','".$ip."','".$host."',datetime('now'),'".$json->CountryName."','".$json->City."','".$woeid."','".$postcode."','".$json->Latitude."','".$json->Longitude."')";
 
          $db->query($sql);

          }


        } 
       
?>