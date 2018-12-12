<?php
	session_start();

	if (!isset($_SESSION['vila']['email'])) 
	{
		header("location: ../");
	}
 ?> 
<div class="row" ng-show="imatgesCarBan">
	<h1 class="col-lg-4 offset-lg-4 text-center mt-5 mb-3">Imatges del Carousel</h1>
	<div class="col-lg-4 offset-lg-4 text-center mb-3">Recordeu que la millor opció es tenir entre 2 i 5 imatges (la mida de les imatges ha de ser de 1024x500px)</div>
	<div class="row">
		<label for="insertImg" class="cursor col-12 offset-md-2">
			<i class=" fas fa-plus-square iconSize mb-3" title="Afegeix imatges"></i>
		</label>
		<input type="file" id="insertImg" class="align-self-end" name="insertImg" multiple accept="image/jpg, image/png" onchange="angular.element(this).scope().uploadGaleria(this)" ng-show="false"/>


		<div class="card-columns col-12 col-lg-8 offset-lg-2">
			<div class="card text-center" ng-repeat="imatgeCar in imatgesCar">
				<img class="card-img-top img-fluid" ng-src="{{imatgeCar.fotoCarousel!='' ? '../img/carousel/'+imatgeCar.fotoCarousel : '../img/noimage.png'}}" alt="imatge {{$index+1}}">
				<input type="button" class="btn btn-danger" value="Eliminar" ng-click="deleteImg(imatgeCar.idCarousel,imatgeCar.fotoCarousel)">
			</div>
		</div>
	</div>
</div>
<div class="row" ng-hide="imatgesCarBan">
	 	<form id="formVila" name="formVila" class="col-12 my-3" ng-hide="dadesBanner">
			<div class="form-row">
				<div class="form-group radioCheck col-12 col-lg-4 offset-lg-4 mb-3 ">
				    <div class="form-check">
					    <input class="form-check-input" type="radio" name="tipoUs" id="clickEmp" ng-click="muestraURL('directori')" ng-checked="muestraInput=='directori'">
					    <label class="form-check-label tipoTexto" for="clickEmp">
					       URL interna
					    </label>
				    </div>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-12 col-lg-4 offset-lg-4 mb-3" ng-show="muestraInput=='directori'">
					<select name="nomAssociat" id="nomAssociat" ng-model="associatSel">
						<option value="-1">---Escull l'associat---</option>
						<option ng-repeat="associat in associats" ng-value="associat.idAssociat">{{associat.nomAssociat}}</option>
					</select>
	        	</div>
			</div>
			<div class="row">
				<div class="form-group radioCheck col-12 col-lg-4 offset-lg-4 mb-3">
				    <div class="form-check">
				    	<input class="form-check-input" type="radio" name="tipoUs" id="clickPar" ng-checked="muestraInput!='directori'" ng-click="muestraURL('noDirectori')">
				    	<label class="form-check-label tipoTexto" for="clickPar">
				    	URL externa
				    	</label>
				    </div>
				</div>

			    <div class="form-group col-12 col-lg-4 offset-lg-4" ng-show="muestraInput!='directori'">
			   		<label for="txtNom">URL del banner extern</label>
			    	<input type="text" class="form-control" id="txtNom" ng-model="associatSel" maxlength="50">
			    </div>
			</div>
			<div class="form-row">
				<div class="form-group col-12 col-lg-8 offset-lg-4">
		        	<label for="inputFoto">Banner</label>
		        	<div class="input-group">
						<div class="input-group-prepend col-6 divColInput">
							<input type="text" class="form-control inputColorBG" id="inputBanner" ng-model="ban.fotoBanner" name="inputBanner" disabled>
							<label for="insertImg" class="input-group-text examinarImg" id="inputGroupPrepend"><i class="fas fa-search cursor" aria-hidden="true" ></i></label>
						</div>
			    	</div>
		            <input type="file" id="insertImg" class="align-self-end" name="insertImg"  onchange="angular.element(this).scope().uploadGaleria(this)" ng-show="false"/>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-12 col-md-8 col-lg-4 offset-md-4 offset-lg-7">
					<button type="button" value="afegir" ng-click="nowBanner()" class="btn  btnColorCss">Afegir</button>
					<button type="button" value="cancelar" ng-click="cancel('')" class=" btn btn-danger">Cancelar</button>
				</div>
			</div>
		</form>
		<div id="divMissatge" ng-show="divMsj" class="col-6 offset-3 text-center alert alert-success">{{msj}}</div>
	<h1 class="col-lg-4 offset-lg-4 text-center mt-5 mb-3">Banners</h1>
	<div class="col-lg-4 offset-lg-4 text-center mb-3">(la mida de les imatges ha de ser de 680x66px)</div>
	<div class="cursor col-12 col-lg-8 offset-md-2" ng-show="imatgesBanner.length<=2">
		<i class=" fas fa-plus-square iconSize mb-3" title="Afegeix imatges" ng-click="insertBanner()"></i>
	</div>
	<div class="col-12 col-lg-8 offset-lg-2 text-center my-3" ng-repeat="imatgeBan in imatgesBanner">
		<a ng-href="{{imatgeBan.URLWeb}}" target="_blank">
			<img class="card-img-top img-fluid" ng-src="{{imatgeBan.fotoBanner!='' ? '../img/banners/'+imatgeBan.fotoBanner : '../img/noimage.png'}}" alt="imatge {{$index+1}}">
		</a>
		<input type="button" class="btn btn-danger" value="Eliminar" ng-click="deleteImg(imatgeBan.idBanner,imatgeBan.fotoBanner)">
	</div>
</div>
<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
	<span class="d-none d-lg-inline">Pujar</span>
	<img ng-src="../img/if_arrow-up.png" class="d-lg-none imgBtnTop">
</button>