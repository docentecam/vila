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
	$rootScope.cargador=true;
	console.log("olaaaxd");

	var TIMEOUT = null;
$(window).on('resize', function() {
    if(TIMEOUT === null) {
        TIMEOUT = window.setTimeout(function() {
            TIMEOUT = null;
            //fb_iframe_widget class is added after first FB.FXBML.parse()
            //fb_iframe_widget_fluid is added in same situation, but only for mobile devices (tablets, phones)
            //By removing those classes FB.XFBML.parse() will reset the plugin widths.
            $('.fb-page').removeClass('fb_iframe_widget fb_iframe_widget_fluid');
            FB.XFBML.parse();
        }, 300);
    }
});

var altoFace=500;
var altoBanner=altoFace/3;
console.log($("#frameFb").height());
$("#banner1").height(($("#frameFb").height())/3);

	var data = new FormData();
				data.append("acc","l");

			var deferred=$q.defer();
			
			$http.post("models/home.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})
			.then(function(res){
				deferred.resolve(res);
				$rootScope.cargador=false;
				$scope.noticiesDestacades=res.data;
				console.log(res.data);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
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
	$scope.contactans.nomContacte="";
	$scope.contactans.cognomContacte="";
	$scope.contactans.checkTipo="";
	$scope.contactans.email="";
	$scope.contactans.telefon="";
	$scope.contactans.nomEmpresa="";
	$scope.contactans.txtContacte="";
	$scope.contactaSoci={};
	$scope.contactaSoci.nomComercial="fdhfdhgdfh";
	$scope.contactaSoci.sectorComercial="hfddfhdfhfdhfd";
	$scope.contactaSoci.adreca="gran via 1006";
	$scope.contactaSoci.telf=658596784;
	$scope.contactaSoci.email="yaibondi@gmail.com";
	$scope.contactaSoci.personaContacte="dsgdsgdsgsdgsdgsdgdsgs";
	$scope.contactaSoci.horari="54564gds564g5dsg4dsgsdgsdgdsgdsgdsg";
	// $scope.fitxaSuccess=true;

	var data = new FormData();
				data.append("acc","l");
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
				$scope.contactaLlistat = res.data[0];
				console.log(res.data);
				$rootScope.cargador=false;
			})

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
	$scope.enviaEmail=function(){

	//verificar exista email o telefono

	if($scope.contactans.email=="" && $scope.contactans.telefon==""){

			$scope.msg="No puede estar vacio el campo email/telefono";
			$timeout(function(){
				$scope.contactaMissatge=false;
			},3000);

	}

	else{

	
	// console.log("llega");
		$scope.llistat=false;
		var data = new FormData();
			data.append("acc","i");
			data.append("nomContacte",$scope.contactans.nomContacte);
			data.append("cognomContacte",$scope.contactans.cognomContacte);
			data.append("tipus",$scope.contactans.checkTipo);
			data.append("email",$scope.contactans.email);
			data.append("telf",$scope.contactans.telefon);
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
			// console.log(res.data);
			$scope.contactans.nomContacte="";
			$scope.contactans.cognomContacte="";
			$scope.contactans.checkTipo="";
			$scope.contactans.email="";
			$scope.contactans.telefon="";
			$scope.contactans.nomEmpresa="";
			$scope.contactans.txtContacte="";
	
		})
		.catch(function(error) {
			$rootScope.cargador=false;
			});
		}
}
$scope.enviaSoci=function(){
console.log(isNaN($scope.contactaSoci.telf));
	$scope.llistat=false;
	if($scope.contactaSoci.email=="" && $scope.contactaSoci.telf==null){

			$scope.msg="No puede estar vacio el campo email/telefono";
			$timeout(function(){
				console.log("jadghajgdjasdg");
				$scope.contactaMissatge=false;
			},3000);

	}
else{
	// formulario sociiiii***********************************
	var data = new FormData();
		data.append("acc","insertSolicitutssocis");
		data.append("nomComercial",$scope.contactaSoci.nomComercial);
		data.append("sectorComercial",$scope.contactaSoci.sectorComercial);
		data.append("adreca",$scope.contactaSoci.adreca);
		data.append("email",$scope.contactaSoci.email);
		data.append("telf",$scope.contactaSoci.telf);
		data.append("personaContacte",$scope.contactaSoci.personaContacte);
		data.append("horari",$scope.contactaSoci.horari);		
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
		console.log(res.data);
		// $scope.contactans=res.data;
		$scope.contactaSoci.nomComercial="";
		$scope.contactaSoci.sectorComercial="";
		$scope.contactaSoci.adreca="";
		$scope.contactaSoci.telf="";
		$scope.contactaSoci.email="";
		$scope.contactaSoci.personaContacte="";
		$scope.contactaSoci.horari="";
		if(res.data.trim()=="ok") {
			$scope.msg="Missatge registrat";
			$timeout(function(){
				$scope.contactaMissatge=false;
				window.location.reload();
			},3000);
		}
		else{
			$scope.msg="verifica dades";
		}
		
		$scope.contactaMissatge=true;
		$rootScope.cargador=false;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
	}
	}
})
.controller('PoliticaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){

	$scope.muestraInput="holaaa";

	
})