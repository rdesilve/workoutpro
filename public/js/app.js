
var app = angular.module('workoutroot', []);

app.controller('rootCtrl', function($scope, $http){
    
    $scope.email = "rdesilvey@gmail.com";
    $scope.password = "password";
    $scope.loggedin = false;
    
    $http.get('/auth').success(function(response){
        $scope.loggedin = (response === 'true');
        console.log($scope.loggedin);
    });
    
    $scope.login = function(){
        var data = {
            email:$scope.email,
            password:$scope.password
        };
        
        $http.post('/login', data).success(function(auth){
            $scope.loggedin = (auth === 'true');
            if ($scope.loggedin){
                $scope.email = "";
                $scope.password = "";
            }
        });
        
    };
    
    $scope.logout = function(){
        $http.post('/logout');
        $scope.loggedin = false;
    };
    
});