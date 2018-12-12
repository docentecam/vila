<?php 
	$tbl_carousel="carousel";
	$tbl_banner="banners";
	$tbl_directori="associats";

	require("../../inc/functions.php");

	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='newBanner'){
		$mySql="INSERT INTO `$tbl_banner`(`URLWeb`)
				VALUES ('".$_POST['URLWeb']."')";
		$connexio=connect();
		$resultBanner=mysqli_query($connexio,$mySql);
		$idBanner=mysqli_insert_id($connexio);
		disconnect($connexio);
		if (isset($_FILES['fotoBanner']) && $_FILES['fotoBanner']!=""){
			$fileEx =explode('.',$_FILES["fotoBanner"]["name"]);
			$file =  date("dmyhisv").'.'.$fileEx[count($fileEx)-1];
			$mySql2="UPDATE $tbl_banner
					SET `fotoBanner`='".$file."'
					WHERE idBanner='".$idBanner."'";
			$connexio=connect();
			$resultBanner=mysqli_query($connexio,$mySql2);
			disconnect($connexio);
			move_uploaded_file($_FILES["fotoBanner"]["tmp_name"], "../../img/banners/".$file);
			unlink("../../img/banners/".$_POST['fotoBanner']);
		}
		
		echo fotosBanner($tbl_banner,$tbl_directori);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='upImg'){
		$fileEx =explode('.',$_FILES["bannerUpdate"]["name"]);
		$file =  date("dmYhisv").'.'.$fileEx[count($fileEx)-1];
		$mySql="INSERT INTO `$tbl_banner`(`fotoBanner`)
				VALUES ('".$file."')";
		$connexio=connect();
		$resultBanner=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		move_uploaded_file($_FILES["bannerUpdate"]["tmp_name"], "../../img/banners/".$file);

		echo fotosBanner($tbl_banner,$tbl_directori);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='dImg'){
		$mySql="DELETE FROM $tbl_banner WHERE `idBanner`='".$_POST['idBanner']."'";
		if(isset($_POST['logo'])&&$_POST['logo']!='')
		{
			unlink("../../img/banners/".$_POST['logo']);
		}
		$connexio=connect();
		$resultBanner=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		echo fotosBanner($tbl_banner,$tbl_directori);
		// echo $mySql;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='b'){
		echo fotosBanner($tbl_banner,$tbl_directori);
	}
	function fotosBanner($tbl_banner,$tbl_directori){
		$mySql="SELECT `idBanner`, `fotoBanner`, `URLWeb`
				FROM $tbl_banner";
		$mySql2="SELECT `nomAssociat`,`idAssociat`
				FROM `$tbl_directori`";
				// echo $mySql;
		$connexio=connect();
		$resultBar=mysqli_query($connexio,$mySql);
		$resultAso=mysqli_query($connexio,$mySql2);  
		disconnect($connexio);
		$datos='{"banner":';
				$rows = array(); 
				while($r = mysqli_fetch_array($resultBar)) 
				{
					$rows[] = $r; 
				} 
				$datos.=json_encode($rows);
				$datos.=',"associats":';
				$rows = array(); 
				while($r = mysqli_fetch_array($resultAso)) 
				{
					$rows[] = $r; 
				}
				$datos.=json_encode($rows);
				$datos.='}';
		
		return $datos;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='uploadImg'){
		//$_FILES[‘nombrePost’]. El nombre entre comillas, será el que nos envíen por post o get desde el formulario.
		// $datos="entra en model<br>"; 
	    $cantImatge=$_POST['cantImatge']+1;
	    $connexio=connect();
		
	    $j=0;
	    while($j<$cantImatge) {
		    $numUp='uploadedFile'.$j;
		    $fileEx =explode('.',$_FILES[$numUp]["name"]);
			$file =  date("dmYhisv").substr($fileEx[0],-3,3).'.'.$fileEx[count($fileEx)-1];
			//$datos.=$j."--".$_FILES[$numUp]["tmp_name"]."-"."../../img/galeriaassociats/".$file."<br>"; 

			move_uploaded_file($_FILES[$numUp]["tmp_name"], "../../img/carousel/".$file);
			$mySql="INSERT INTO `$tbl_carousel`(`fotoCarousel`) 	
					VALUES ('".$file."')";
			mysqli_query($connexio,$mySql);
			$j++;
	    }
	    disconnect($connexio);
		echo  fotosCarousel($tbl_carousel);
		// echo $mySql;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='delImg'){
		$mySql="DELETE FROM $tbl_carousel WHERE `idCarousel`='".$_POST['idCarousel']."'";
		if(isset($_POST['logo'])&&$_POST['logo']!='')
		{
			unlink("../../img/carousel/".$_POST['logo']);
		}
		$connexio=connect();
		$resultCateg=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		echo fotosCarousel($tbl_carousel);
		// echo $mySql;
	}
		if(isset($_POST['acc'])&&$_POST['acc']=='c'){
		echo fotosCarousel($tbl_carousel);
	}
	function fotosCarousel($tbl_carousel){
		$mySql="SELECT `idCarousel`, `fotoCarousel`
				FROM $tbl_carousel";

				// echo $mySql;
		$connexio=connect();
		$resultCar=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultCar)) 
			{
				$rows[] = $row; 
			}
			
			return json_encode($rows);
	}
?>