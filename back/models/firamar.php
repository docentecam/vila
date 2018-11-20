<?php 

	$tbl_firamar="firamar";
	$tbl_participants="participants";
	$tbl_sponsors="sponsors";
	$tbl_galeriafiramar="galeriafiramar";

	require("../../inc/functions.php");

	session_start();
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
			echo firaFulls($tbl_firamar);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='listEdicion'){
		echo firaEdicion($tbl_firamar,$tbl_participants,$tbl_sponsors,$tbl_galeriafiramar,$_POST['dataFiramar']);
	}


	if(isset($_POST['acc'])&&$_POST['acc']=='Editar'){
		$mySql="UPDATE $tbl_firamar 
				SET `titolFiramar`='".replaceFromHtml($_POST['titolFiramar'])."',  
					`txtFiramar`='".replaceFromHtml($_POST['txtFiramar'])."' 
				WHERE dataFiramar ='".$_POST['fecha']."'"; 
		$connexio=connect();
		$resultFiramar=mysqli_query($connexio,$mySql);
		// 	// $idGegantInsert=mysqli_insert_id($connexio); 
		  disconnect($connexio);
	
		// if (isset($_FILES['fotoNew']) && $_FILES['fotoNew']!="") {
		// 	$file = date("YmdHis").$_FILES['fotoNew']["name"];
		// 	$mySql="UPDATE $tbl_gegants
		// 			SET `foto`='".$file."'
		// 			WHERE idGegant='".$_POST['idGegant']."'";
		// 	$connexio=connect();
		// 	$resultGegants=mysqli_query($connexio,$mySql);
		// 	disconnect($connexio);
		// 	move_uploaded_file($_FILES["fotoNew"]["tmp_name"],"../../img/gegants/".$file);
				
		// }
		// echo $mySql;
		echo firaFulls($tbl_firamar);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='Afegir'){
	$fecha=date("Y-m-d H:i:s");	
	$mySql="INSERT INTO $tbl_firamar 
						(`dataFiramar`,`titolFiramar`, `txtFiramar`,`actiu`) 
			VALUES (NULL,'".$fecha."',
						'".replaceFromHtml($_POST['titolFiramar'])."',
						'".replaceFromHtml($_POST['txtFiramar'])."',
						'".$_POST['actiu']."')";
	
	$connexio=connect();
	$resultFiramar=mysqli_query($connexio,$mySql); 
	// $idGegantInsert=mysqli_insert_id($connexio);
	disconnect($connexio);
	
	// if (isset($_FILES['fotoNew']) && $_FILES['fotoNew']!="") {
	// 	$file = date("YmdHis").$_FILES['fotoNew']["name"];
	// 	$mySql="UPDATE $tbl_gegants
	// 			SET `foto`='".$file."'
	// 			WHERE idGegant=$idGegantInsert";
	// 	$connexio=connect();
	// 	$resultGegants=mysqli_query($connexio,$mySql);
	// 	disconnect($connexio);
	// 	move_uploaded_file($_FILES["fotoNew"]["tmp_name"],"../../img/gegants/".$file);
			
	// 	}
	echo firaFulls($tbl_firamar);

	}
function firaFulls($tbl_firamar){
		$mySql="SELECT `txtFiramar`, `titolFiramar`, `dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
				FROM $tbl_firamar";
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

function firaEdicion($tbl_firamar,$tbl_participants,$tbl_sponsors,$tbl_galeriafiramar,$dataFiramar){
		
		$mySql="SELECT `txtFiramar`, `titolFiramar`, `dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
				FROM $tbl_firamar WHERE `dataFiramar`='".$dataFiramar."'";
		
		$mySqlParticipants="SELECT `idParticipant`, `nomParticipant`, `logoParticipant`, `dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' ) AS 'fechaEsp'
							FROM $tbl_participants WHERE `dataFiramar`='".$dataFiramar."'";
		
		$mySqlSponsors="SELECT `logoSponsor`,`nomSponsor`,`dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
						FROM $tbl_sponsors WHERE `dataFiramar`='".$dataFiramar."'";

		$mySqlGaleriaFiramar="SELECT `idGaleriaFiramar`,`fotoFiramar`,`dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
							FROM $tbl_galeriafiramar WHERE `dataFiramar`='".$dataFiramar."'";				

			//return $mySql."<br>".$mySqlParticipants."<br>".$mySqlSponsors."<br>".$mySqlGaleriaFiramar;
		$connexio=connect();
		$resultFiramar=mysqli_query($connexio,$mySql); 
		$resultParticipants=mysqli_query($connexio,$mySqlParticipants); 
		$resultSponsors=mysqli_query($connexio,$mySqlSponsors); 
		$resultGaleriaFiramar=mysqli_query($connexio,$mySqlGaleriaFiramar); 
		disconnect($connexio);


		$datos='{"firamar":';
				$rows = array(); 
				while($r = mysqli_fetch_array($resultFiramar)) 
				{
					$rows[] = $r; 
				} 
				$datos.=json_encode($rows);
				$datos.=',"participantsFiramar":';
				$rows = array(); 
				while($r = mysqli_fetch_array($resultParticipants)) 
				{
					$rows[] = $r; 
				}
				$datos.=json_encode($rows);
				$datos.=',"sponsorsFiramar":';
				$rows = array(); 
				while($r = mysqli_fetch_array($resultSponsors)) 
				{
					$rows[] = $r; 
				}
				$datos.=json_encode($rows);
				$datos.=',"galeriaFiramar":';
				$rows = array(); 
				while($r = mysqli_fetch_array($resultGaleriaFiramar)) 
				{
					$rows[] = $r; 
				}
				$datos.=json_encode($rows);
				$datos.='}';
		
		return $datos;
	}
?>