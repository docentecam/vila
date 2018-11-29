<?php 
	$tbl_firamar="firamar";
	$tbl_galeriafiramar="galeriafiramar";
	$tbl_activitatsfiramar="activitatsfiramar";
	$tbl_sponsors="sponsors";
	$tbl_participants="participants";

	require("../inc/functions.php");

	
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		if(isset($_POST['dataFiramar'])) {$dataFiramar=$_POST['dataFiramar'];} else  {$dataFiramar=ultimaFiramar($tbl_firamar);}
				$dades= '{"dadesFiramar": ';
				$dades.= mostrarFiramar($tbl_firamar,$dataFiramar);
				$dades.= ',"dadesGaleriafiramar":';
				$dades.= mostrarGaleriafiramar($tbl_firamar,$tbl_galeriafiramar,$dataFiramar);
				$dades.= ',"dadesActivitatsfiramar":';
				$dades.= mostrarActivitatsfiramar($tbl_activitatsfiramar,$dataFiramar);
				$dades.= ',"dadesSponsors":';
				$dades.= mostrarSponsors($tbl_sponsors,$dataFiramar);
				$dades.= ',"dadesParticipants":';
				$dades.= mostrarParticipants($tbl_participants,$dataFiramar);
				$dades.= ',"dadesTotesEdicions":';
				$dades.= mostrarEdicions($tbl_firamar,$dataFiramar);

				$dades.="}";

				echo $dades;
			}
	
	function ultimaFiramar($tbl_firamar){
		$mySql="SELECT `dataFiramar` FROM $tbl_firamar ORDER BY `dataFiramar` DESC LIMIT 1";
				$connexio=connect();
				$resultFiramar=mysqli_query($connexio,$mySql);
				disconnect($connexio);
				$dadesFiramar=mysqli_fetch_row($resultFiramar);
				return $dadesFiramar[0];
	}
	function mostrarFiramar($tbl_firamar,$dataFiramar=""){
				$mySql="SELECT `dataFiramar`, `txtFiramar`, `titolFiramar`,`edicioGaleria` FROM $tbl_firamar WHERE `dataFiramar`='".$dataFiramar."' ORDER BY `dataFiramar` DESC LIMIT 1";
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
	function mostrarGaleriafiramar($tbl_firamar,$tbl_galeriafiramar,$dataFiramar=""){
				$mySqlDataEdicioGaleriaFiramar="SELECT `edicioGaleria` FROM $tbl_firamar  WHERE `dataFiramar`='".$dataFiramar."'";
				
				$connexio=connect();
				$resultDataEdicioGaleriaFiramar=mysqli_query($connexio,$mySqlDataEdicioGaleriaFiramar); 
				$dataGaleriaFiramar=mysqli_fetch_row($resultDataEdicioGaleriaFiramar);
				
				
				$mySql="SELECT `idGaleriaFiramar`, `fotoFiramar`, `dataFiramar`	FROM $tbl_galeriafiramar  WHERE `dataFiramar`='".$dataGaleriaFiramar[0]."'";
				$resultGaleriafiramar=mysqli_query($connexio,$mySql); 
				$rows = array(); 

				while($r = mysqli_fetch_array($resultGaleriafiramar)) 
				{
					$rows[] = $r; 
				} 
				disconnect($connexio);		
				return json_encode($rows);
			}
	function mostrarActivitatsfiramar($tbl_activitatsfiramar,$dataFiramar=""){
				$mySql="SELECT `idActivitat`, `horaInici`, `horaFi`, `titolActivitat`, `txtActivitat`, `dataFiramar`FROM $tbl_activitatsfiramar  WHERE `dataFiramar`='".$dataFiramar."' ORDER BY  `horaInici`";
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
	function mostrarSponsors($tbl_sponsors,$dataFiramar=""){
				$mySql="SELECT `logoSponsor`, `dataFiramar`	FROM $tbl_sponsors WHERE `dataFiramar`='".$dataFiramar."'";
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
	function mostrarParticipants($tbl_participants,$dataFiramar=""){
				$mySql="SELECT `idParticipant`, `nomParticipant`, `logoParticipant`, `dataFiramar`	FROM $tbl_participants WHERE `dataFiramar`='".$dataFiramar."'";
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
			function mostrarEdicions($tbl_firamar,$dataFiramar){
				$mySql="SELECT `dataFiramar`,`titolFiramar` FROM `$tbl_firamar` WHERE `dataFiramar` NOT LIKE('".$dataFiramar."') ORDER BY `dataFiramar` DESC";
				$connexio=connect();
				$resultEdicions=mysqli_query($connexio,$mySql); 
				disconnect($connexio);

				$rows = array();

				while($r = mysqli_fetch_array($resultEdicions)) 
				{
					$rows[] = $r; 
				} 
						
				return json_encode($rows);
			}

?>