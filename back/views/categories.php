<?php
	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
 ?> 
 	

	<div class="row text-center mt-4 mb-3 titleSocis" id="divTop">
		<h1 class="col">Llistat de les categories</h1>
	</div>
	<div class="row" ng-hide="dadesCateg">
	 	<form id="formVila" name="formVila" class="col-12">
	 		<div class="form-row">
				<div class="form-group col-md-6 col-lg-2 offset-lg-5">
				    <div class="form-row">
				        <div class="form-group col-12">
				        	<label for="inputFoto" class="col-12">Pictograma</label>
				        	<img class="img-fluid imgCssColla col-10" ng-src="{{cat.pictograma!='' ? '../img/'+cat.pictograma : '../img/noimage.png'}}" alt="">
				        </div>
				        <div class="form-group col-12">
				            <label for="btnExVila" class="cursor text-primary col-12"><u>Examinar</u>&nbsp;<i class="fas fa-search add-examinar cursor" aria-hidden="true"></i></label>
				            <input type="file" id="btnExVila" class="align-self-end" name="btnExVila"  onchange="angular.element(this).scope().getFileDetails(this,'pictograma')" ng-show="false"/>
				        </div>
				    </div>    
				</div>
			</div> 
			<div class="form-row">
			    <div class="form-group col-12 col-lg-4 offset-lg-4">
			   		<label for="txtNom">Nom Associat</label>
			    	<input type="text" class="form-control" id="txtNom" ng-model="cat.nomCategoria" maxlength="50">
			    </div>
			</div>
			<div class="form-row">
				<div class="form-group col-12 col-md-8 col-lg-4 offset-md-4 offset-lg-7">
					<button type="button" value="{{accion}}" ng-click="edit(accion)" class="btn  btnColorCss">{{accion}}</button>
					<button type="button" value="cancelar" ng-click="cancel('')" class=" btn btn-danger">Cancelar</button>
				</div>
			</div>
		</form>
	</div>
	<div  ng-show="divMsj" class="col-6 offset-3 text-center alert alert-warning">{{msj}}</div>
	<div class="row table-responsive divTable">
		<table border="1" class="divTable col-12 col-lg-10 offset-lg-1 text-center tablaSocis">
			<tr>
				<th >Pictograma</th>
				<th class="cursor" ng-click="columnOrder('nomCategoria')">Categoria</th>
				<th>Accions</th>
			</tr>
			<tr ng-repeat="categoria in categories | orderBy:order">
				<td>{{categoria.pictograma}}</td>
				<td>{{categoria.nomCategoria}}</td>
				<td><i class="far fa-edit text-dark iconSize my-2" ng-click="muestraFormCat(categoria.idCategoria)"></i><i ng-show="categoria[3]==0" class="fas fa-times text-danger iconSize ml-3 my-2"></i></td>
			</tr>
		</table>	
	</div>
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none">
	</button>
