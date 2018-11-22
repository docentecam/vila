
<div class="row mt-5 mb-3">
	<h1 class="col-lg-4 offset-lg-4 text-center">Imatges del Carousel</h1>
</div>
<div class="row mb-3">
	<div class="col-lg-4 offset-lg-4 text-center">Recordeu que la millor opció es tenir entre 2 i 5 imatges</div>
</div>
<div class="row">
	<label for="insertImg" class="cursor col-12 offset-md-2">
		<i class=" fas fa-plus-square iconSize mb-3" title="Afegeix imatges"></i>
	</label>
	<input type="file" id="insertImg" class="align-self-end" name="insertImg" multiple accept="image/jpg, image/png" onchange="angular.element(this).scope().uploadGaleria(this)" ng-show="false"/>


	<div class="card-columns col-12 col-lg-8 offset-lg-2">
		<div class="card text-center" ng-repeat="imatgeCar in imatgesCar">
			<img class="card-img-top img-fluid" ng-src="{{imatgeCar.fotoCarousel!='' ? '../img/carousel/'+imatgeCar.fotoCarousel : '../img/noimage.png'}}" alt="imatge {{$index+1}}">
			<input type="button" class="btn btn-danger" value="Eliminar" ng-click="deleteImg(imatgeCar.idCarousel)">
		</div>
	</div>
</div>
<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
	<span class="d-none d-lg-inline">Pujar</span>
	<img ng-src="../img/if_arrow-up.png" class="d-lg-none imgBtnTop">
</button>