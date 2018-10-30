<!DOCTYPE html> 
<html data-ng-app="vila"> 
	<head>
		<title ng-bind="title"></title>
		<meta charset="utf-8">
		<link rel="icon" ng-href="../img/{{favIcon}}" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="../js/angular.js"></script>
		<script src="../js/angular-route.js"></script>
		<script src="controllers/app.js"></script>
		<script src="controllers/vila.js"></script>
		<script>
				$(document).ready(function () {
  					$(".reduceNav").click(function(event) {
    				$(".navReduced").collapse('hide');
					});
				});
		</script>
	</head>

	<body>

<?php session_start();	?>
	
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
  			<a class="navbar-brand" href="#">
    			<img class="imglogonav" ng-src="../img/{{logo}}" alt="Logo vila">
 		    </a>
 		    <button class="navbar-toggler navNoline" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    			<span class="navbar-toggler-icon"></span>
  			</button>
  			<div class="collapse navbar-collapse navReduced" id="navbarNavDropdown">
   			 	<ul class="navbar-nav">
     				<li class="nav-item active reduceNav">
        				<a class="nav-link" href="#/associacio">Manteniment Associacio</a>
     				</li>
      				<li class="nav-item reduceNav">
        				<a class="nav-link" href="#/directori">Manteniment Directori</a>
      				</li>
      				<li class="nav-item reduceNav">
        				<a class="nav-link" href="#/solicitutsoci">Llistat Solicitud de socis</a>
      				</li>
     				<li class="nav-item reduceNav">
       					<a class="nav-link" href="#/contactans">Contacta´ns</a>
     				</li>
     				<li class="nav-item reduceNav">
       					<a class="nav-link" href="#/">Titulo 4</a>
     				</li>
     				<li class="nav-item p d-block d-lg-none reduceNav">

    					<a class="nav-link pt-1 pl-5 fas fa-sign-out-alt fa-2x" href="#/logout"></a>
    					<!-- log out ^^ -->
     				</li>			
				</ul>

	

			</div>

					<ul class="navbar-nav flex-row ml-md-auto d-none d-lg-flex">
						<li class="nav-item pt-2 pr-3">

     				
     					</li>
     					<li class="nav-item ml-3">
    						<a class=" nav-link pt-1 fas fa-sign-out-alt fa-2x" href="#/logout"></a>
     					</li>
     				</ul>	
    			
		</nav>
	
		<div class="container-fluid"> 
			
			<div id="cargador" ng-show="cargador">
				<img class="preloader" ng-src="../img/loading.svg">
			</div>
			<div data-ng-view="">		 		
				
			</div>
		
		</div>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>

</html>