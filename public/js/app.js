
var app = angular.module('workoutroot', []);

app.controller('rootCtrl', function($scope, $http){
    
    $scope.init = function(){
        $scope.selectedWorkout = null;
        $scope.selectedRoutine = null;
        $scope.showWorkoutTable = false;
        $scope.showWorkoutLogTable = false;
        $scope.loggedin = false;
        $scope.loginForm = {email:"", password:""};
        $scope.newWorkout = {name:"", desc:"", routines:[{sets:[]}]};
        $scope.newRoutine = {name:"", sets:[]};
        $scope.newSet = {weight:0, reps:0};
        $scope.workouts = [];
    };
    
    $scope.resetAddSetError = function(){
        $scope.addSetError = {errorMsg:"", showErrorMsg:false};
    };
    
    $scope.resetLoginError = function(){
        $scope.loginError = {errorMsg:"", showErrorMsg:false};
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
    $scope.resetLoginError();
    $scope.resetAddSetError();
    $scope.getWorkouts();
    
    $http.get('/auth').success(function(response){
        $scope.loggedin = (response === '200');
    });
    
    $scope.authUser = function(auth){
        switch(auth){
            case '200':
                $scope.loggedin = true;
                $scope.loginForm = {email:"", password:""};
                $scope.resetLoginError();
                break;
            case '500':
                $scope.loginError.errorMsg = "Email or Password is Invalid!";
                $scope.loginError.showErrorMsg = true;
                break;
            case '100':
                $scope.loginError.errorMsg = "User already exists!";
                $scope.register.email = "";
                $scope.loginError.showErrorMsg = true;
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
            desc:$scope.newWorkout.desc,
        };
        
        $http.post('/add/workout', data).success(function(response){
            $scope.newWorkout.id = response.id;
            $scope.workouts.push(angular.copy($scope.newWorkout));
            $scope.newWorkout.name = "";
        }).error(function(){
            
        });
        
    };
    
    $scope.addSet = function(){
        var weight = $scope.newSet.weight;
        var reps = $scope.newSet.reps;
        
        if (weight <= 0 || reps <= 0){
            $scope.addSetError.errorMsg = "Weight/Reps must be greater than 0";
            $scope.addSetError.showErrorMsg = true;
            return;
        }
        
        if ($scope.selectedRoutine === null){
            $scope.addSetError.errorMsg = "A routine must be selected";
            $scope.addSetError.showErrorMsg = true;
            return;
        }
        
        var data = {
            routine:$scope.selectedRoutine.id,
            weight:weight,
            reps:reps
        };
        
        $scope.resetAddSetError();
        
        $http.post('/add/set', data).success(function(){
            
            if ($scope.selectedRoutine.sets === 'undefined'){
                $scope.selectedRoutine.sets = [];
            }
            
            $scope.selectedRoutine.sets.push({weight:weight, reps:reps});
            $scope.newSet.weight = 0;
            $scope.newSet.reps = 0;
        }).error(function(data, status){
            $scope.addSetError.errorMsg = "Set not added: " + status;
            $scope.addSetError.showErrorMsg = true;
        });
        
    };
    
    $scope.addRoutine = function(name, workout){
        var data = {
            workout:workout.id,
            name:name
        };
        
        $http.post('/add/routine', data).success(function(data){
            
            workout.newRoutine.name = "";
            workout.routines.push({name:name, id:data.id});
        });
    };
    
    $scope.selectWorkout = function(workout){
        $scope.selectedWorkout = workout;
        $scope.selectedRoutine = null;
    };
    
    $scope.selectRoutine = function(routine){
        $scope.selectedRoutine = routine;
        $scope.resetAddSetError();
    };
    
    $scope.removeRoutine = function(routine, workout){
        var data = {
            routineId:routine.id
        };
        
        $http.post('/delete/routine', data).success(function(){
            var index = workout.routines.indexOf(routine);
            workout.routines.splice(index, 1);
        });
    };
    
    $scope.logout = function(){
        $http.post('/logout');
        $scope.loggedin = false;
    };
    
});
