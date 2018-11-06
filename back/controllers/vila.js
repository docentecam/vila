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
		$scope.ass.facebook=$scope.vila.facebook;
		$scope.ass.kayApi=$scope.vila.kayApi;
		$scope.ass.password=$scope.vila.password;
		$scope.ass.logoBolsa=$scope.vila.logoBolsa;
		$scope.ass.favIcon=$scope.vila.favIcon;
		$scope.ass.telf=$scope.vila.telf;
		$scope.ass.horari=$scope.vila.horari;
		$scope.ass.nom=$scope.vila.nom;
		$scope.ass.quiSom=$scope.vila.quiSom;
		$scope.ass.equip=$scope.vila.equip;
		$scope.ass.latitud=$scope.vila.latitud;
		$scope.ass.longitud=$scope.vila.longitud;
		$scope.ass.LGPD=$scope.vila.LGPD;
		$scope.ass.URLWeb=$scope.vila.URLWeb;
		console.log($scope.ass.email);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	$scope.submitAss=function(){
		// if($scope.ass.nom=="" || $scope.ass.telf=="" || $scope.ass.facebook=="" || $scope.ass.URLWeb=="" ||  $scope.ass.email=="" ||  $scope.ass.pasMail=="" ||  $scope.ass.horari=="" ||  $scope.ass.latitud=="" || $scope.ass.longitud=="" || $scope.ass.keyApi=="" || $scope.ass.quiSom=="" || $scope.ass.equip=="" || $scope.ass.LGPD==""){
		// 	$scope.msj="Les dades no s'han actualitzat correctament. Sisplau ompli els camps buits";
		// 	$scope.divMsj=true;
		// 	$timeout(function() {
		// 		$scope.divMsj=false;
		// 	}, 3000);
		// }
		// else{
		// 	$scope.msj="Les dades s'han actualitzat correctament.";
		// 	var data = new FormData();
		// 		data.append("idVila",$scope.ass.idVila);
		// 		data.append("email",$scope.ass.email);
		// 		data.append("pasMail",$scope.ass.pasMail);
		// 		data.append("logoVila",$scope.ass.logoVila);
		// 		data.append("facebook",$scope.ass.facebook);
		// 		data.append("kayApi",$scope.ass.kayApi);
		// 		data.append("password",$scope.ass.password);
		// 		data.append("logoBolsa",$scope.ass.logoBolsa);
		// 		data.append("favIcon",$scope.ass.favIcon);
		// 		data.append("telf",$scope.ass.telf);
		// 		data.append("horari",$scope.ass.horari);
		// 		data.append("nom",$scope.ass.nom);
		// 		data.append("quiSom",$scope.ass.quiSom);
		// 		data.append("equip",$scope.ass.equip);
		// 		data.append("latitud",$scope.ass.latitud);
		// 		data.append("longitud",$scope.ass.longitud);
		// 		data.append("LGPD",$scope.ass.LGPD);
		// 		data.append("URLWeb",$scope.ass.URLWeb);
		// 		var deferred=$q.defer();
		// 	$rootScope.cargador=true;
		// 	$http.post("models/associacio.php", data,{
		// 		headers:{
		// 			"Content-type":undefined
		// 		},
		// 			transformRequest:angular.identity
		// 	})
		// 	.then(function(res){
		// 		deferred.resolve(res);
		// 		$rootScope.cargador=false;
		// 		$timeout(function() {
		// 			$scope.divMsj=false;
		// 		}, 2000);
		// 	})
		// 	.catch(function(error) {
		// 		$rootScope.cargador=false;
		// 	});
		// }
	}
})	
.controller('DirectCtrl',function($scope,$http,$q,$rootScope,$routeParams,$timeout,$window){
	$scope.llistatComer=true;
	var data = new FormData();
		data.append("acc","list");

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
		$scope.directoris=res.data;
		$rootScope.cargador=false;
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
.controller('DirectComerCtrl',function($scope,$http,$q,$rootScope,$routeParams,$timeout,$window){
	console.log("entra");
	$scope.llistatComer=false;
	$scope.com={};
	var data = new FormData();
		data.append("acc","l");
		data.append("idAssociat",$routeParams.idAssociat);
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
		console.log(res.data);
		$scope.com.categoriaPrinc="-1";
		$scope.com.categoriaNotPrinc="-1";
		$scope.comerc=res.data.comerc[0];
		$scope.categories=res.data.catego;
		$scope.categNotPrinc=res.data.catNotPrinc;
		$scope.listCatNotPrinc=res.data.listCatNotPrinc;
		$scope.com.categoriaPrinc=res.data.catPrinc[0].idCategoria;
		$scope.com.idAssociat=$scope.comerc.idAssociat;
		$scope.com.nomAssociat=$scope.comerc.nomAssociat;
		$scope.com.adreca=$scope.comerc.adreca;
		$scope.com.telf1=parseInt($scope.comerc.telf1);
		$scope.com.telf2=parseInt($scope.comerc.telf2);
		$scope.com.whatsapp=parseInt($scope.comerc.whatsapp);
		$scope.com.facebook=$scope.comerc.facebook;
		$scope.com.horari=$scope.comerc.horari;
		$scope.com.latitud=$scope.comerc.latitud;
		$scope.com.longitud=$scope.comerc.longitud;
		$scope.com.txtAssociat=$scope.comerc.txtAssociat;
		$scope.com.logoAssociat=$scope.comerc.logoAssociat;
		$scope.com.logoAssociatOld=$scope.comerc.logoAssociat;
		$scope.com.logoUpdate="";
		$scope.com.email=$scope.comerc.email;
		$scope.com.URLWeb=$scope.comerc.URLWeb;
		$rootScope.cargador=false;		
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	    if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
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
	$scope.guardar=function(){
		$scope.divMsj=true;
		if($scope.com.nomAssociat=="" || $scope.com.adreca=="" || $scope.com.facebook=="" || $scope.com.URLWeb=="" || $scope.com.latitud==""|| $scope.com.longitud=="" || $scope.com.horari=="" || $scope.com.txtAssociat==""){
			$scope.msj="Les dades no s'han actualitzat correctament. Sisplau ompli els camps buits";
			$timeout(function() {
				$scope.divMsj=false;
			}, 3000);
		}
		else{
			$scope.msj="Les dades s'han actualitzat correctament.";
			var data = new FormData();
				data.append("idAssociat",$scope.com.idAssociat);
				data.append("nomAssociat",$scope.com.nomAssociat);
				data.append("adreca",$scope.com.adreca);
				data.append("telf1",$scope.com.telf1);
				data.append("telf2",$scope.com.telf2);
				data.append("whatsapp",$scope.com.whatsapp);
				data.append("facebook",$scope.com.facebook);
				data.append("URLWeb",$scope.com.URLWeb);
				data.append("horari",$scope.com.horari);
				data.append("txtAssociat",$scope.com.txtAssociat);
				data.append("email",$scope.com.email);
				data.append("latitud",$scope.com.latitud);
				data.append("longitud",$scope.com.longitud);
				data.append("idCategoria",$scope.com.categoriaPrinc);
				data.append("acc","up");
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
				$timeout(function() {
					$scope.divMsj=false;
				}, 2000);
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
		}
	    var element = document.getElementById("divTop");
	    element.scrollIntoView({block: "end", behavior: "smooth"});
	}
	})
.controller('ContactCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
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
.controller('SociCtrl',function($scope,$http,$q,$rootScope,$timeout,$window){
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
