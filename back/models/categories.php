<?php 
	$tbl_categories="categories";
	$tbl_categoriaassociat="categoriaassociat";

	require("../../inc/functions.php");

	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}

if(isset($_POST['acc'])&&$_POST['acc']=='list'){
		echo llistatCategoria($tbl_categories,$tbl_categoriaassociat);
	}
	function llistatCategoria($tbl_categories,$tbl_categoriaassociat){
		$mySql="SELECT `idCategoria`, `pictograma`, `nomCategoria` 
				FROM $tbl_categories";

				// echo $mySql;
		$connexio=connect();
		$resultCateg=mysqli_query($connexio,$mySql); 
		
		$rows = array(); 
			while($row = mysqli_fetch_array($resultCateg)) 
			{
				$mySql2="SELECT COUNT(idAssociat) 
						FROM $tbl_categoriaassociat 
						WHERE idCategoria=".$row[0];

				// echo $mySql;
				$resultCategAssoc=mysqli_query($connexio,$mySql2); 
				$cant=mysqli_fetch_row($resultCategAssoc);
				array_push($row, $cant);
				$rows[] = $row; 
			} 
			for ($i=0; $i < sizeof($rows); $i++) { 
				$rows[$i][2]=replaceFromBBDD($rows[$i][2]);
			}
			disconnect($connexio);
			return json_encode($rows);
	}
?>
