<?php 

	$tbl_firamar="firamar";
	$tbl_participants="participants";
	$tbl_sponsors="sponsors";
	$tbl_galeriafiramar="galeriafiramar";
	$tbl_activitatsfiramar="activitatsfiramar";

	require("../../inc/functions.php");

	session_start();
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
			echo firaFulls($tbl_firamar);
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='listEdicion'){
		echo firaEdicion($tbl_firamar,$tbl_participants,$tbl_sponsors,$tbl_galeriafiramar,$tbl_activitatsfiramar,$_POST['dataFiramar']);
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='Editar'){
		$mySql="UPDATE $tbl_firamar 
				SET `titolFiramar`='".replaceFromHtml($_POST['titolFiramar'])."',  
					`txtFiramar`='".replaceFromHtml($_POST['txtFiramar'])."' 
				WHERE dataFiramar ='".$_POST['fecha']."'"; 
		$connexio=connect();
		$resultFiramar=mysqli_query($connexio,$mySql);
		disconnect($connexio);
	
		
		echo firaFulls($tbl_firamar);
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='Afegir'){
	$fecha=date("Y-m-d H:i:s");	
	$mySqlFiramar="INSERT INTO $tbl_firamar 
						(`dataFiramar`,`titolFiramar`, `txtFiramar`) 
			VALUES (NULL,'".$fecha."',
						'".replaceFromHtml($_POST['titolFiramar'])."',
						'".replaceFromHtml($_POST['txtFiramar'])."')";
	$mySqlActivitatsFiramar="INSERT INTO $tbl_activitatsfiramar 
						(`idActivitat`,`horaInici`, `horaFi`, `titolActivitat`, `txtActivitat`, `dataFiramar`) 
			VALUES (NULL,'".replaceFromHtml($_POST['horaInici'])."',
						'".replaceFromHtml($_POST['horaFi'])."',
						'".replaceFromHtml($_POST['titolActivitat'])."',
						'".replaceFromHtml($_POST['txtActivitat'])."',
						'".$fecha."')";
	$connexio=connect();
	$resultFiramar=mysqli_query($connexio,$mySqlFiramar);
	$resultActivitatsFiramar=mysqli_query($connexio,$mySqlActivitatsFiramar); 
	disconnect($connexio);
	
	echo firaEdicion($tbl_firamar,$tbl_activitatsfiramar);

	}

	if(isset($_POST['acc'])&&$_POST['acc']=='getFileDetails'){
		//$_FILES[‘nombrePost’]. El nombre entre comillas, será el que nos envíen por post o get desde el formulario.
		// $datos="entra en model<br>"; 
	    $cantImatge=$_POST['cantImatge']+1;
	    $connexio=connect();
		
	    $j=0;
	    while($j<$cantImatge) {
		    $numUp='getFileDetails'.$j;
		    $fileEx =explode('.',$_FILES[$numUp]["name"]);
			$file =  date("dmYhisv").substr($fileEx[0],-3,3).'.'.$fileEx[count($fileEx)-1];
			//$datos.=$j."--".$_FILES[$numUp]["tmp_name"]."-"."../../img/galeriaassociats/".$file."<br>"; 

			move_uploaded_file($_FILES[$numUp]["tmp_name"], "../../img/galeriaFiramar/".$file);
			$mySql="INSERT INTO `galeriafiramar`(`fotoFiramar`, `idGaleriaFiramar`) VALUES ('".$file."','".$_POST['dataFiramar']."')";
			mysqli_query($connexio,$mySql);
			$j++;
	    }
	    disconnect($connexio);
		echo  galeriaFiramar($tbl_galeriafiramar,$_POST['dataFiramar']);
}

if(isset($_POST['acc'])&&$_POST['acc']=='Volatilizado'){
		$mySqlGaleriaFiramar="DELETE FROM $tbl_galeriafiramar WHERE `idGaleriaFiramar` ='".$_POST['idGaleriaFiramar']."'";
		$mySqlParticipants="DELETE FROM $tbl_participants WHERE `idParticipant` ='".$_POST['idParticipant']."'";
		$mySqlSponsors="DELETE FROM $tbl_sponsors WHERE `nomSponsor` ='".$_POST['nomSponsor']."'";
		$connexio=connect();
		$resulEliminaImg=mysqli_query($connexio,$mySqlGaleriaFiramar);
		$resulEliminaImg=mysqli_query($connexio,$mySqlParticipants); 
		$resulEliminaImg=mysqli_query($connexio,$mySqlSponsors);  
		disconnect($connexio);

		echo firaEdicion($tbl_participants,$tbl_sponsors,$tbl_galeriafiramar);
	}


function firaFulls($tbl_firamar){
		$mySql="SELECT `txtFiramar`, `titolFiramar`, `dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' ) AS 'fechaEsp' 
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

function firaEdicion($tbl_firamar,$tbl_participants,$tbl_sponsors,$tbl_galeriafiramar,$tbl_activitatsfiramar,$dataFiramar){
		
		$mySql="SELECT `txtFiramar`, `titolFiramar`, `dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
				FROM $tbl_firamar WHERE `dataFiramar`='".$dataFiramar."'";
		
		$mySqlParticipants="SELECT `idParticipant`, `nomParticipant`, `logoParticipant`, `dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' ) AS 'fechaEsp'
							FROM $tbl_participants WHERE `dataFiramar`='".$dataFiramar."'";
		
		$mySqlSponsors="SELECT `logoSponsor`,`nomSponsor`,`dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
						FROM $tbl_sponsors WHERE `dataFiramar`='".$dataFiramar."'";

		$mySqlGaleriaFiramar="SELECT `idGaleriaFiramar`,`fotoFiramar`,`dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
							FROM $tbl_galeriafiramar WHERE `dataFiramar`='".$dataFiramar."'";

		$mySqlActivitatsFiramar="SELECT `idActivitat`,`horaInici` AS 'horaI' ,DATE_FORMAT(`horaInici`,'%H:%i' ) AS 'horaIni',`horaFi` AS 'horaF',DATE_FORMAT(`horaFi`,'%H:%i' ) AS 'horaFF',`titolActivitat`,`txtActivitat`,`dataFiramar` AS 'fecha' ,DATE_FORMAT(`dataFiramar`,'%d-%m-%Y' )AS 'fechaEsp' 
							FROM $tbl_activitatsfiramar WHERE `dataFiramar`='".$dataFiramar."'";				

		$connexio=connect();
		$resultFiramar=mysqli_query($connexio,$mySql); 
		$resultParticipants=mysqli_query($connexio,$mySqlParticipants); 
		$resultSponsors=mysqli_query($connexio,$mySqlSponsors); 
		$resultGaleriaFiramar=mysqli_query($connexio,$mySqlGaleriaFiramar);
		$resultActivitatsFiramar=mysqli_query($connexio,$mySqlActivitatsFiramar); 
		disconnect($connexio);


		$datos='{"edicioFiramar":';
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
				$datos.=',"activitatsFiramar":';
				$rows = array(); 
				while($r = mysqli_fetch_array($resultActivitatsFiramar)) 
				{
					$rows[] = $r; 
				}
				$datos.=json_encode($rows);
				$datos.='}';
		
		return $datos;
	}
?>