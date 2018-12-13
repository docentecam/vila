<?php
	function connect(){
		$connexio=@mysqli_connect("localhost","root","","vila");

		// $connexio=@mysqli_connect("bbdd.codigitals.com.es","ddb118414","VilaProves@2018","ddb118414");

		if(!$connexio){
			die("error al conectar");
		}
		mysqli_set_charset($connexio,"utf8");
		mysqli_query($connexio,"SET lc_time_names='ca_ES'");
		return($connexio);	
	}
	function disconnect($connexio){
		mysqli_close($connexio);
	}
	function replaceFromHtml($jsonArray)
	{
		$normalChars = str_replace(array("'",'"',"\\n"), array("\'",'\"',"\r\n"),$jsonArray);
		return $normalChars;
	}
	function replaceFromBBDD($jsonArray)
	{
		$normalChars = htmlspecialchars($jsonArray);
		$normalChars = str_replace(array('&quot;', '&amp;', '&lt;', '&gt;'), array('"', "&", "<", ">"), $normalChars);
		$normalChars = str_replace(array('"'), array('\"'), $normalChars);
		$normalChars = str_replace(array("\r\n", "\r", "\n"),"\\n" ,$normalChars);
		return $normalChars;
	}
		function donarFormat($text)
	{
		$tbl_Vila="vila";
		$mySql="SELECT `logoVila`,`facebook`, `nom`, `horari`, `telf`, `email`,`LGPD`,`URLWeb`
				FROM $tbl_Vila";
				
		$connexio=connect();
		$resultMail=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($r = mysqli_fetch_array($resultMail)) 
			{
				$logoVila= $r['logoVila'];
				$nomVila= $r['nom'];
				$telfVila= $r['telf']; 
				$emailVila= $r['email']; 
				$facebook= $r['facebook'];
				$horari= $r['horari'];
				$LGPD= $r['LGPD'];
				$URLWeb= $r['URLWeb'];
			}
			
		$newBody=
				'<!DOCTYPE html>
					<html>
						<head>
							<title></title>
							<meta charset="utf-8">
							<style>
								*{
									text-align: center;
									font-family: "Asap", sans-serif;
								}
								a{
									color:#000000!important;
								}

								a:link{
									color: #000000!important;
								    text-decoration: none;
								}
								a:visited{
									color: #000000!important;
								    text-decoration: none;
								}
								a:hover{
									color: #000000!important;
								    text-decoration: none;
								}
								.rgpd{
									text-align:left;
									font-size: 14px;
									color:#808080;
								}

								.estilButton{
									background-color: #4CAF50;
								    border: none;
								    color: white;
								    padding: 15px 32px;
								    text-align: center;
								    text-decoration: none;
								    display: inline-block;
								    font-size: 16px;
								    margin: 4px 2px; 
								    cursor:pointer;
								}

								.estilWelcome{
									font-size:19px;
									color:#4ce0e2;
								}

								.spBold{
									font-size: 14px;
									font-weight:bold;
								}

								.dividerBl{
									height:2px; 
									background: #000 
								}

								.tamLogo{
								width:80%;
								}
								@media (min-width: 576px){
										*{
											font-size:17px;
										}
										.tamLogo{
										width:30%;
									} 
								}
							</style>
						</head>
						<body>
							<table width="100%">
								<tr>
									<td width="20%"></td>
									<td width="60%"><p>' .$text.'</p></td>
									<td width="20%"></td>
								</tr>
								<tr>
									<td width="20%"></td>
									<td width="60%"><a href="'.$URLWeb.'" target="_blank"><img src="cid:my-attach1" alt="Logo" class="tamLogo"></a></td>
									<td width="20%"></td>
								</tr>
								<tr height="20rem"></tr>
								<tr>
									<td width="20%"">
										<td width="60%"">
											<hr style="border:1px solid #dddddd;"">
										</td>
										<td width="20%""></td>
									</td>
								</tr>
								<tr height="10rem"></tr>
								
								<tr><td width="20%"></td>
									<td width="60%">
										<p class="rgpd">La teva privacitat és molt important. Per això, de part de la '.$nomVila.', creiem que és necessari llegir la nova normativa europea de protecció de dades:
										<br>
										'.$LGPD.'
										</p><br>
									</td><td width="20%"></td>
								</tr>
								<tr><td width="20%"> </td><td width="60%">
									<p>Segueix-nos!</p>
									<div style="color:black;">
									<a href="'.$facebook.'" target="_blank"><img src="cid:my-attachface" alt="Logo Facebook" ></a>
									</div>
									<hr style="border: 5px dashed #e7ab3b; margin-left:35%; margin-right:35%;">
									</td><td width="20%"></td><br><br>

								</tr>
								<tr><td width="20%"> </td><td width="60%">
									 <a href="tel:'.$telfVila.'" target="_blank">'.$telfVila.'</a><br>
									 <a href="mailto:'.$emailVila.'" target="_blank">'.$emailVila.'</a></p>
								</tr>
							</table>
						</body>
					</html>';
		
		return $newBody;
	}

		function sendMail($mailTo,$subject,$body,$copia=""){
		$tbl_vila="vila";

		$mySql="SELECT `nom`,`email`,`telf`, `pasMail`,`logoVila` 
				FROM $tbl_vila";
				
		$connexio=connect();
		$resultMail=mysqli_query($connexio,$mySql); 
		disconnect($connexio);
		$rows = array(); 
			while($r = mysqli_fetch_array($resultMail)) 
			{
				$nomVila= $r['nom'];
				$telfVila= $r['telf']; 
				$emailVila= $r['email']; 
				$pasMail= $r['pasMail']; 
				$logoVila= $r['logoVila']; 
			} 
		error_reporting(0);
		require_once"phpmailer/phpmailer.class.php";
		$mail = new PHPMailer();
		//datos cuenta
		$mail->IsSMTP(); //envío vía SMTP
		$mail->SMTPAuth = true;// turn on SMTP authentication
		$mail->SMTPSecure="tls";
		$mail->Host = 'smtp.dondominio.com'; 
		$mail->Port=587;
		// $mail->SMTPSecure="ssl";
		// $mail->Host = 'smtp.gmail.com'; 
		// $mail->Port=465;
		$mail->Username=$emailVila;// SMTP usuario
		$mail->Password=$pasMail; // SMTP password
		$mail->FromName = $nomVila; //Nombre a mostrar
		$mail->From = $emailVila;  //Cuenta de envío.

		// $mail->SMTPDebug = 1; //para que muestre los fallos de conexión SMTP
		// $mail->SMTPDebug = 2; //para que muestre lo que va haciendo conexión SMTP

		
		$mail->AddReplyTo($emailVila);//Dirección de respuesta
		$mail->AddAddress($mailTo);//Dirección de envío.
		$mail->Timeout=5;
		$mail->IsHTML(true); 
		$mail->CharSet = 'UTF-8';

		$mail->Subject = $subject;
		//INSERTAR IMAGEN EN EL CUERPO DEL MAIL
		//$mail->AddEmbeddedImage('imagen.png','myfoto');
		if ($copia=="si" || $copia=="soci"){
			$mail->AddEmbeddedImage("../img/".$logoVila, "my-attach1");
			$mail->AddEmbeddedImage("../img/facebook.png", "my-attachface");

		}
		else{
			$mail->AddEmbeddedImage("../../img/".$logoVila, "my-attach1");
			$mail->AddEmbeddedImage("../../img/facebook.png", "my-attachface");
		}
		
		$mail->Body = $body;
		
		$mail->AltBody = $body;
		//$mail->AddAttachment("ruta/".$nombre_archivo);

		$exito = $mail->Send();
		$mail->ClearAddresses(); //Eliminamos direcciones destino(por si reutilizamos)

		if ($copia=="si") {
			$mail->Subject = "Copia de contacte per formulari ";
			$mail->AddAddress($emailVila);//Dirección de envío.
			$exito = $mail->Send();
			$mail->ClearAddresses();
		}
		
		// Informamos tanto si ha ido bien como si ha ido mal
		if(!$exito){
			return  $mail->ErrorInfo;		
		}
		else{
			return 'ok';
		}

	}

?>