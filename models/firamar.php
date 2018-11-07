<?php 

	require("../inc/functions.php");

	$tbl_firamar="firamar";
	$tbl_galeriafiramar="galeriafiramar";
	$tbl_activitatsfiramar="activitatsfiramar";
	$tbl_sponsors="sponsors";
	$tbl_participants="participants";
	// $tbl_firamar="firamar";
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){

		$dades= '{"dadesFiramar": ';
		$dades.= mostrarFiramar($tbl_firamar);
		$dades.= ',"dadesActivitatProgra":';	
		$dades.= mostrarActivitatProgra($tbl_activitatsfiramar);
		$dades.= ',"dadesGaleriaFira":';	
		$dades.= mostrarformGaleria($tbl_galeriafiramar);
		$dades.= ',"dadesSponsors":';
		$dades.= mostrarSponsors($tbl_sponsors);
		$dades.= ',"participants":';
		$dades.= mostrarParticipants($tbl_participants);

		$dades.="}";

		echo $dades;
		// echo formGaleria($tbl_galeriafiramar);
	}
	
function mostrarformGaleria($tbl_galeriafiramar){
		$mySql="SELECT `quiSom`,`equip`	FROM $tbl_galeriafiramar";
		$connexio=connect();
		$resultMostrarformGaleria=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		$rows = array(); 

		while($r = mysqli_fetch_array($resultMostrarformGaleria)) 
		{
			$rows[] = $r; 
		} 
					
		return json_encode($rows);
		}
	}

function mostrarFiramar($tbl_firamar){
		$mySql="SELECT `dataFiramar`,`txtFiramar`,`titolFiramar`	FROM $tbl_firamar";
		$connexio=connect();
		$resultMostrarFiramar=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		$rows = array(); 

		while($r = mysqli_fetch_array($resultMostrarFiramar)) 
		{
			$rows[] = $r; 
		} 
				
		return json_encode($rows);
	}
function mostrarActivitatProgra($tbl_activitatsfiramar){
		$mySql="SELECT `idActivitat`,`horaInici	`,`horafi`	FROM $tbl_activitatsfiramar";
		$connexio=connect();
		$resultActivitatsfiramar=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		$rows = array(); 
		$i=0;
		while($r = mysqli_fetch_array($resultActivitatsfiramar)) 
		{
			$rows[] = $r; 
			 $i++;
		} 
				
		return json_encode($rows);
	}

	function mostrarSponsors($tbl_sponsors){
		$mySql="SELECT `nomServei`,`txtServei`	FROM $tbl_sponsors";
		$connexio=connect();
		$resultMostrarSponsors=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		$rows = array(); 
		$i=0;
		while($r = mysqli_fetch_array($resultMostrarSponsors)) 
		{
			$rows[] = $r; 
			 $i++;
		} 
				
		return json_encode($rows);
	}


	function mostrarParticipants($tbl_participants){
		$mySql="SELECT `nomServei`,`txtServei`	FROM $tbl_participants";
		$connexio=connect();
		$resultActivitatsfiramar=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		$rows = array(); 
		$i=0;
		while($r = mysqli_fetch_array($resultActivitatsfiramar)) 
		{
			$rows[] = $r; 
			 $i++;
		} 
				
		return json_encode($rows);
	}
?>