<div class="SerAllCss" >
	<form name="formServei" ng-submit="submitServei()" ng-hide="reveal">
		<div class="row">
			<div class="col" ng-class="{ 'has-error' : formServei.nomSer.$invalid && !formServei.nomSer.$pristine }">
				<label for="nomSer">Servei:</label>
				<input type="text" class="form-control" ng-model="ser.nomServei" id="nomSer" placeholder="Nom del servei" name="nomSer">
			</div>
			<div class="col" ng-class="{ 'has-error' : formServei.descSer.$invalid && !formServei.descSer.$pristine }">
				<label for="descSer">Descripció servei:</label>
				<input type="text" class="form-control" ng-model="ser.txtServei" id="descSer" placeholder="Descripció" name="descSer">
			</div>
		</div>
		<br>
		<input class="btn btn-danger" type="button" value="Cancelar" ng-click="cancelSer()">
		<button type="submit" class="btn btn-info" ng-disabled="formAss.$invalid" value="submit-true" formmethod="post">{{accionSer}}</button>
	</form>
	<form name="formSubservei" ng-submit="submitSubservei()" ng-hide="revealSub">
		<div class="row">
			<div class="col" ng-class="{ 'has-error' : formSubservei.nomSubser.$invalid && !formSubservei.nomSubser.$pristine }">
				<label for="nomSubser">Subservei:</label>
				<input type="text" class="form-control" ng-model="subSer.nomSubservei" id="nomSubser" placeholder="Nom del subservei" name="nomSubser">
			</div>
			<div class="col" ng-class="{ 'has-error' : formSubservei.descSubser.$invalid && !formSubservei.descSubser.$pristine }">
				<label for="descSubser">Descripció Subservei:</label>
				<input type="text" class="form-control" ng-model="subSer.txtSubservei" id="descSubser" placeholder="Descripció" name="descSubser">
			</div>
		</div>
		<br>
		<input class="btn btn-danger" type="button" value="Cancelar" ng-click="cancelSer()">
		<button type="submit" class="btn btn-info" ng-disabled="formAss.$invalid" value="submit-true" formmethod="post">{{accionSubser}}</button>
	</form>
	<br id="divTop">
	<div class="row" >
		<table class="table table-bordered">
			<thead class="thead-light">
				<tr>
			      <th scope="col">#</th>
			      <th scope="col">Serveis<i class="fas fa-plus serveiTituCss" ng-click="EditServei('-1')"></th>
			      <th scope="col">Subservei</th>
			    </tr>	
			</thead>
			<tbody>
				<tr ng-repeat="servei in serveis">
			      <th scope="row" class="align-middle">{{$index+1}}</th> 
			      <td class="align-middle">{{servei.nomServei}}:<span class="serveiysubserveiBoxCss"><i ng-click="EditServei($index)" class="far fa-edit iconSize"></i>&nbsp<i class="far fa-times-circle fontAweX iconSize" ng-click="eliminarServei(servei.idServei, servei.nomServei)"></i><p>{{servei.txtServei}}</p></span></td>
			      <td> <span class="serveiysubserveiBoxCss" ng-repeat="subservei in servei[3]"><div>{{subservei.nomSubservei}}:<p>{{subservei.txtSubservei}}</p><i class="far fa-edit iconSize ServeiIconCss" ng-click="EditSubservei($index,servei.idServei)"></i><i class="far fa-times-circle fontAweX iconSize ServeiIconCss" ng-click="eliminarSubservei(subservei.idSubservei, subservei.nomSubservei)"></i></div><br><div></div></span><br><i class="fas fa-plus" ng-click="EditSubservei('-1',servei.idServei)"></i></td>
			    </tr>
			</tbody>
		</table>	
	</div>
	<button id="goTop" class="goToTop btn btn-primary " value="Pujar" ng-click="goTop()">
		<span class="d-none d-lg-inline">Pujar</span>
		<img ng-src="../img/if_arrow-up.png" class="d-lg-none imgBtnTop">
	</button>
</div>