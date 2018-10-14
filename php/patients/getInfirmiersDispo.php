<?php
  include("../bdd/param.php");
  $conn = new mysqli(DBHOST,DBUSER,DBPASSWD,DBNAME);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
  global $pat_cp;
  if (isset($_POST['pat_cp'])) $pat_cp = $_POST['pat_cp'];
  $pat_date = '20080812';
  if (isset($_POST['pat_date'])) $pat_date = $_POST['pat_date'];
  $a=Substr($pat_date,6,4);
  $m=Substr($pat_date,3,2);
  $j=Substr($pat_date,0,2);      
  $theDate = $a.'-'.$m.'-'.$j;
  $pat_heure = '2008-08-12 12:12:12';
  if (isset($_POST['pat_heure2'])) $pat_heure = $_POST['pat_heure2'];
  $pat_heure=Substr($pat_heure,0,2);


  function isIDELnuitJourOpen($pat_heure){
      if ($pat_heure<5) return true;
      if ($pat_heure>15) return true;
      return false;
  }

  function isIDELnuitJourClosed($pat_heure){
      if ($pat_heure<5) return true;
      if ($pat_heure>10) return true;
      return false;
  }

function isJourClosed(){
  global $retour;
  global $theDate;
  $conn2 = new mysqli(DBHOST,DBUSER,DBPASSWD,DBNAME);
  if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
  } 
  $request = "SELECT day FROM day2time_slice WHERE day = '".$theDate."' LIMIT 1";
  // $retour .= $request."<br>";
  $result2 = $conn2->query($request);
 if ($result2->num_rows > 0){
    if($ligne = $result2->fetch_assoc()){
      return true; 
    } else {
      return false; 
    }
  }
  else{
    return false;
  }
}
  
 function getInfirmierNuit() {
 // function getInfirmierNuit($soc_id) {
  global $retour;
  $conn3 = new mysqli(DBHOST,DBUSER,DBPASSWD,DBNAME);
  if ($conn3->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
  } 
  global $theDate;
  global $pat_cp;

      if (($pat_cp=='')OR($pat_cp==0))
        $requet = "SELECT DISTINCT infirmiers.inf_nom AS name,infirmiers.inf_prenom AS pname,infirmiers.inf_id AS ident from planning LEFT JOIN zone ON zone.idz=planning.zone LEFT JOIN infirmiers ON planning.infirmier = infirmiers.inf_id LEFT JOIN zone2cp ON zone.idz = zone2cp.zone where libelle LIKE 'NUIT%' and jourdeb <= '".$theDate."' and jourfin >= '".$theDate."' AND infirmiers.inf_statut=1 order by 2";
      else  
        $requet = "SELECT DISTINCT infirmiers.inf_nom AS name,infirmiers.inf_prenom AS pname,infirmiers.inf_id AS ident from planning LEFT JOIN zone ON zone.idz=planning.zone LEFT JOIN infirmiers ON planning.infirmier = infirmiers.inf_id LEFT JOIN zone2cp ON zone.idz = zone2cp.zone where libelle LIKE 'NUIT%' and jourdeb <= '".$theDate."' and jourfin >= '".$theDate."' AND zone2cp.cp = '".$pat_cp."' AND infirmiers.inf_statut=1 order by 2";
 // $retour .= $requet."<br>";
 

      $result3 = $conn3->query($requet);
      if ($result3->num_rows > 0){
        while($ligneI = $result3->fetch_assoc()){
          $retour .= "<option value='".$ligneI['ident']."'>".$ligneI['pname'].' '.$ligneI['name']."</option>";
          // $jsonRetour .= ',{" result":"'.$retour.'"}';
      } 
    }
    $conn3->close();
  }

  function getInfirmierJour()
  {
    global $retour;
    $conn4 = new mysqli(DBHOST,DBUSER,DBPASSWD,DBNAME);
    if ($conn4->connect_error) {
      die("Connection failed: " . $conn2->connect_error);
    } 

      global $theDate;
      global $pat_heure;
      global $pat_cp;
      global $first;
      global $etablissement;
      if (($pat_cp=='')OR($pat_cp==0))
        $requet = "SELECT DISTINCT infirmiers.inf_nom AS name,infirmiers.inf_prenom AS pname,infirmiers.inf_id AS ident from planning LEFT JOIN zone ON zone.idz=planning.zone LEFT JOIN infirmiers ON planning.infirmier = infirmiers.inf_id LEFT JOIN zone2cp ON zone.idz = zone2cp.zone where libelle NOT LIKE 'NUIT%' and jourdeb <= '".$theDate."' and jourfin >= '".$theDate."' AND infirmiers.inf_statut=1  order by 2";
      else  
        $requet = "SELECT DISTINCT infirmiers.inf_nom AS name,infirmiers.inf_prenom AS pname,infirmiers.inf_id AS ident from planning LEFT JOIN zone ON zone.idz=planning.zone LEFT JOIN infirmiers ON planning.infirmier = infirmiers.inf_id LEFT JOIN zone2cp ON zone.idz = zone2cp.zone where libelle NOT LIKE 'NUIT%' and jourdeb <= '".$theDate."' and jourfin >= '".$theDate."' AND zone2cp.cp = '".$pat_cp."' AND infirmiers.inf_statut=1 order by 2";

 // $retour .= $requet."<br>";
 
     
     $result4 = $conn4->query($requet);
      if ($result4->num_rows > 0){
        while($ligne = $result4->fetch_assoc()){
          $retour .= "<option value='".$ligne['ident']."'>".$ligne['pname'].' '.$ligne['name']."</option>";
          // $jsonRetour .= ',{" result":"'.$retour.'"}';
      } 
      } 
      $conn4->close();
  }


  // $rek = "SELECT * FROM societes;";
  // $result = $conn->query($rek);
  $first=true;
  $retour = '';

            $retour .= $pat_date."<br>";
          $retour .= $pat_heure."<br>";
 
  // $jsonRetour .= '{"pat_cp":"'.$pat_cp.'"}';

  // if ($result->num_rows > 0) {
  //   while($row = $result->fetch_assoc()) {
    // if (isJourClosed($pat_date,$row['soc_id'])){
    if (isJourClosed()){
      if (isIDELnuitJourClosed($pat_heure)){
        getInfirmierNuit();
      }
      else{
       getInfirmierJour();
      }
    }
    else{
      if (isIDELnuitJourOpen($pat_heure)){
         getInfirmierNuit();
      }
      else{
        getInfirmierJour();
      }
    }
    // }
    // }



  
  // $Retour .= ']}';
  $conn->close();
  echo $retour;
?>