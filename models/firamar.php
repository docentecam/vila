<?php 

	require("../inc/functions.php");

	$tbl_firamar="firamar";
	$tbl_galeriafiramar="galeriafiramar";
	$tbl_activitatsfiramar="activitatsfiramar";
	$tbl_sponsors="sponsors";
	$tbl_participants="participants";


	require("../inc/functions.php");
	
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
				$dades= '{"dadesFiramar": ';
				$dades.= mostrarFiramar($tbl_firamar);
				$dades.= ',"dadesGaleriafiramar":';	
				$dades.= mostrarGaleriafiramar($tbl_galeriafiramar);
				$dades.= ',"dadesActivitatsfiramar":';	
				$dades.= mostrarActivitatsfiramar($tbl_activitatsfiramar);
				$dades.= ',"dadesSponsors":';	
				$dades.= mostrarSponsors($tbl_sponsors);
				$dades.= ',"dadesParticipants":';	
				$dades.= mostrarParticipants($tbl_participants);

				$dades.="}";

				echo $dades;
			}
	
	function mostrarFiramar($tbl_firamar){
				$mySql="SELECT `dataFiramar`, `txtFiramar`, `titolFiramar`	FROM $tbl_firamar";
				$connexio=connect();
				$resultFiramar=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 

				while($r = mysqli_fetch_array($resultFiramar)) 
				{
					$rows[] = $r; 
				} 
						
				return json_encode($rows);
			}
	function mostrarGaleriafiramar($tbl_galeriafiramar){
				$mySql="SELECT `idGaleriaFiramar`, `fotoFiramar`, `dataFiramar`	FROM $tbl_galeriafiramar";
				$connexio=connect();
				$resultGaleriafiramar=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 

				while($r = mysqli_fetch_array($resultGaleriafiramar)) 
				{
					$rows[] = $r; 
				} 
						
				return json_encode($rows);
			}
	function mostrarActivitatsfiramar($tbl_activitatsfiramar){
				$mySql="SELECT `idActivitat`, `horaInici`, `horaFi`, `titolActivitat`, `txtActivitat`, `dataFiramar`	FROM $tbl_activitatsfiramar";
				$connexio=connect();
				$resultActivitatsfiramar=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 

				while($r = mysqli_fetch_array($resultActivitatsfiramar)) 
				{
					$rows[] = $r; 
				} 
						
				return json_encode($rows);
			}
	function mostrarSponsors($tbl_sponsors){
				$mySql="SELECT `logoSponsor`, `nomSponsor`, `dataFiramar`	FROM $tbl_sponsors";
				$connexio=connect();
				$resultSponsors=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 

				while($r = mysqli_fetch_array($resultSponsors)) 
				{
					$rows[] = $r; 
				} 
						
				return json_encode($rows);
			}
	function mostrarParticipants($tbl_participants){
				$mySql="SELECT `idParticipant`, `nomParticipant`, `logoParticipant`, `dataFiramar`	FROM $tbl_participants";
				$connexio=connect();
				$resultParticipants=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array(); 

				while($r = mysqli_fetch_array($resultParticipants)) 
				{
					$rows[] = $r; 
				} 
						
				return json_encode($rows);
			}

?>