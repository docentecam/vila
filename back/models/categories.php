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

if(isset($_POST['acc'])&&$_POST['acc']=='list'){
		echo llistatDirectori($tbl_categories);
	}
	function llistatDirectori($tbl_categories){
		$mySql="SELECT `idCategoria`, `pictograma`, `nomCategoria` 
				FROM $tbl_categories";

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
				$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
			}
			return json_encode($rows);
	}
?>
