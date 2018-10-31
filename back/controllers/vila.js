angular.module('vila')
.controller('IniciCtrl',function($scope,$http,$q,$rootScope,$timeout){
})
.controller('AssociCtrl',function($scope,$http,$q,$rootScope,$timeout){
	// var data = new FormData();
	// 	data.append("acc","favi");
	// var deferred=$q.defer();
	// $rootScope.cargador=true;

	// $http.post("models/associacio.php", data,{
	// 	headers:{
	// 		"Content-type":undefined
	// 	},
	// 	transformRequest:angular.identity
	// })
	// .then(function(res){
	// 	deferred.resolve(res);
	// 	$rootScope.cargador=false;
	// 	$timeout(function() {

	// 	}, 2000);
	// })
	// .catch(function(error) {
	// 	$rootScope.cargador=false;
	// });
	$scope.accion="";
	$scope.ass={};
	$scope.msj="";
	var data = new FormData();
		data.append("acc","l");
	var deferred=$q.defer();
	// $rootScope.cargador=true;
	$http.post("models/associacio.php", data,{
		headers:{
			"Content-type":undefined
		},
			transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.vila=res.data[0];
		$rootScope.cargador=false;
		$scope.ass.idVila=$scope.vila.idVila;
		$scope.ass.email=$scope.vila.email;
		$scope.ass.pasMail=$scope.vila.pasMail;
		$scope.ass.logoVila=$scope.vila.logoVila;
		$scope.ass.logoVilaOld=$scope.vila.logoVila;
		$scope.ass.logoUpdate="";
		$scope.ass.facebook=$scope.vila.facebook;
		$scope.ass.keyApi=$scope.vila.keyApi;
		$scope.ass.password=$scope.vila.password;
		$scope.ass.logoBolsa=$scope.vila.logoBolsa;
		$scope.ass.logoBolsaOld=$scope.vila.logoBolsa;
		$scope.ass.favIcon=$scope.vila.favIcon;
		$scope.ass.favIconOld=$scope.vila.favIcon;
		$scope.ass.telf=$scope.vila.telf;
		$scope.ass.horari=$scope.vila.horari;
		$scope.ass.nom=$scope.vila.nom;
		$scope.ass.quiSom=$scope.vila.quiSom;
		$scope.ass.equip=$scope.vila.equip;
		$scope.ass.latitud=$scope.vila.latitud;
		$scope.ass.longitud=$scope.vila.longitud;
		$scope.ass.LGPD=$scope.vila.LGPD;
		$scope.ass.URLWeb=$scope.vila.URLWeb;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	$scope.submitAss=function(){
		$scope.msj=true;
			$scope.msj="Les dades s'han actualitzat correctament.";
			var data = new FormData();
				data.append("acc","updateVila");
				data.append("idVila",$scope.ass.idVila);
				data.append("email",$scope.ass.email);
				data.append("pasMail",$scope.ass.pasMail);
				data.append("logoVila",$scope.ass.logoVila);
				data.append("facebook",$scope.ass.facebook);
				data.append("kayApi",$scope.ass.kayApi);
				data.append("password",$scope.ass.password);
				data.append("logoBolsa",$scope.ass.logoBolsa);
				data.append("favIcon",$scope.ass.favIcon);
				data.append("telf",$scope.ass.telf);
				data.append("horari",$scope.ass.horari);
				data.append("nom",$scope.ass.nom);
				data.append("quiSom",$scope.ass.quiSom);
				data.append("equip",$scope.ass.equip);
				data.append("latitud",$scope.ass.latitud);
				data.append("longitud",$scope.ass.longitud);
				data.append("LGPD",$scope.ass.LGPD);
				data.append("URLWeb",$scope.ass.URLWeb);
				var deferred=$q.defer();
			$rootScope.cargador=true;
			$http.post("models/associacio.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})
			.then(function(res){
				deferred.resolve(res);
				console.log(res.data);
				$rootScope.cargador=false;
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
	}
	$scope.showPassAss=function(){
		if ($scope.tipe) {
			document.getElementById('txtPass').type = 'text';
		}
		else{
			document.getElementById('txtPass').type = 'password';
		}
		$('#txtPass').focus();
		$scope.tipe=!$scope.tipe;
	}
	$scope.getFileDetails = function (e,nomCamp) {
		var data = new FormData();
            data.append("acc", "updateMedia");
			data.append("nomCamp", nomCamp);
			data.append("logoUpdate", e.files[0]);
			if(nomCamp=="logoVila"){
				data.append("logoOld", $scope.ass.logoVila);
			}
			else if(nomCamp=="logoBolsa"){
				data.append("logoOld", $scope.ass.logoBolsa);
				
			}
			else if(nomCamp=="favIcon"){
				data.append("logoOld", $scope.ass.favIcon);

			}
			 var deferred=$q.defer();
			 $http.post("models/associacio.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
				})
				.then(function(res)
				{
					console.log(res.data);
					deferred.resolve(res);
					if(nomCamp=="logoVila"){
						$scope.ass.logoVila=res.data;
					}
					else if(nomCamp=="logoBolsa"){
						$scope.ass.logoBolsa=res.data;
						$rootScope.logoBolsa=res.data;
					}
					else if(nomCamp=="favIcon"){
						$scope.ass.favIcon=res.data;

					}				
				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});
    } 
})	
.controller('DirectCtrl',function($scope,$http,$q,$rootScope,$timeout){
	var data = new FormData();
		data.append("acc","l");

	var deferred=$q.defer();
	$rootScope.cargador=true;
	$http.post("models/directori.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
})
.controller('ContactCtrl',function($scope,$http,$q,$rootScope,$timeout){
	var data = new FormData();
		data.append("acc", "favi");
	var deferred=$q.defer();
	
	$http.post("models/associacio.php", data,{
	headers:{
		"Content-type":undefined
	},
	transformRequest:angular.identity

	})
	.then(function(resIcon){
		deferred.resolve(resIcon);
		$rootScope.favIcon=resIcon.data[0].favIcon;
		$rootScope.logo=resIcon.data[0].logo;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});

	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();
	$http.post("models/contactans.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.contactans=res.data;
		$rootScope.cargador=false;
		console.log(res.data);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
	        document.getElementById("goTop").style.display = "block";
	    } else {
	        document.getElementById("goTop").style.display = "none";
	    }
	}
 	$scope.goTop=function(){
 		var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
 	}
	$scope.columnOrder=function(columna){
		$scope.order=columna;
	}
})
.controller('SociCtrl',function($scope,$http,$q,$rootScope,$timeout){
	var data = new FormData();
		data.append("acc", "favi");
	var deferred=$q.defer();
	
	$http.post("models/associacio.php", data,{
	headers:{
		"Content-type":undefined
	},
	transformRequest:angular.identity

	})
	.then(function(resIcon){
		deferred.resolve(resIcon);
		$rootScope.favIcon=resIcon.data[0].favIcon;
		$rootScope.logo=resIcon.data[0].logo;
		$rootScope.cargador=false;
	})
	.catch(function(error){
		$rootScope.cargador=false;

	});

	var data = new FormData();
		data.append("acc","l");
    var deferred=$q.defer();
	$http.post("models/solicitutsoc.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$scope.solicituts=res.data;
		$rootScope.cargador=false;
		console.log(res.data);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
	        document.getElementById("goTop").style.display = "block";
	    } else {
	        document.getElementById("goTop").style.display = "none";
	    }
	}
 	$scope.goTop=function(){
 		var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
 	}
	$scope.columnOrder=function(columna){
		$scope.order=columna;
	}
})
.controller('FiramarCtrl',function($scope, $http, $q, $timeout, $rootScope) {


})
.controller('LogoutCtrl',function($scope,$http){
	$http({
		method:"GET",
		url:"models/login.php?acc=logout"
	})
	.then(function mySuccess(response){
		location.href="index.php";
	},
	function myError(response){	
	})
	.finally (function(){
	})
})
