<div class="AssNotSerAllCss">
	<div class="row">
		<table class="table table-bordered">
			<thead class="thead-light">
				<tr>
			      <th scope="col">#</th>
			      <th scope="col">Serveis</th>
			      <th scope="col">Subservei</th>
			    </tr>	
			</thead>
			<tbody>
				<tr ng-repeat="servei in serveis">
			      <th scope="row">1</th> 
			      <td>{{servei.nomServei}}:{{servei.txtServei}}</td>
			      <td ng-repeat="subservei in subserveis">{{subservei.nomSubservei}}:{{subservei.txtServei}}<i class="fas fa-plus"></i></td>
			    </tr>
			</tbody>
		</table>
	</div>
</div>