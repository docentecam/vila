<?php
require("../inc/functions.php");
$tbl_vila="vila";
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){ 
		echo mostrarVila($tbl_vila);
	}
		function mostrarVila($tbl_vila){
				$mySql="SELECT `email`, `logoVila`, `facebook`,`telf`,`nom`,`favIcon`, `cabeceraFiramar`, `cabeceraAssociacio`	FROM $tbl_vila";
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

?>