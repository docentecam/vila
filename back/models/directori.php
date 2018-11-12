<?php 
	$tbl_directori="associats";
	$tbl_categories="categories";
	$tbl_categoriaassociat="categoriaassociat";
	$tbl_galeriaassociats="galeriaassociats";

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

			move_uploaded_file($_FILES[$numUp]["tmp_name"], "../../img/galeriaassociats/".$file);
			$mySql="INSERT INTO `galeriaassociats`(`fotoGaleria`, `idAssociat`) 	VALUES ('".$file."','".$_POST['idAssociat']."')";
			mysqli_query($connexio,$mySql);
			$j++;
	    }
	    disconnect($connexio);
		echo  galeriaAssociats($tbl_galeriaassociats,$_POST['idAssociat']);
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='updateMedia'){
		$fileEx =explode('.',$_FILES["logoUpdate"]["name"]);
		$file =  date("dmYhisv").'.'.$fileEx[count($fileEx)-1];
		$mySql="UPDATE $tbl_directori 
				SET `".$_POST['nomCamp']."`='".$file."'
				WHERE idAssociat='".$_POST['idAssociat']."'";
		$connexio=connect();
		mysqli_query($connexio,$mySql);
		disconnect($connexio);
		move_uploaded_file($_FILES["logoUpdate"]["tmp_name"], "../../img/associats/".$file);
		unlink('../../img/associats/'.$_POST['logoAssociatOld']);

		echo $file;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='delImg'){
		$mySql="DELETE FROM $tbl_galeriaassociats WHERE idAssociat='".$_POST['idAssociat']."' AND idGaleria='".$_POST['idGaleria']."'";
		// echo $mySql;
		$connexio=connect();
		$resultComerc=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		
		$dadesComerc='{"galeriaAssociats":'.galeriaAssociats($tbl_galeriaassociats,$_POST['idAssociat']).'}';
		echo $dadesComerc;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='del'){
		$mySql="DELETE FROM $tbl_categoriaassociat WHERE idAssociat='".$_POST['idAssociat']."' AND idCategoria='".$_POST['idCategoria']."'";
		// echo $mySql;
		$connexio=connect();
		$resultComerc=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		
		$dadesComerc='{"catNotPrinc":'.categAssocNotPrinc($tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']);
		$dadesComerc.=',"listCatNotPrinc":'.categNotPrinc($tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']).'}';
		echo $dadesComerc;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='af'){
		$mySql="INSERT INTO $tbl_categoriaassociat (`idCategoria`, `idAssociat`, `principal`) 
				VALUES ('".$_POST['idCategoria']."','".$_POST['idAssociat']."','N')";
		// echo $mySql;
		$connexio=connect();
		$resultComerc=mysqli_query($connexio,$mySql);
		disconnect($connexio);

		$dadesComerc='{"catNotPrinc":'.categAssocNotPrinc($tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']);
		$dadesComerc.=',"listCatNotPrinc":'.categNotPrinc($tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']).'}';
		echo $dadesComerc;


	}
	if(isset($_POST['acc'])&&$_POST['acc']=='up'){
		$mySql="UPDATE $tbl_directori SET `nomAssociat`='".replaceFromHtml($_POST['nomAssociat'])."', `adreca`='".replaceFromHtml($_POST['adreca'])."', `telf1`='".$_POST['telf1']."', `horari`='".replaceFromHtml($_POST['horari'])."', `facebook`='".$_POST['facebook']."', `telf2`='".$_POST['telf2']."', `whatsapp`='".$_POST['whatsapp']."', `latitud`='".$_POST['latitud']."', `longitud`='".$_POST['longitud']."', `txtAssociat`='".replaceFromHtml($_POST['txtAssociat'])."', `URLWeb`='".$_POST['URLWeb']."', `email`='".$_POST['email']."' WHERE idAssociat='".$_POST['idAssociat']."'";
		$mySql2="DELETE FROM $tbl_categoriaassociat WHERE idAssociat='".$_POST['idAssociat']."' AND principal='S'";
		$mySql3="DELETE FROM $tbl_categoriaassociat WHERE idAssociat='".$_POST['idAssociat']."' AND idCategoria='".$_POST['idCategoria']."'";
		$mySql4="INSERT INTO $tbl_categoriaassociat (`idCategoria`, `idAssociat`, `principal`) VALUES ('".$_POST['idCategoria']."','".$_POST['idAssociat']."','S')";
		// echo $mySql;
		$connexio=connect();
		$resultComerc=mysqli_query($connexio,$mySql);
		$resultCatPrinc=mysqli_query($connexio,$mySql2);
		$resultCatPrinc=mysqli_query($connexio,$mySql3);
		$resultCatPrinc=mysqli_query($connexio,$mySql4); 
		disconnect($connexio);

		echo dadesComers($tbl_directori,$tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']);
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		echo dadesComers($tbl_directori,$tbl_categories,$tbl_categoriaassociat,$tbl_galeriaassociats, $_POST['idAssociat']);
	}
	function dadesComers($tbl_directori,$tbl_categories,$tbl_categoriaassociat,$tbl_galeriaassociats, $idAssociat){
		$mySql="SELECT `a`.`idAssociat`,`a`.`nomAssociat`,`a`.`logoAssociat`,`a`.`horari`,`a`.`txtAssociat`,`a`.`facebook`,`a`.`actiu`,`a`.`adreca`,`a`.`telf1`,`a`.`telf2`,`a`.`whatsapp`,`a`.`email`,`a`.`latitud`,`a`.`longitud`,`a`.`URLWeb`
				FROM `$tbl_directori` AS a 
				WHERE `a`.`idAssociat`=".$_POST['idAssociat'];
				// echo $mySql;
		$connexio=connect();
		$resultComer=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$dadesComerc='{"comerc":';
			$rows = array(); 
				while($row = mysqli_fetch_array($resultComer)) 
				{
					$rows[] = $row; 
				} 
				for ($i=0; $i < sizeof($rows); $i++) { 
					$rows[$i][0]=replaceFromBBDD($rows[$i][0]);
					$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
					$rows[$i][3]=replaceFromBBDD($rows[$i][3]);
					$rows[$i][6]=replaceFromBBDD($rows[$i][6]);
					$rows[$i][10]=replaceFromBBDD($rows[$i][10]);
					$rows[$i][13]=replaceFromBBDD($rows[$i][13]);
					$rows[$i][14]=replaceFromBBDD($rows[$i][14]);
				}
				$dadesComerc.= json_encode($rows);
				$dadesComerc.=',"catego":'.categories($tbl_categories);
				$dadesComerc.=',"catPrinc":'.categAssociat($tbl_categoriaassociat, $_POST['idAssociat']);
				$dadesComerc.=',"catNotPrinc":'.categAssocNotPrinc($tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']);
				$dadesComerc.=',"listCatNotPrinc":'.categNotPrinc($tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']);
				$dadesComerc.=',"galeriaAssociats":'.galeriaAssociats($tbl_galeriaassociats,$_POST['idAssociat']);
				$dadesComerc.='}';		
		return $dadesComerc;

	}
	function categAssociat($tbl_categoriaassociat, $idAssociat){
		$mySql="SELECT `idCategoria` FROM `$tbl_categoriaassociat` WHERE idAssociat=$idAssociat AND principal='S'" ;
		$connexio=connect();
		$resultCatPrinc=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultCatPrinc)) 
			{
				$rows[] = $row; 
			} 
			return json_encode($rows);
	}
	function categories($tbl_categories){
		$mySql="SELECT `idCategoria`, `pictograma`, `nomCategoria` FROM `$tbl_categories`";
		 $connexio=connect();
		$resultCat=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultCat)) 
			{
				$rows[] = $row; 
			} 
			for ($i=0; $i < sizeof($rows); $i++) { 
				$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
			}
			return json_encode($rows);
	}
	function categAssocNotPrinc($tbl_categories,$tbl_categoriaassociat, $idAssociat){
		$mySql="SELECT `idCategoria`,`nomCategoria` 
				FROM `$tbl_categories` 
				WHERE idCategoria NOT IN (
						SELECT idCategoria
						FROM $tbl_categoriaassociat
						WHERE idAssociat=".$idAssociat.")";
		$connexio=connect();
		$resultCat=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultCat)) 
			{
				$rows[] = $row; 
			} 
			for ($i=0; $i < sizeof($rows); $i++) { 
				$rows[$i][1]=replaceFromBBDD($rows[$i][1]);
			}
			return json_encode($rows);
	}
	function categNotPrinc($tbl_categories,$tbl_categoriaassociat, $idAssociat){
		$mySql="SELECT c.`idCategoria` ,c.`nomCategoria`,ca.`principal`, `ca`.`idAssociat`
				FROM `$tbl_categoriaassociat` AS ca
				    LEFT JOIN `categories` AS c 
				    ON `ca`.`idCategoria` = `c`.`idCategoria`
				WHERE ((`ca`.`principal` ='N') AND (`ca`.`idAssociat` ='".$idAssociat."'))";
		// echo $mySql;
		$connexio=connect();
		$resultCat=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultCat)) 
			{
				$rows[] = $row; 
			} 
			for ($i=0; $i < sizeof($rows); $i++) { 
				$rows[$i][1]=replaceFromBBDD($rows[$i][1]);
			}
			return json_encode($rows);
	}
	function galeriaAssociats($tbl_galeriaassociats,$idAssociat){
		$mySql="SELECT `idGaleria`, `fotoGaleria`, `descripcio`, `idAssociat` 
				FROM $tbl_galeriaassociats
				WHERE `idAssociat` ='".$idAssociat."'";
		// echo $mySql;
		$connexio=connect();
		$resultCat=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultCat)) 
			{
				$rows[] = $row; 
			} 
			for ($i=0; $i < sizeof($rows); $i++) { 
				$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
			}
			return json_encode($rows);
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='list'){
		echo llistatDirectori($tbl_directori,$tbl_categories,$tbl_categoriaassociat);
	}
	function llistatDirectori($tbl_directori,$tbl_categories,$tbl_categoriaassociat){
		$mySql="SELECT `a`.`idAssociat`,`a`.`nomAssociat`,`a`.`horari`,`a`.`facebook`,`a`.`actiu`,`a`.`adreca`,`a`.`telf1`,`a`.`telf2`,`a`.`whatsapp`,`a`.`email`,`a`.`URLWeb`, `c`.`nomCategoria`, `ca`.`principal`
				FROM `$tbl_categoriaassociat` AS ca
				    LEFT JOIN `$tbl_directori` AS a ON `ca`.`idAssociat` = `a`.`idAssociat`
				    LEFT JOIN `$tbl_categories` AS c ON `ca`.`idCategoria` = `c`.`idCategoria`
				WHERE (`ca`.`principal` ='S')";

				// echo $mySql;
		$connexio=connect();
		$resultDirect=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($row = mysqli_fetch_array($resultDirect)) 
			{
				$rows[] = $row; 
			} 
			for ($i=0; $i < sizeof($rows); $i++) { 
				$rows[$i][0]=replaceFromBBDD($rows[$i][0]);
				$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
				$rows[$i][4]=replaceFromBBDD($rows[$i][4]);
				$rows[$i][8]=replaceFromBBDD($rows[$i][8]);
				$rows[$i][9]=replaceFromBBDD($rows[$i][9]);
			}
			return json_encode($rows);
	}
?>