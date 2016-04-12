
var app = angular.module('workoutroot', []);

app.controller('rootCtrl', function($scope, $http){
    $scope.loggedin = false;
    $scope.invalidLogin = "";
    $scope.loginForm = {email:"", password:""};
    
    $scope.getWorkouts = function(){
        $http.get('/workouts').success(function(data){
            $scope.workouts = data;
        });
    };
    
    $scope.getWorkouts();
    
    $http.get('/auth').success(function(response){
        $scope.loggedin = (response === 'true');
    });
    
    $scope.login = function(){
        $http.post('/login', $scope.loginForm).success(function(auth){
            
            $scope.loggedin = (auth === 'true');
            if ($scope.loggedin){
               $scope.loginForm = {email:"", password:""};
               $scope.invalidLogin = "";
            }else{
                $scope.invalidLogin = "Email or Password is Invalid!";
            }
        });
    };
    
    $scope.logout = function(){
        $http.post('/logout');
        $scope.loggedin = false;
    };
    
});
