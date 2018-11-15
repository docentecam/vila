<?php
	session_start();
	?>
	<div class="col-12 offset-3 text-center alert alert-warning" ng-show="cargaMsg">
		{{msg}}
	</div>

	<br>	
	<div class="AssNotiAllCss" id="NotiEditTop">
		<form  class="formNot" ng-submit="submitServei()" ng-hide="reveal">
			<br>
			<div class="row">
				<div class="col" ng-class="{ 'has-error' : formServei.nomNot.$invalid && !formServei.nomNot.$pristine }">
					<label for="nomNot">Titular:</label>
					<input type="text" class="form-control" ng-model="not.titolNoticia" id="nomNot" placeholder="Nom" name="nomNot">
				</div>
				<div class="col" ng-class="{ 'has-error' : formNot.descNot.$invalid && !formNot.descNot.$pristine }">
					<label for="descNot">Descripció:</label>
					<textarea type="text" class="form-control" ng-model="not.txtNoticia" id="descNot" placeholder="Descripció" name="descNot">{{not.txtNoticia}}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="col" ng-class="{ 'has-error' : formNot.descNot.$invalid && !formNot.descNot.$pristine }">
					<label>Data:</label>
					<input type="date" class="form-control" name="dataNot" ng-model="not.dataNoticia">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-2">Es favorit?</label>
				<select ng-model="not.principal">
					<option value="S" ng-selected="not.principal=='S'">Si</option>
					<option value="N" ng-selected="not.principal=='N'">No</option>
				</select>
			</div>
			<div class="row">
				<label class="cursor text-primary col" for="btnExaminar">Afegeix una imatge <i class="fas fa-camera add-examinar text-primary cursor" aria-hidden="true"></i></label>
				<input type="file" id="btnExaminar" name="btnExaminar" accept="image/jpg, image/jpeg, image/png"  multiple onchange="angular.element(this).scope().getFileDetails(this)" ng-show="false"/>
			</div>
			<div>
			<input class="btn btn-danger" type="button" value="Cancelar" ng-click="cancelNot()">
			<button type="submit" class="btn btn-info" ng-disabled="formNot.$invalid" value="submit-true" formmethod="post">{{accionNot}}</button>
			</div>
		</form>
	</div>

	<div class="row text-center">
		<h2 class="col my-3"> Noticies </h2>
	</div>
	<i class="offset-md-1 fas fa-plus-square iconSize" ng-click="EditNoticia('-1')" ng-show="reveal" title="Afegeix una Noticia"></i>
	<br>
	<br>
	<div class="row justify-content-center">
		<div class="border border-secondary mx-xl-3 my-2 mr-md-3 col-md-5 col-xl-3 media"  ng-repeat="noticia in noticies">
			<div class="row text-center">
				<div class="col-12 text-center">
					
						<img class="img-fluid" ng-src="{{noticia.fotoNoticia!='' ? '../img/noticies/'+noticia.fotoNoticia : '../img/noimage.png'}}" alt="">

				</div>
				<div class="col-12">
					<div class="row">
						<h6 class="col"> 
						<span class="col-12 ">{{noticia.dataNoticia}}</span>
						</h6>
						<div class="col-12"><span>{{noticia.titolNoticia}}</span></div>
						<span class="col-12">{{noticia.txtNoticia}}</span>
					</div>
					<div class="col-12 col-sm-12">
						<i class="far fa-star iconSize " ng-if="noticia.principal=='N'" ng-click="cambiaPrinc('S', noticia.idNoticia)" title="Afegir com a favorit"></i>
						<i class="fas fa-star iconSize"  ng-if="noticia.principal=='S'" ng-click="cambiaPrinc('N', noticia.idNoticia)" title="Quitar com a favorit"></i>
						<i class="far fa-edit iconSize" ng-click="EditNoticia($index)" title="Editar"></i>
						<i class="far fa-times-circle iconSize fontAweX" ng-click="eliminarNoticies(noticia.idNoticia, noticia.titolNoticia, noticia.fotoNoticia)" title="Eliminar"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- <button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
	<span class="d-none d-lg-inline">Pujar</span>
	<img ng-src="../img/if_arrow-up.png" class="d-lg-none"> -->
</button>