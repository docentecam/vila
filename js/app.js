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
	.when('/contacta',{
		templateUrl:'views/contacta.html',
		controller:'ContactaCtrl',
		title: "Contactan's"
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

}]);	