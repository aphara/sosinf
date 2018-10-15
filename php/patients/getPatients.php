<?php
include("../bdd/param.php");
$conn = dbConnect();
$start = '0';
$limit = '100';
$dir = 'ASC';
$sort = 'pat_nom';
$pat_deb_nom = $_POST["name"];
$pat_deb_tel = '';
$rek = "SELECT * FROM patients WHERE pat_nom LIKE '".$pat_deb_nom."%' ORDER BY ".$sort." ".$dir." LIMIT ".$start." , ".$limit.";";
$result = $conn->query($rek);
$jsonRetour = '{"res":[';
$first = true;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (! $first) $jsonRetour .= ','; else $first = false;
        $pat_id = htmlentities($row['pat_id']);
        $pat_creation = htmlentities($row['pat_creation']);
        $pat_modification = htmlentities($row['pat_modification']);
        $pat_nom = htmlentities($row['pat_nom']);
        $pat_prenom = htmlentities($row['pat_prenom']);
        $pat_rue1 = htmlentities($row['pat_rue1']);
        $pat_tel1 = htmlentities($row['pat_tel1']);
        $pat_idel = htmlentities($row['pat_idel']);
        $pat_rue2 = htmlentities($row['pat_rue2']);
        $pat_tel2 = htmlentities($row['pat_tel2']);
        $pat_email = htmlentities($row['pat_email']);
        $pat_cp = htmlentities($row['pat_cp']);
        $pat_ville = htmlentities($row['pat_ville']);
        $pat_societe = "";//htmlentities($row['pat_societe']);
        $pat_sms = htmlentities($row['pat_sms']);
        $pat_sms = str_replace ( chr(13) , "\\r" , $pat_sms );
        $pat_sms = str_replace ( chr(10) , "\\n" , $pat_sms );
        $pat_observation = htmlentities($row['pat_observation']);
        $pat_observation = str_replace ( chr(13) , "\\r" , $pat_observation );
        $pat_observation = str_replace ( chr(10) , "\\n" , $pat_observation );
        $jsonRetour .= '{"pat_id":"'.$pat_id.'","pat_creation":"'.$pat_creation.'",
			"pat_modification":"'.$pat_modification.'", "pat_nom":"'.$pat_nom.'", 
			"pat_prenom":"'.$pat_prenom.'", "pat_rue1":"'.$pat_rue1.'", 
			"pat_tel1":"'.$pat_tel1.'", "pat_idel":"'.$pat_idel.'",
			"pat_rue2":"'.$pat_rue2.'", "pat_tel2":"'.$pat_tel2.'",
			"pat_email":"'.$pat_email.'", "pat_cp":"'.$pat_cp.'",
			"pat_ville":"'.$pat_ville.'", "pat_societe":"'.$pat_societe.'",
			"pat_sms":"'.$pat_sms.'", "pat_observation":"'.$pat_observation.'"}';
    }
    $jsonRetour .= ']}';
}
$conn->close();
echo $jsonRetour;
