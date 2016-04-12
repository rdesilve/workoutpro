
var app = angular.module('MyApp', []);

app.controller('rootCtrl', function($scope, $http){
    
    $scope.loggedin = false;
    
    $scope.login = function(){
        var data = {
            email:$scope.login.email,
            password:$scope.login.password
        };
        
        $http.post('/login', data).success(function(auth){
            $scope.loggedin = Boolean(auth);
        });
        
        $scope.login.email = "";
        $scope.login.password = "";
    };
    
});