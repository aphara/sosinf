<?php
 	include("../bdd/param.php");
	$conn = dbConnect();
   
	if (isset($_POST['pat_id'])){
		$pat_id = $_POST['pat_id'];
	}	
	$rek = "DELETE FROM patients WHERE pat_id = ".$pat_id.";"; //Suppression du patient en fonction de son id
	if ($conn->query($rek) === TRUE) {
		$rek = "DELETE FROM historiques WHERE hist_pat_id = ".$pat_id.";"; //Suppression de l'historique du patient
		if ($conn->query($rek) === TRUE) {
		    echo "Suppression du patient";
		    echo $conn->insert_id;
		} else {
		    echo "Error: " . $rek . "<br>" . $conn->error;
		}
	} else {
	    echo "Error: " . $rek . "<br>" . $conn->error;
	}
	$conn->close();
	echo $rek;

