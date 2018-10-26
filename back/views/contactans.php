
<!-- <?php
	// session_start();

	// if (!isset($_SESSION['vila']['email'])) 
	{
		// header("location: ../");
	}
 ?> -->
	<div class="row text-center mt-4 mb-3 titleSocis">
		<h1 class="col">Safata d'Entrada</h1>
	</div>
	<div id="tabstid" class="row tabst">
		<table border="1" class="tabcont col-12 col-lg-8 offset-lg-2 offset-lg-1 text-center textTabla">
			<tr>
				<th class="cursor" ng-click="columnOrder('nom')">Nom</th>
				<th class="cursor" ng-click="columnOrder('email')">Cognom</th>
				<th class="cursor" ng-click="columnOrder('telefon')">Tipus</th>
				<th class="cursor" ng-click="columnOrder('fecha')">Nom Empresa</th>
				<th class="cursor" ng-click="columnOrder('telefon')">Telèfon</th>
				<th class="cursor" ng-click="columnOrder('fecha')">Correu electrònic</th>
				<th class="cursor" ng-click="columnOrder('dubtes')">Missatge</th>
			</tr>
			<tr ng-repeat="contacta in contactans | orderBy:order">
				<td>{{contacta.nomContacta}}</td>
				<td>{{contacta.cognomContacta}}</td>
				<td>{{contacta.tipus}}</td>
				<td>{{contacta.nomEmpresa}}</td>
				<td>{{contacta.telf}}</td>
				<td>{{contacta.email}}</td>
				<td>{{contacta.txtContacta}}</td>
			</tr>
		</table>	
	</div>	
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none">
	</button>
