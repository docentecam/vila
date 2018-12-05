<?php  
	require("../inc/functions.php");
	$tbl_contactans="contactans";
	$tbl_solicitutssocis="solicitutssocis";
	$tbl_vila="vila";
	if(isset($_POST['acc'])&&$_POST['acc']=='l'){
		$mySql="SELECT `logoVila`,`facebook`, `nom`, `horari`, `telf`, `email`,`LGPD` FROM $tbl_vila";
		$connexio=connect();
		$resultVila=mysqli_query($connexio,$mySql);
		disconnect($connexio);
			
		$rows = array(); 
		while($r = mysqli_fetch_array($resultVila)) 
		{
			$rows[] = $r; 
		}
		echo json_encode($rows);	
	}
	if(isset($_POST['acc'])&&$_POST['acc']=='i'){
		$mySql="INSERT INTO $tbl_contactans (`nomContacte`,`cognomContacte`,`tipus`,`email`, `telf`, `nomEmpresa`,`txtContacte`, `dataContacte`) 
				VALUES  ('".$_POST['nomContacte']."','".$_POST['cognomContacte']."','".$_POST['tipus']."','".$_POST['email']."','".$_POST['telf']."','".$_POST['nomEmpresa']."','".replaceFromHtml($_POST['txtContacte'])."','".date("Y-m-d H:i:s")."')";

				// echo $mySql;
		$connexio=connect();
		$resultContactans=mysqli_query($connexio,$mySql);

		disconnect($connexio);
//TODO VERIFICAR QUE LO INSERTA. $idContactans=mysqli_insert_id
		

		$numContac=1;
		if($numContac!=0){

			$envio=sendMail($_POST['email'],"Missatge rebut per la Vila.",donarFormat("Hola,<b>".$_POST['nomContacte']."</b>! acabem de rebre el teu missatge on deia el següent:<br><br>".$_POST['txtContacte']."<br><br>Aviat contestarem al seu missatge.<br><br>Salutacions!"),"si");
			$estat="ok";
		}
		else{
			$estat="ko";
		}
		

		 echo $estat;

}

	if(isset($_POST['acc'])&&$_POST['acc']=='insertSolicitutssocis'){
		$dataActual=date("Y-m-d H:i:s");

		$mySql="SELECT `email`,`nom`,`URLWeb` FROM $tbl_vila ";
		$mySqlInsertSoci="INSERT INTO $tbl_solicitutssocis (`nomComercial`,`sectorComercial`,`adreca`,`telf`,`email`,`dataSolicitut`,`personaContacte`,`horari`)
				VALUES ('".$_POST['nomComercial']."','".$_POST['sectorComercial']."','".$_POST['adreca']."','".$_POST['telf']."','".$_POST['email']."','".$dataActual."','".$_POST['personaContacte']."','".$_POST['horari']."')";

 		 $connexio=connect();
		 $resultVila=mysqli_query($connexio,$mySql); 
		 $resultSolicitutSoci=mysqli_query($connexio,$mySqlInsertSoci); 
		 disconnect($connexio);		
		 $dadesVila=mysqli_fetch_row($resultVila);
		
		$envio=sendMail($_POST['email'],"Benvinguts!",donarFormat("Hola <b>".$_POST['nomComercial']."</b>!<br>Gràcies pel vostre missatge, aviat passarem a visitar-vos.
			"),"soci");
		echo $envio;
		

}

?>