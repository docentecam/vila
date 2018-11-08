
<?php
	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
 ?> 
	<div class="row text-center mt-4 mb-3 titleSocis">
		<h1 class="col">Llistat solicituts de socis</h1>
	</div>
	<div class="row table-responsive divTable">
		<table border="1" class="divTable col-12 col-lg-10 offset-lg-1 text-center tablaSocis">
			<tr>
				<th class="cursor" ng-click="columnOrder('nomComercial')">Nom Comerç</th>
				<th class="cursor" ng-click="columnOrder('sectorComercial')">Sector Comerç</th>
				<th class="cursor" ng-click="columnOrder('adreca')">Adreça</th>
				<th class="cursor" ng-click="columnOrder('telf')">Telèfon</th>
				<th class="cursor" ng-click="columnOrder('email')">Correu electrònic</th>
				<th class="cursor" ng-click="columnOrder('horari')">Data de la solicitut</th>
				<th class="cursor" ng-click="columnOrder('horari')">Horari per contactar</th>
			</tr>
			<tr ng-repeat="solicitut in solicituts | orderBy:order">
				<td>{{solicitut.nomComercial}}</td>
				<td>{{solicitut.sectorComercial}}</td>
				<td>{{solicitut.adreca}}</td>
				<td>{{solicitut.telf}}<span ng-if="solicitut.telf==null">---</span></td>
				<td>{{solicitut.email}}<span ng-show="solicitut.email==null">---</span></td>
				<td>{{solicitut.dataSolicitut}}</td>
				<td>{{solicitut.horari}}</td>
			</tr>
		</table>	
	</div>
	{{solicituts.nomComercial}}	
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none">
	</button>
