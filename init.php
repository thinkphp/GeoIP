<?php

  require_once('config.php');

  require_once('db.class.php');

  //Database MySQL Connection
  if(isset($config['mysql'])) {
  
    $db = new Database_MySQL();

    $db->connect($config['mysql'][0],$config['mysql'][1],$config['mysql'][2],$config['mysql'][3]);

  //otherwise SQLitedatabase
  } else if(isset($config['sqlite']) && $config['sqlite'] === 3) {

    $db = new Database_SQLite();

    $to = "db/$table.db";

    $db->connect($to);
  }

?>