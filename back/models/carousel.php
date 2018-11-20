<?php 
	$tbl_carousel="carousel";
	// $tbl_categoriaassociat="";

	require("../../inc/functions.php");

	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
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