angular.module('vila')
.controller('IndexCtrl',function($scope,$http,$rootScope,$q){
		$rootScope.cargador=true;
	var data = new FormData();
				data.append("acc","l");

			var deferred=$q.defer();
			
			$http.post("models/index.php", data,{
				headers:{
					"Content-type":undefined
				},
					transformRequest:angular.identity
			})
			.then(function(res){
				deferred.resolve(res);
				// $rootScope.cargador=false;
				$scope.vila=res.data[0];
				// $scope.noticies=res.data.dadesNoticies;
				// $scope.banners=res.data.dadesBanners;
				// $scope.carousel=res.data.dadesCarousel;
				// $scope.associats=res.data.dadesAssociats;
				 console.log(res.data);
				// ;

			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});

})


.controller('HomeCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	$rootScope.cargador=true;
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
				$scope.vila=res.data.dadesVila[0];
				$scope.noticies=res.data.dadesNoticies;
				$scope.banners=res.data.dadesBanners;
				$scope.carousel=res.data.dadesCarousel;
				$scope.associats=res.data.dadesAssociats;
				console.log($scope.banners);
				;

			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
})

.controller('AssociacioCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	
	var data = new FormData();
		data.append("acc","l");
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
		$scope.vila=res.data.dadesVila[0];
		$scope.serveis=res.data.dadesServeis;
		console.log($scope.serveis.length);
		$scope.equip=res.data.dadesVila[0];
		console.log(res.data);
		$scope.subserveis=res.data.dadesSubserveis;
		$scope.equip=res.data.dadesEquip[0];
		$rootScope.cargador=false;
		console.log("hola");
	})
	.catch(function(error) {
		$rootScope.cargador=false;
	});


	
})


.controller('DirectoriCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	$(".dirButton").height(($("#mapId").height())/4);
	console.log(($("#mapId").height())/4);
	console.log($("#mapId").height());


	$scope.llistat=true;
	$rootScope.cargador=true;
	var data = new FormData();
		data.append("acc","l");
	var deferred=$q.defer();
	$http.post("models/directori.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		deferred.resolve(res);
		$scope.associats=res.data.dadesAssociats;
		$scope.categoriaassociat=res.data.dadesCategoriaassociat;
		$scope.galeriaassociats=res.data.dadesGaleriaassociats;
		$scope.categories=res.data.dadesCategories;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
})

.controller('AssociatCtrl',function($scope,$http,$q,$routeParams,$rootScope){
	$scope.llistat=false;
	$rootScope.cargador=true;
	var data = new FormData();
		data.append("acc","la");
		data.append("idAssociat",$routeParams.idAssociat);
	var deferred=$q.defer();
	$http.post("models/directori.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		$scope.associat=res.data.dadesAssociat[0];
		$scope.galeriaassociat=res.data.dadesGaleriaassociat;
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
	$scope.modalFoto=function(nomFoto){
		$scope.fotoModal=nomFoto;
	}
})

.controller('NoticiesCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
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
	$scope.fotoModal="";
	$scope.llistat=false;
	$rootScope.cargador=true;
	var data = new FormData();
		data.append("acc","l");
	var deferred=$q.defer();
	$http.post("models/firamar.php", data,{
		headers:{
			"Content-type":undefined
		},
		transformRequest:angular.identity
	})
	.then(function(res){
		deferred.resolve(res);
		$rootScope.cargador=false;
		console.log(res.data);
		$scope.firamar=res.data.dadesFiramar[0];
		$scope.galeriafiramar=res.data.dadesGaleriafiramar;
		$scope.activitatsfiramar=res.data.dadesActivitatsfiramar;
		$scope.sponsors=res.data.dadesSponsors;
		$scope.participants=res.data.dadesParticipants;
		$scope.dadesTotesEdicions=res.data.dadesTotesEdicions;
			console.log(res.data.dadesParticipants);
	})
	.catch(function(error) {
		$rootScope.cargador=false;
		});
	$scope.modalFoto=function(nomFoto){
		$scope.fotoModal=nomFoto;
	}
	$scope.llistatEdicioFirmar=function(dataFiramar){
	$rootScope.cargador=true;
		var data = new FormData();
					data.append("acc","l");
					data.append("dataFiramar",dataFiramar);
				var deferred=$q.defer();
				
				$http.post("models/firamar.php", data,{
					headers:{
						"Content-type":undefined
					},
						transformRequest:angular.identity
				})
				.then(function(res){
					deferred.resolve(res);
					$rootScope.cargador=false;
					$scope.firamar=res.data.dadesFiramar[0];
					$scope.galeriafiramar=res.data.dadesGaleriafiramar;
					$scope.activitatsfiramar=res.data.dadesActivitatsfiramar;
					$scope.sponsors=res.data.dadesSponsors;
					$scope.participants=res.data.dadesParticipants;
					$scope.dadesTotesEdicions=res.data.dadesTotesEdicions;

				})
				.catch(function(error) {
					$rootScope.cargador=false;
				});

	}
})

.controller('ContactaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
	$scope.contactaMissatge=false;
	$scope.muestraError=false;
	$scope.msg="";
	$scope.fitxaSuccess=true;
	$scope.contactans={};
	$scope.contactans.nomContacte="";
	$scope.contactans.cognomContacte="";
	$scope.contactans.checkTipo="Particular";
	$scope.contactans.email="";
	$scope.contactans.telefon="";
	$scope.contactans.nomEmpresa="";
	$scope.contactans.txtContacte="";
	$scope.contactans.termes=true;
	$scope.contactaSoci={};
	$scope.contactaSoci.nomComercial="";
	$scope.contactaSoci.sectorComercial="";
	$scope.contactaSoci.adreca="";
	$scope.contactaSoci.telf="";
	$scope.contactaSoci.email="";
	$scope.contactaSoci.personaContacte="";
	$scope.contactaSoci.horari="";
	$scope.contactaSoci.termes=true;
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
				// console.log(res.data);
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

		if($scope.contactans.termes != true){
				alert("ACCEPTA LES CONDICIONS");
	}
	else if ($scope.contactans.checkTipo=="Empresa" && $scope.contactans.nomEmpresa=="") {
			$scope.muestraError=true;
			$scope.msg="El camp empresa no pot estar va buidar.";
			$timeout(function(){
				$scope.muestraError=false;
			},3000);
	}

	else if($scope.contactans.email=="" && $scope.contactans.telefon==""){
			$scope.muestraError=true;
			$scope.msg="Ha d'introduir email o telèfon.";
			$timeout(function(){
				$scope.muestraError=false;
			},3000);
	}
	else{
	 console.log("llega");
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
			console.log(""+res.data);
			$scope.contactans.nomContacte="";
			$scope.contactans.cognomContacte="";
			$scope.contactans.checkTipo="";
			$scope.contactans.email="";
			$scope.contactans.telefon="";
			$scope.contactans.nomEmpresa="";
			$scope.contactans.txtContacte="";

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
$scope.enviaSoci=function(){
	if($scope.contactaSoci.termes != true){
				alert("ACCEPTA LES CONDICIONS");
	}
	else if($scope.contactaSoci.email=="" && $scope.contactaSoci.telf==""){
			$scope.muestraError=true;
			$scope.msg="Ha d'introduir email o telèfon.";
			$timeout(function(){
				$scope.muestraError=false;
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
		$scope.fitxaSuccess=false;
		console.log(res.data);
		if(res.data.trim()=="ok") {
			$scope.msg="Missatge registrat";
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
	$scope.recarga=function(){
		console.log("Intentamos");
			$scope.contactaSoci.nomComercial="";
			$scope.contactaSoci.sectorComercial="";
			$scope.contactaSoci.adreca="";
			$scope.contactaSoci.telf="";
			$scope.contactaSoci.email="";
			$scope.contactaSoci.personaContacte="";
			$scope.contactaSoci.horari="";						
			window.location.reload();
		}
})
.controller('PoliticaCtrl',function($scope,$http,$q,$rootScope,$timeout,$window,$document){
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
				deferred.resolve(res);$scope.contactaLlistat = res.data[0];
				
				console.log(res.data);
				$rootScope.cargador=false;
			})
			.catch(function(error) {
				$rootScope.cargador=false;
			});
})
