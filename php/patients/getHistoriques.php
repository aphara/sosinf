<?php
	include("../bdd/param.php");
	$conn = new mysqli(DBHOST,DBUSER,DBPASSWD,DBNAME);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	} 
	global $conn;
	//Valeurs par défault
	$start = '0';
	$limit = '10';
	$dir = 'ASC';
	$sort = 'hist_id';
	$hist_pat_id = '' ;
	$retour='';
	if (isset($_POST['pat_id'])){$hist_pat_id = $_POST['pat_id'];}	

	$nbelement = 0;//nombre d'éléments renvoyés
	//Requête donnant l'intégralité de l'historique concernant le patient
	// $rek = "SELECT * FROM historiques h, efh e WHERE hist_pat_id = '".$hist_pat_id."' AND h.hist_efh_id = e.efh_id ORDER BY ".$sort." ".$dir." LIMIT ".$start." , ".$limit.";";
//Requête donnant l'intégralité de l'historique concernant le patient
	$rek = "SELECT *,efh_nom, or_nom, qual_nom, inf_nom,pat_nom,etat_sms_nom FROM historiques ";
	$rek .= " left join efh on hist_efh_id = efh_id ";
$rek .= " left join origines on hist_or_id=or_id ";
$rek .= " left join qualifications on hist_qual_id=qual_id ";
$rek .= " left join infirmiers on hist_inf_id=inf_id  ";
$rek .= " left join patients on hist_pat_id=pat_id  ";
$rek .= " left join etat_sms on hist_etat_sms_id=etat_sms_id  ";
$rek .= " WHERE hist_pat_id = '".$hist_pat_id."' ORDER BY hist_id ASC LIMIT 0 , 10";

	$result = $conn->query($rek);
	
	//Initialisations
	$hist_id = "";  
	$hist_deb_soins = "";  
	$hist_heure = "";  
	$hist_efh_id = ""; 
	$efh_nom = "";
	$hist_soin = "";  
	$hist_tel = "";
	$hist_referant = "";
	$hist_origine_id = "";
	$or_nom = "";
	$hist_qualification = "";
	$hist_pat_id = "";
	$hist_inf_id = "";
	$hist_etat_sms_id = "";
	
	$first = true;
	$jsonRetour = '{"res":[';
	if ($result->num_rows > 0) {
	  while($ligne = $result->fetch_assoc()) {
 		    if (! $first) $jsonRetour .= ','; else $first = false;

		    $hist_id = htmlentities($ligne['hist_id']);  
		    $hist_deb_soins = htmlentities($ligne['hist_deb_soins']);  
		    $hist_heure = htmlentities($ligne['hist_heure']);  
		    $efh_nom = htmlentities($ligne['efh_nom']);


		    $hist_soin = htmlentities($ligne['hist_soin']);  
		    $hist_soin = str_replace ( chr(13) , "\\r" , $hist_soin ); 
		    $hist_soin = str_replace ( chr(10) , "\\n" , $hist_soin ); 
		    $hist_tel = htmlentities($ligne['hist_tel']);
		    $hist_referant = htmlentities($ligne['hist_referant']);
		    

		    $hist_or_id = htmlentities($ligne['hist_or_id']);

		    $qual_nom = htmlentities($ligne['qual_nom']);
		    

		    $pat_nom = htmlentities($ligne['pat_nom']);

		    $inf_nom = htmlentities($ligne['inf_nom']);
		    

		    $hist_etat_sms_id = htmlentities($ligne['hist_etat_sms_id']);
		    $hist_id_sms = htmlentities($ligne['hist_id_sms']);
		    $hist_sms = htmlentities($ligne['hist_sms']);
		    $hist_sms_date = htmlentities($ligne['hist_sms_date']);
		    $hist_etat_sms  = htmlentities($ligne['hist_etat_sms']);
		    
		    if(($hist_etat_sms == 'on')OR($hist_etat_sms == 'wa')OR($hist_etat_sms == '')){
			    try {
				    $motRetour = $resStatut->sms_status;
				    $motRetour = substr($motRetour,0,2);
				    if($motRetour != $hist_etat_sms){
					    $rekUpdateEtatSMS = "UPDATE historiques SET hist_etat_sms = '".UTF8_decode($motRetour)."' WHERE hist_id_sms = '".$hist_id_sms."';";
					    if (!$rekUpdateEtatSMS = queryDB($rekUpdateEtatSMS)) die ('{"retour":-1,"message":"REKET ERROR : '.$rekUpdateEtatSMS.'"}'); //scrouik !
				    }
			    } catch (SoapFault $fault) {
				    echo $fault;
			    }
		    }
			    		    
		    //Requête donnant le nom du patient en fonction de son identifiant 
		 //    $rek_pat = "SELECT pat_nom FROM patients,historiques WHERE pat_id = ".$hist_pat_id.";";
			// $res_pat = $conn->query($rek_pat);
			// $ligne_pat=$res_pat->fetch_assoc();
		 //    $pat_nom = htmlentities($ligne_pat['pat_nom']);
		    
		    //Requête donnant l'intitulé de l'état du SMS en fonction de son identifiant 
		 //    $rek_etat_sms = "SELECT etat_sms_nom FROM etat_sms, historiques WHERE etat_sms_id = ".$hist_etat_sms_id.";";
			// $res_etat_sms = $conn->query($rek_etat_sms);
			// $ligne_etat_sms=$res_etat_sms->fetch_assoc();
		 //    $etat_sms_nom = htmlentities($ligne_etat_sms['etat_sms_nom']);
		    
		    //Concaténation des lignes de l'historique du patient
			$jsonRetour .= '{"hist_id":"'.$hist_id.'","hist_deb_soins":"'.substr($hist_deb_soins,0,10).'",
			"hist_heure":"'.substr($hist_heure,11,8).'", "hist_efh":"'.$efh_nom.'", 
			"hist_soin":"'.$hist_soin.'", "hist_tel":"'.$hist_tel.'", 
			"hist_referant":"'.$rek.'",
		 "hist_origine":"'.$or_nom.'",
			"hist_qual":"'.$qual_nom.'", "hist_pat_id":"'.$pat_nom.'",
			"hist_inf":"'.$inf_nom.'", "hist_etat_sms":"'.$hist_etat_sms.'"}';

		}
	}
	$jsonRetour .= ']}';
	$conn->close();
	echo $jsonRetour;
?>
