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
	if(isset($_POST['acc'])&&$_POST['acc']=='upChange'){
		$mySql="DELETE FROM $tbl_categoriaassociat WHERE idAssociat='".$_POST['idAssociat']."' AND principal='S'";
		$mySql3="DELETE FROM $tbl_categoriaassociat WHERE idAssociat='".$_POST['idAssociat']."' AND idCategoria='".$_POST['idCategoria']."'";
		$mySql2="INSERT INTO $tbl_categoriaassociat (`idCategoria`, `idAssociat`, `principal`) VALUES ('".$_POST['idCategoria']."','".$_POST['idAssociat']."','S')";

	// echo $mySql;
	// echo $mySql2;
		$connexio=connect();
		$resultCatPrinc=mysqli_query($connexio,$mySql);
		$resultCatPrinc=mysqli_query($connexio,$mySql3);
		$resultCatPrinc=mysqli_query($connexio,$mySql2);  
		disconnect($connexio);

		echo categAssociat($tbl_categoriaassociat, $_POST['idAssociat']);
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
		echo dadesComers($tbl_directori,$tbl_categories,$tbl_categoriaassociat, $_POST['idAssociat']);
	}
	function dadesComers($tbl_directori,$tbl_categories,$tbl_categoriaassociat, $idAssociat){
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
				$dadesComerc.=',"listCatNotPrinc":'.categNotPrinc($tbl_categories,$tbl_categoriaassociat,$tbl_directori, $_POST['idAssociat']);
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
	function categNotPrinc($tbl_categories,$tbl_categoriaassociat,$tbl_directori, $idAssociat){
		$mySql="SELECT c.`idCategoria`,c.`nomCategoria`,ca.`principal`,a.`idAssociat` 
				FROM `$tbl_categoriaassociat` AS ca 
					LEFT JOIN `$tbl_categories` AS c
					LEFT JOIN  $tbl_directori AS a
					ON a.`idAssociat` =".$idAssociat;
		echo $mySql;
		// $connexio=connect();
		// $resultCat=mysqli_query($connexio,$mySql); 
		// disconnect($connexio);
		// $rows = array(); 
		// 	while($row = mysqli_fetch_array($resultCat)) 
		// 	{
		// 		$rows[] = $row; 
		// 	} 
		// 	for ($i=0; $i < sizeof($rows); $i++) { 
		// 		$rows[$i][1]=replaceFromBBDD($rows[$i][1]);
		// 	}
		// 	return json_encode($rows);
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