<?php 
	$tbl_directori="associats";
	$tbl_categories="categories";
	$tbl_categoriaassociat="categoriaassociat";

	require("../../inc/functions.php");

	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}

	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		echo llistatDirectori($tbl_directori,$tbl_categories,$tbl_categoriaassociat);
	}
	function llistatDirectori($tbl_directori,$tbl_categories,$tbl_categoriaassociat){
		$mySql="SELECT `a`.`nomAssociat`,`a`.`logoAssociat`,`a`.`horari`,`a`.`txtAssociat`,`a`.`facebook`,`a`.`actiu`,`a`.`adreca`,`a`.`telf1`,`a`.`telf2`,`a`.`whatsapp`,`a`.`email`,`a`.`latitud`,`a`.`longitud`,`a`.`URLWeb`, `c`.`nomCategoria`, `ca`.`principal`
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
				$rows[$i][3]=replaceFromBBDD($rows[$i][3]);
				$rows[$i][6]=replaceFromBBDD($rows[$i][6]);
				$rows[$i][10]=replaceFromBBDD($rows[$i][10]);
				$rows[$i][13]=replaceFromBBDD($rows[$i][13]);
				$rows[$i][14]=replaceFromBBDD($rows[$i][14]);
			}
			return json_encode($rows);
	}
?>