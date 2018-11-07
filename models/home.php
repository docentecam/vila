<?php 
	
	$tbl_vila="vila";
	$tbl_noticies="noticies";
	$tbl_banners="banners";
	$tbl_carousel="carousel";
	$tbl_associats="associats";

	require("../inc/functions.php");

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$dades= '{"dadesVila": ';
		$dades.= mostrarVila($tbl_vila);
		$dades.= ',"dadesNoticies":';	
		$dades.= mostrarNoticies($tbl_noticies);
		$dades.= ',"dadesBanners":';	
		$dades.= mostrarBanners($tbl_banners);
		$dades.= ',"dadesCarousel":';	
		$dades.= mostrarCarousel($tbl_carousel);
		$dades.= ',"dadesAssociats":';	
		$dades.= mostrarAssociats($tbl_associats);

		$dades.="}";

		echo $dades;
		}

	function mostrarVila($tbl_vila){
			$mySql="SELECT `logoBolsa`, `logoVila`, `facebook`	FROM $tbl_vila";
			$connexio=connect();
			$resultVila=mysqli_query($connexio,$mySql); 
			disconnect($connexio);

			$rows = array(); 

			while($r = mysqli_fetch_array($resultVila)) 
			{
				$rows[] = $r; 
			} 
					
			return json_encode($rows);
		}

	function mostrarNoticies($tbl_noticies){
			$mySql="SELECT `idNoticia`, `titolNoticia`, `txtNoticia`, DATE_FORMAT(`dataNoticia`,'%d-%m-%Y') AS 'dataNoticia', `principal`, `fotoNoticia` FROM $tbl_noticies";
			$connexio=connect();
			$resultNoticies=mysqli_query($connexio,$mySql); 
			disconnect($connexio);

			$rows = array(); 

			while($r = mysqli_fetch_array($resultNoticies)) 
			{
				$rows[] = $r; 
			} 
					
			return json_encode($rows);
		}

	function mostrarNoticies($tbl_noticies){
			$mySql="SELECT `idNoticia`, `titolNoticia`, `txtNoticia`, DATE_FORMAT(`dataNoticia`,'%d-%m-%Y') AS 'dataNoticia', `principal`, `fotoNoticia` FROM $tbl_noticies";
			$connexio=connect();
			$resultAssociats=mysqli_query($connexio,$mySql); 
			disconnect($connexio);

			$rows = array(); 

			while($r = mysqli_fetch_array($resultAssociats)) 
			{
				$rows[] = $r; 
			} 
					
			return json_encode($rows);
		}

	function mostrarNoticies($tbl_noticies){
			$mySql="SELECT `idNoticia`, `titolNoticia`, `txtNoticia`, DATE_FORMAT(`dataNoticia`,'%d-%m-%Y') AS 'dataNoticia', `principal`, `fotoNoticia` FROM $tbl_noticies";
			$connexio=connect();
			$resultAssociats=mysqli_query($connexio,$mySql); 
			disconnect($connexio);

			$rows = array(); 

			while($r = mysqli_fetch_array($resultAssociats)) 
			{
				$rows[] = $r; 
			} 
					
			return json_encode($rows);
		}
			
		// $i=0; 


		// $dataHome.='","noticiesDestacades":[';

		// $i=0; 
		// while ($row=mysqli_fetch_array($resultDadesNoticies)) {
		// 	if ($i!=0) {
		// 		$dataHome.=",";	
		// 	}
		// 	$i++;
		// 	$dataHome.='{"idNoticia":"'.$row['idNoticia'].'","dataNoticia":"'.$row['dataNoticia'].'","principal":"'.$row['principal'].'","titular":"'.replaceFromBBDD($row['titolNoticia']).'","descripcio":"'.replaceFromBBDD($row['txtNoticia']).'","fotoNoticia":"'.$row['fotoNoticia'].'"}';
		// }

		// $dataHome.=']}';
		// echo $dataHome;
	}
?>