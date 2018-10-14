<?php
//Zerg Corp. 9/10/2007
//Grozerg.

  include "param.php";

//POUR LES VERSION < php5
  function microtime_float() 
  {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
  }

//INIT DES TEMPS D'EXECUTION DES REKETTE
  global $LATENCE;
  global $LATENCETOTAL;
  $LATENCETOTAL = 0;
  
//OUVRE LA CONNEXION  
  function openDB(){
     // global $LATENCE;
     // global $LATENCETOTAL;
     // $time_start = microtime_float();
     // if (!$db = @mysql_connect(DBHOST,DBUSER,DBPASSWD))
     //    return FALSE; # pas de connexion
     // if (!@mysql_select_db(DBNAME, $db)) {
     //    @mysql_close($db);
     //    return FALSE; # bdd introuvable
     // }
     // $time_end = microtime_float();
     // $LATENCE = $time_end - $time_start;
     // $LATENCETOTAL += $LATENCE;



      // Create connection
  $conn = new mysqli(DBHOST,DBUSER,DBPASSWD,DBNAME);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    return FALSE;
  } 

     return $conn;
  }

//FERME LA CONNEXION
  function closeDB(){
     global $LATENCE;
     global $LATENCETOTAL;
     $time_start = microtime_float();
     $result = @mysql_close();
     $time_end = microtime_float();
     $LATENCE = $time_end - $time_start;
     $LATENCETOTAL += $LATENCE;
     return $result;
  }

//EXECUTION D'UNE REKETTE
  function queryDB($sql) {
     // global $LATENCE;
     // global $LATENCETOTAL;
     // $time_start = microtime_float();
     // $result = @mysql_query($sql);
     // $time_end = microtime_float();
     // $LATENCE = $time_end - $time_start;
     // $LATENCETOTAL += $LATENCE;
global $conn;

  $result = $conn->query($sql);


     return $result;   
  }

//RECUP DU DERNIER ID APRES INSERT
  function lastID(){
     global $LATENCE;
     global $LATENCETOTAL;
     $time_start = microtime_float();
     $result = @mysql_insert_id();
     $time_end = microtime_float();
     $LATENCE = $time_end - $time_start;
     $LATENCETOTAL += $LATENCE;
     return $result;
  }

//RECUP LE NOMBRE DE LIGNE MODIFIE
  function affectedRows(){
     global $LATENCE;
     global $LATENCETOTAL;
     $time_start = microtime_float();
     $result = @mysql_affected_rows();
     $time_end = microtime_float();
     $LATENCE = $time_end - $time_start;
     $LATENCETOTAL += $LATENCE;
     return $result;
  }


?>
