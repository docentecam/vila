angular.module('vila')
.controller('IndexCtrl',function($scope,$http,$rootScope){
		// $rootScope.cargador=true;	
		// $http({
		// 	method : "GET",
		// 	url : "models/index.php?acc=l"
		// })
		// .then(function mySuccess(response) {
			
		// 	$scope.footerContent=response.data.dadesFooter;
		// 	$scope.footerContentTrans=response.data.transportFooter;
		// 	$rootScope.cargador=false;
		// }, 
		// function myError(response) {
		
		// })
		// .finally(function()
		// { 
		  
		    
		// })

})
.controller('HomeCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
})

.controller('AssociacioCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	
	var data = new FormData();
		data.append("acc","l");
	var deferred=$q.defer();
	console.log("aasdasdasd");
	$rootScope.cargador=true;
	$http.post("models/associacio.php", data,{
				headers:{
					"Content-type":undefined
				},
				transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		$scope.noticia=res.data[0];
		$rootScope.cargador=false;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	
})

.controller('DirectoriCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("llega");
})
.controller('NoticiesCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("sí, así es");
	$scope.llistat=false;
	$rootScope.cargador=true;
	var data = new FormData();
		data.append("acc","l");
	var deferred=$q.defer();
	$http.post("models/noticies.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		$scope.noticies=res.data;
		console.log("llega: "+res.data);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
})

.controller('NoticiaCtrl',function($scope,$http,$q,$routeParams,$rootScope){
	$scope.llistat=false;
	$rootScope.cargador=true;
	var data = new FormData();
		data.append("acc","l");
		data.append("idNoticia",$routeParams.idNoticia);
	var deferred=$q.defer();
	$http.post("models/noticies.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		$scope.noticia=res.data[0];
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
})

.controller('FiramarCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("sí, así es");

})
.controller('ContactaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){

	$scope.muestraInput=false;

	$scope.muestraNom=function(tipo)
	{
		$scope.muestraInput=tipo;
	}
})
.controller('PoliticaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){

	$scope.muestraInput="holaaa";

	
})

