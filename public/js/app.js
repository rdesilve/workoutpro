
var app = angular.module('workoutroot', []);

app.controller('rootCtrl', function($scope, $http){
    $scope.loggedin = false;
    $scope.email = "";
    $scope.password = "";
    $scope.invalidLogin = "";
    $scope.loginForm = {email:"", password:""};
    
    $http.get('/auth').success(function(response){
        $scope.loggedin = (response === 'true');
        
    });
    
    $scope.login = function(){
        $http.post('/login', $scope.loginForm).success(function(auth){
            
            if (auth === 'invalid'){
                $scope.invalidLogin = "Email or Password is Invalid!";
            }
            
            $scope.loggedin = (auth === 'true');
            if ($scope.loggedin){
               $scope.loginForm = {email:"", password:""};
               $scope.invalidLogin = "";
            }
        });
    };
    
    $scope.logout = function(){
        $http.post('/logout');
        $scope.loggedin = false;
    };
    
});
