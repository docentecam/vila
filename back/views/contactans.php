
<?php
	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
 ?> 
	<div class="row text-center mt-4 mb-3 titleSocis">
		<h1 class="col">Safata d'Entrada</h1>
	</div>
	<div class="row table-responsive divTable">
		<table border="1" class="divTable col-12 col-lg-10 offset-lg-1 text-center tablaSocis">
			<tr>
				<th class="cursor" ng-click="columnOrder('nomContacte')">Nom</th>
				<th class="cursor" ng-click="columnOrder('cognomContacte')">Cognom</th>
				<th class="cursor" ng-click="columnOrder('tipus')">Tipus</th>
				<th class="cursor" ng-click="columnOrder('nomEmpresa')">Nom Empresa</th>
				<th class="cursor" ng-click="columnOrder('telf')">Telèfon</th>
				<th class="cursor" ng-click="columnOrder('email')">Correu electrònic</th>
				<th class="cursor" ng-click="columnOrder('dataContacte')">Data del missatge</th>
				<th class="cursor" ng-click="columnOrder('txtContacte')">Missatge</th>
			</tr>
			<tr ng-repeat="contacta in contactans | orderBy:order">
				<td>{{contacta.nomContacte}}</td>
				<td>{{contacta.cognomContacte}}</td>
				<td>{{contacta.tipus}}</td>
				<td>{{contacta.nomEmpresa}}<span ng-if="contacta.nomEmpresa==null">---</span></td>
				<td>{{contacta.telf}}<span ng-if="contacta.telf==null">---</span></td>
				<td>{{contacta.email}}<span ng-show="contacta.email==null">---</span></td>
				<td>{{contacta.dataContacte}}</td>
				<td>{{contacta.txtContacte}}</td>
			</tr>
		</table>	
	</div>	
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none">
	</button>
