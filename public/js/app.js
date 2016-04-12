
var app = angular.module('workoutroot', []);

app.controller('rootCtrl', function($scope, $http){
    
    $scope.init = function(){
        $scope.selectedWorkout = {name:"", desc:"", routines:[]};
        $scope.selectedRoutine = {};
        $scope.showWorkoutTable = false;
        $scope.showWorkoutLogTable = false;
        $scope.loggedin = false;
        $scope.loginForm = {email:"", password:""};
        $scope.newWorkout = {name:"", desc:"", routines:[]};
        $scope.workouts = [];
    };
    
    $scope.resetNewSetManager = function(){
        $scope.newSet = {errorMsg:"", showErrorMsg:false};
    };
    
    $scope.resetLoginManager = function(){
        $scope.loginManager = {errorMsg:"", showErrorMsg:false};
    };
    
    $scope.resetRegistration = function(){
        $scope.register = {name:"", email:"", password:""};
    };
    
    $scope.getWorkouts = function(){
        $http.get('/workouts').success(function(data){
            $scope.workouts = data;
        });
    };
    
    $scope.init();
    $scope.resetRegistration();
    $scope.resetLoginManager();
    $scope.getWorkouts();
    
    $http.get('/auth').success(function(response){
        $scope.loggedin = (response === '200');
    });
    
    $scope.authUser = function(auth){
        switch(auth){
            case '200':
                $scope.loggedin = true;
                $scope.loginForm = {email:"", password:""};
                $scope.resetLoginManager();
                break;
            case '500':
                $scope.loginManager.errorMsg = "Email or Password is Invalid!";
                $scope.loginManager.showErrorMsg = true;
                break;
            case '100':
                $scope.loginManager.errorMsg = "User already exists!";
                $scope.register.email = "";
                $scope.loginManager.showErrorMsg = true;
                break;
        }
        
    };
    
    $scope.login = function(){
        $http.post('/login', $scope.loginForm).success(function(auth){
            $scope.authUser(auth);
            $scope.getWorkouts();
        });
    };
    
    $scope.registerUser = function(){
        $http.post('/register', $scope.register).success(function(auth){
            $scope.authUser(auth);
            $scope.resetRegistration();
            $scope.getWorkouts();
        });
    };
    
    $scope.addWorkout = function(){
        
        var data = {
            name:$scope.newWorkout.name,
            desc:$scope.newWorkout.desc
        };
        
        $http.post('/add/workout', data);
        
        $scope.workouts.push(angular.copy($scope.newWorkout));
        $scope.newWorkout.name = "";
    };
    
    $scope.addSet = function(){
        
    };
    
    $scope.selectWorkout = function(workout){
        $scope.selectedWorkout = workout;
        $scope.selectedRoutine = {};
    };
    
    $scope.selectRoutine = function(routine){
        $scope.selectedRoutine = routine;
    };
    
    $scope.removeRoutine = function(routine){
        
    };
    
    $scope.logout = function(){
        $http.post('/logout');
        $scope.loggedin = false;
    };
    
});
