<?php 
	$tbl_categories="categories";
	$tbl_categoriaassociat="categoriaassociat";

	require("../../inc/functions.php");

	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='elim'){
		$mySql="DELETE FROM $tbl_categories WHERE `idCategoria`='".$_POST['idCategoria']."'";

		$connexio=connect();
		$resultCateg=mysqli_query($connexio,$mySql); 
		disconnect($connexio);

		echo llistatCategoria($tbl_categories,$tbl_categoriaassociat);
		// echo $mySql;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='Afegir'){
		$mySql="INSERT INTO $tbl_categories (`nomCategoria`) VALUES ('".replaceFromHtml($_POST['nomCategoria'])."')";
		//  	$connexio=connect();
		//  	$resultCateg=mysqli_query($connexio,$mySql); 
		// disconnect($connexio);
		if (isset($_FILES['fotoNew']) && $_FILES['fotoNew']!="") {
			$fileEx =explode('.',$_FILES["logoUpdate"]["name"]);
			$file =  date("dmYhisv").'.'.$fileEx[count($fileEx)-1];
			$mySql2="UPDATE $tbl_categories
					SET `pictograma`='".$file."'
					WHERE idCategoria='".$_POST['idCategoria']."'";
				//$connexio=connect();
			// $resultCateg=mysqli_query($connexio,$mySql2);
			// disconnect($connexio);
			move_uploaded_file($_FILES["logoUpdate"]["tmp_name"],"../../img/pictogramas/".$file);
			//unlink('../../img/pictogramas/'.$_POST['pictogramaOld']);
			
		}
		// echo llistatCategoria($tbl_categories,$tbl_categoriaassociat);
		echo $mySql;		
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='updateMedia'){
		$fileEx =explode('.',$_FILES["logoUpdate"]["name"]);
		$file =  date("dmyhisv").'.'.$fileEx[count($fileEx)-1];
		$mySql="UPDATE $tbl_categories 
				SET `".$_POST['nomCamp']."`='".$file."'
				WHERE idCategoria='".$_POST['idCategoria']."'";
		$connexio=connect();
		mysqli_query($connexio,$mySql);
		disconnect($connexio);
		move_uploaded_file($_FILES["logoUpdate"]["tmp_name"], "../../img/pictogramas/".$file);
		unlink('../../img/pictogramas/'.$_POST['pictogramaOld']);
		echo $file;
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='Edita'){
		$mySql="UPDATE `$tbl_categories` 
				SET `nomCategoria`='".replaceFromHtml($_POST['nomCategoria'])."' 
				WHERE idCategoria='".$_POST['idCategoria']."'";
		$connexio=connect();
		$resultCateg=mysqli_query($connexio,$mySql);
		disconnect($connexio);
		
		
		echo llistatCategoria($tbl_categories,$tbl_categoriaassociat);
		// echo $mySql;
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
