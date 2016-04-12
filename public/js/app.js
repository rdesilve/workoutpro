
var app = angular.module('MyApp', []);

app.controller('rootCtrl', function($scope, $http){
    
    $scope.loggedin = false;
    
    $scope.login = function(){
        var data = {
            email:$scope.username,
            password:$scope.password
        };
        
        $http.post('/login', data).success(function(auth){
            $scope.loggedin = Boolean(auth);
        });
        
    };
    
});