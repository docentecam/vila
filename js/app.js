var app=angular.module('vila',['ngRoute']);
app.run(['$rootScope',function($rootScope) {
  $rootScope.cargador=false;
  $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
  });
}]);
app.config(['$routeProvider',function($routeProvider){
	$routeProvider
	.when('/',{
		templateUrl:'views/home.html',
		controller:'HomeCtrl',
		title: "Vila"
	})
	.when('/associacio',{
		templateUrl:'views/associacio.html',
		controller:'AssociacioCtrl',
		title:"Associcació"
	})

	.when('/directori',{
		templateUrl:'views/directori.html',
		controller:'DirectoriCtrl',
		title: "Directori"
	})

		.when('/directori/:idAssociat',{
		templateUrl:'views/associat.html',
		controller:'AssociatCtrl',
		title: "Associat"
	})

	.when('/firamar',{
		templateUrl:'views/firamar.html',
		controller:'FiramarCtrl',
		title: "Firamar"
	})
	.when('/contacta',{
		templateUrl:'views/contacta.html',
		controller:'ContactaCtrl',
		title: "Contacta'ns"
	})
	.when('/politica',{
		templateUrl:'views/politica.html',
		controller:'PoliticaCtrl',
		title: "Política de dades"
	})

	.when('/noticies',{
		templateUrl:'views/noticies.html',
		controller:'NoticiesCtrl',
		title: "Noticies"
	})
	.when('/noticia/:idNoticia',{
		templateUrl:'views/noticies.html',
		controller:'NoticiaCtrl',
		title: "Noticia"
	})

	.otherwise({
		redirectTo:'/'
	});
}]);	