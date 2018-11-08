<div class="AssNotSerAllCss">
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
	<br>
	<!-- <form name="formServei" ng-submit="submitServei()" ng-hide="revealSub">
		<div class="row">
			<div class="col" ng-class="{ 'has-error' : formServei.nomSubser.$invalid && !formServei.nomSubser.$pristine }">
				<label for="nomSubser">Subservei:</label>
				<input type="text" class="form-control" ng-model="ser.nomSubservei" id="nomSubser" placeholder="Subservei" name="nomSubser">
			</div>
			<div class="col" ng-class="{ 'has-error' : formServei.descSubser.$invalid && !formServei.descSubser.$pristine }">
				<label for="descSubser">Descripció Subservei:</label>
				<input type="text" class="form-control" ng-model="ser.txtSubservei" id="descSubser" placeholder="Descripció" name="descSubser">
			</div>
		</div>
	</form>
	<br> -->
	<div class="row">
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
			      <th scope="row">{{$index+1}}</th> 
			      <td>{{servei.nomServei}}: {{servei.txtServei}}<span class="serveiysubserveiBoxCss"><i ng-click="EditServei($index)" class="far fa-edit"></i>&nbsp<i class="far fa-times-circle fontAweX" ng-click="eliminarServei(servei.idServei, servei.nomServei)"></i></span></td>
			      <td> <span class="serveiysubserveiBoxCss" ng-repeat="subservei in servei[3]">{{subservei.nomSubservei}}: {{subservei.txtSubservei}}<i class="fas fa-plus" ng-click="EditSubservei('-1')"></i>&nbsp<i class="far fa-edit" ng-click="EditSubservei()"></i>&nbsp<i class="far fa-times-circle fontAweX" ng-click="eliminarSubservei(subservei.idSubservei, subservei.nomSubservei)"></i><br></span></td>
			    </tr>
			</tbody>
		</table>
	</div>
</div>