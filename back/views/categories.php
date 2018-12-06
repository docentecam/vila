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
	<div class="row" ng-hide="dadesCateg" id="divTop">
	 	<form id="formVila" name="formVila" class="col-12">
			<div class="form-row">
			    <div class="form-group col-12 col-lg-4 offset-lg-4">
			   		<label for="txtNom">Nom de la categoria</label>
			    	<input type="text" class="form-control" id="txtNom" ng-model="cat.nomCategoria" maxlength="50">
			    </div>
			</div>
			<div class="form-row">
				<div class="form-group col-12 col-lg-8 offset-lg-4">
		        	<label for="inputFoto">Nou Pictograma</label>
		        	<div class="input-group">
						<div class="input-group-prepend col-6 divColInput">
							<input type="text" class="form-control inputColorBG" id="inputPictograma" ng-model="cat.pictograma" name="inputPictograma" disabled>
							<label for="btnExVila" class="input-group-text examinarImg" id="inputGroupPrepend"><i class="fas fa-search cursor" aria-hidden="true" ></i></label>
						</div>
			    	</div>
		            <input type="file" id="btnExVila" class="align-self-end" name="btnExVila"  onchange="angular.element(this).scope().getFileDetailss(this)" ng-show="false"/>
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
	<div id="divMissatge" ng-show="divMsj" class="col-6 offset-3 text-center alert alert-success">{{msj}}</div>
	<div class="row">
		<a class=" fas fa-plus-square iconSize mb-3 col-12 col-lg-9 offset-lg-1" title="Afegir nou comerç" ng-click="muestraFormCat(-1)"></a>
	</div>
	<div class="row table-responsive divTable">
		<table border="1" class="divTable col-12 col-lg-10 offset-lg-1 text-center tablaSocis">
			<tr>
				<th>Pictograma</th>
				<th>Categoria</th>
				<th>Accions</th>
			</tr>
			<tr ng-repeat="categoria in categories">
				<td class="tdImgCat"><div class="row text-center"><img class="col-10 col-md-6 col-lg-4 offset-1 offset-md-3 offset-lg-4 img-fluid imgPictogramaCateg" ng-src="{{categoria.pictograma!='' ? '../img/pictogramas/'+categoria.pictograma : '../img/noimage.png'}}" alt=""></div></td>
				<td>{{categoria.nomCategoria}}</td>
				<td><i class="far fa-edit text-dark iconSize my-2" ng-click="muestraFormCat($index)"></i><i ng-show="categoria[3]==0" class="fas fa-times text-danger iconSize ml-3 my-2" ng-click="elimina(categoria.idCategoria)"></i></td>
			</tr>
		</table>	
	</div>
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none imgBtnTop">
	</button>
