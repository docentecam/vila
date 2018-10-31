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


// .controller('HomeCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
// 		$rootScope.cargador=true;
// 	var data = new FormData();
// 				data.append("acc","l");

// 			var deferred=$q.defer();
			
// 			$http.post("models/home.php", data,{
// 				headers:{
// 					"Content-type":undefined
// 				},
// 					transformRequest:angular.identity
// 			})
// 			.then(function(res){
// 				deferred.resolve(res);
// 				$rootScope.cargador=false;
// 				$rootScope.titlePag=res.data.nom;
// 				$scope.noticiesDestacades=res.data.noticiesDestacades;
// 			})
// 			.catch(function(error) {
// 				$rootScope.cargador=false;
// 			});
// })

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


.controller('HomeCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("olaaaxd");
	$(window).resize(function() {
   if(this.resizeTO) clearTimeout(this.resizeTO);
   this.resizeTO = setTimeout(function() {
      $(this).trigger('resizeEnd');
   }, 500);
	});
	$(window).bind('resizeEnd', function() {
   var url = $('#$WrapperID').data('refresh');
   $('#$WrapperID').fadeOut("slow", function() {
      $('#$WrapperID').load(url, { width: $('#$HTMLID').width() },
      function() {
         FB.XFBML.parse(document.getElementById('$WrapperID'),
         function() {
            $('#$WrapperID').fadeIn("slow");
         		});
      		})
   		});
	});
})


.controller('DirectoriCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("llega");

})
.controller('NoticiesCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	console.log("sí, así es");
	$scope.llistat=true;
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
	console.log("Hola");

})
.controller('ContactaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	$scope.contactaMissatge=false;
	$scope.msg="";
	$scope.contactans={};
	$scope.contactans.nomContacte="andrea";
	$scope.contactans.cognomContacte="garcia";
	$scope.contactans.checkTipo="Particular";
	$scope.contactans.email="hsfghsdf@gmail.com";
	$scope.contactans.telefon="455454545";
	$scope.contactans.nomEmpresa="hsgdhsagdhgasdgashjdg";
	$scope.contactans.txtContacte="hsajkdhasjkhdjakshdj";
	// $scope.fitxaSuccess=true;


	

	$scope.muestraInput=false;
	$scope.muestraNom=function(tipo)
	{
		$scope.muestraInput=tipo;
		if (!tipo) {$scope.contactans.checkTipo="Particular";}
			else{
				$scope.contactans.checkTipo="Empresa";
			}
		console.log($scope.contactans.checkTipo);
	}
	$scope.insertar=function(tipo){

//verificar exista email o telefono

		$scope.llistat=false;
	$rootScope.cargador=true;
	var data = new FormData();
		// data.append("acc","l");
		data.append("acc","i");
		data.append("nomContacte",$scope.contactans.nomContacte);
		data.append("cognomContacte",$scope.contacta.cognomContacte);
		data.append("tipus",$scope.contactans.checkTipo);
		data.append("email",$scope.contactans.email);
		data.append("telefon",$scope.contactans.telefon);
		data.append("nomEmpresa",$scope.contactans.nomEmpresa);
		data.append("txtContacte",$scope.contactans.txtContacte);		
	var deferred=$q.defer();
	$rootScope.cargador=true;
	$http.post("models/contacta.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		$scope.contactans=res.data;

		$scope.contactans.nomContacte="";
		$scope.contactans.cognomContacte="";
		$scope.contactans.tipus="";
		$scope.contactans.email="";
		$scope.contactans.telefon="";
		$scope.contactans.nomEmpresa="";
		$scope.contactans.txtContacte="";
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
	}
})
.controller('PoliticaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){

	$scope.muestraInput="holaaa";

	
})

