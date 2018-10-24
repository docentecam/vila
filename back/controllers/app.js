var app=angular.module('vila',['ngRoute']);
app.run(['$rootScope',function($rootScope) {
  	$rootScope.cargador=false;
  	$rootScope.titlePag="Vilactiva";
  	$rootScope.favIcon="";
  	$rootScope.logo="";
  	$rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
   	});
}]);
app.config(['$routeProvider',function($routeProvider){
	$routeProvider
	.when('/',{
		templateUrl:'home.php',
		controller:'HomeCtrl',
		title: "Vilactiva"
	})
  .when('/',{
    templateUrl:'views/associacio.php',
    controller:'AssociCtrl',
    title: "Manteniment Associacio"
  })
  .when('/directori',{
    templateUrl:'views/directori.php',
    controller:'DirectCtrl',
    title: "Manteniment Directori"
  })