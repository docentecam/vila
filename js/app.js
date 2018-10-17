var app=angular.module('vila',['ngRoute']);
app.run(['$rootScope',function($rootScope) {
  $rootScope.cargador=false;
  $rootScope.titlePag="Vila";
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


}]);	