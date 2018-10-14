<?php
 	include("../bdd/param.php");
	$conn = new mysqli(DBHOST,DBUSER,DBPASSWD,DBNAME);
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	} 
	$pat_id = "";  
	$pat_creation = "";
	$pat_modification = "";
	$pat_nom = "";
	$pat_prenom = "";
	$pat_rue1 = "";
	$pat_tel1 = "";
	$pat_idel = "";
	$pat_rue2 = "";
	$pat_tel2 = "";
	$pat_cp = "";
	$pat_ville = "";
	$pat_sms = "";
	$pat_observation = "";
	
	if (isset($_POST['pat_id'])){$pat_id = $_POST['pat_id'];}
	if (isset($_POST['pat_nom'])){$pat_nom = mb_strtoupper($_POST['pat_nom']);}
	if (isset($_POST['pat_prenom'])){$pat_prenom = mb_strtoupper($_POST['pat_prenom']);}
	if (isset($_POST['pat_rue1'])){$pat_rue1 = mb_strtoupper($conn->real_escape_string($_POST['pat_rue1']));}
	if (isset($_POST['pat_tel1'])){$pat_tel1 = $_POST['pat_tel1'];}
	if (isset($_POST['pat_idel'])){$pat_idel = mb_strtoupper($conn->real_escape_string($_POST['pat_idel']));}
	if (isset($_POST['pat_rue2'])){$pat_rue2 = mb_strtoupper($conn->real_escape_string($_POST['pat_rue2']));}
	if (isset($_POST['pat_tel2'])){$pat_tel2 = mb_strtoupper($conn->real_escape_string($_POST['pat_tel2']));}
	if (isset($_POST['pat_cp'])){$pat_cp = $_POST['pat_cp'];}
	if (isset($_POST['pat_ville'])){$pat_ville = mb_strtoupper($_POST['pat_ville']);}
	if (isset($_POST['pat_observation'])){$pat_observation = mb_strtoupper($conn->real_escape_string($_POST['pat_observation']));}	

echo "Ajout de " . $pat_nom;
	$currentdate = date('Y-m-d H:i:s');

if($pat_id === ""){
	$rek = "INSERT INTO patients VALUES (0, '".UTF8_decode($currentdate)."' , '"
	.UTF8_decode($currentdate)."' , '".UTF8_decode($pat_rue1)."' , '".UTF8_decode($pat_rue2)."' , '"
	.UTF8_decode($pat_cp)."' , '".UTF8_decode($pat_ville)."' , '".UTF8_decode($pat_prenom)."' , '"
	.UTF8_decode($pat_nom)."' , '".UTF8_decode($pat_tel1)."' , '".UTF8_decode($pat_tel2)."' , '' , '' , 0, '"
	.UTF8_decode($pat_sms)."' , '".UTF8_decode($pat_observation)."');";
	if ($conn->query($rek) === TRUE) {
	    echo "New record created successfully";
	    echo $conn->insert_id;
	} else {
	    echo "Error: " . $rek . "<br>" . $conn->error;
	}
} else {	
	$rek = "UPDATE patients SET  pat_modification = '".UTF8_decode($currentdate)."' , 
	pat_rue1 = '".UTF8_decode($pat_rue1)."' , pat_nom = '".UTF8_decode($pat_nom)."' , pat_cp = '".UTF8_decode($pat_cp)."' , 
	pat_ville = '".UTF8_decode($pat_ville)."' , pat_prenom = '".UTF8_decode($pat_prenom)."' , pat_nom = '".UTF8_decode($pat_nom)."' , 
	pat_tel1 = '".UTF8_decode($pat_tel1)."' , pat_tel2 = '".UTF8_decode($pat_tel2)."' , pat_idel = '".UTF8_decode($pat_idel)."' , 
	pat_rue2 = '".UTF8_decode($pat_rue2)."' , pat_email = '".UTF8_decode($pat_email)."' , 
	pat_sms = '".UTF8_decode($pat_sms)."' , pat_observation = '".UTF8_decode($pat_observation)."' WHERE pat_id = '".UTF8_decode($pat_id)."';";
	if ($conn->query($rek) === TRUE) {
	    echo "Moficiation successfully";
	} else {
	    echo "Error: " . $rek . "<br>" . $conn->error;
	}
}
$conn->close();
echo $rek;
?>
