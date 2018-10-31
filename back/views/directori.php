
<?php
	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
 ?> 
	<div class="row text-center mt-4 mb-3 titleSocis">
		<h1 class="col">Llistat de comerços</h1>
	</div>
	<div class="row table-responsive divTable">
		<table border="1" class="divTable col-12 col-lg-10 offset-lg-1 text-center tablaSocis">
			<tr>
				<th>Logo del Comerç</th>
				<th class="cursor" ng-click="columnOrder('nomAssociat')">Nom del Comerç</th>
				<th class="cursor" ng-click="columnOrder('nomCategoria')">Categoria Principal</th>
				<th class="cursor" ng-click="columnOrder('adreca')">Adreça</th>
				<th class="cursor" ng-click="columnOrder('telf1')">Telèfon 1</th>
				<th class="cursor" ng-click="columnOrder('telf2')">Telèfon 2</th>
				<th class="cursor" ng-click="columnOrder('whatsapp')">Whatsapp</th>
				<th class="cursor" ng-click="columnOrder('email')">Correu electrònic</th>
				<th class="cursor" ng-click="columnOrder('horari')">Horari</th>
				<th class="cursor" ng-click="columnOrder('txtAssociat')">DEscripció del comerç</th>
				<th class="cursor" ng-click="columnOrder('latitud')">Latitud</th>
				<th class="cursor" ng-click="columnOrder('longitud')">Longitud</th>
				<th class="cursor" ng-click="columnOrder('URLWeb')">Pàgina Web</th>
			</tr>
			<tr ng-repeat="directori in directoris | orderBy:order">
				<td>{{directori.logoAssociat}}</td>
				<td>{{directori.nomAssociat}}</td>
				<td>{{directori.nomCategoria}}</td>
				<td>{{directori.adreca}}</td>
				<td>{{directori.telf1}}<span ng-if="directori.telf1==null">---</span></td>
				<td>{{directori.telf2}}<span ng-show="directori.telf2==null">---</span></td>
				<td>{{directori.whatsapp}}<span ng-show="directori.whatsapp==null">---</span></td>
				<td>{{directori.email}}</td>
				<td>{{directori.horari}}</td>
				<td>{{directori.txtAssociat}}</td>
				<td>{{directori.latitud}}</td>
				<td>{{directori.longitud}}</td>
				<td>{{directori.URLWeb}}</td>
			</tr>
		</table>	
	</div>
	{{solicituts.nomComercial}}	
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none">
	</button>
