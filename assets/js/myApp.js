var app = angular.module("myApp",[]);

var ennavidad = '/ennavidad/BD/';

app.controller("myCtrl",function ($scope,$http) {
	$http.get('/blog/DB/prueba_json.php').then(function (response) {
		$scope.users = 	response.data.records;
	});
})
