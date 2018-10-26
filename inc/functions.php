<?php
	function connect(){
		
		 $connexio=@mysqli_connect("localhost","root","","vila");

		//$connexio=@mysqli_connect("bbdd.codigitals.com.es","ddbb118414","VilaProves@2018","ddbb118414");
		
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

?>