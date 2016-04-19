
var app = angular.module('workoutroot', []);

app.controller('rootCtrl', function($scope, $http){
    
    /**
     * Application initialization
     */
    $scope.init = function(){
        $scope.selectedWorkout = {routines:[]};
        $scope.selectedRoutine = null;
        $scope.showWorkoutTable = false;
        $scope.showWorkoutLogTable = true;
        $scope.loggedin = false;
        $scope.newWorkout = {name:"", desc:"", routines:[]};
        $scope.newRoutine = {name:"", sets:[]};
        $scope.newSet = {weight:0, reps:0};
        $scope.workouts = [];
    };
    
    /**
     * Resets all the error messages.
     */
    $scope.resetErrorLogs = function(){
        var def = {errorMsg:"", showErrorMsg:false};
        $scope.addSetError = angular.copy(def);
        $scope.loginError = angular.copy(def);
    };
    
    /**
     * Resets the registration form
     */
    $scope.resetRegistration = function(){
        $scope.register = {name:"", email:"", password:""};
    };
    
    /**
     * Resets the login form
     */
    $scope.resetLogin = function(){
        $scope.loginForm = {email:"", password:""};
    };
    
    /**
     * Gets all the workouts for the user
     */
    $scope.getWorkouts = function(){
        $http.get('/workouts').success(function(data){
            $scope.workouts = data;
        });
    };
    
    /**
     * Perform initial application setup
     */
    $scope.init();
    $scope.resetRegistration();
    $scope.resetLogin();
    $scope.resetErrorLogs();
    $scope.getWorkouts();
    
    /**
     * Authenticate when the webpage is opened
     */
    $http.get('/auth').success(function(response){
        $scope.loggedin = response.auth;
    });
    
    
    /**
     * Log in a user
     */
    $scope.login = function(){
        
        $scope.resetErrorLogs();
        
        $http.post('/login', $scope.loginForm).success(function(response){
            
            if (response.auth){
                $scope.loggedin = true;
                $scope.resetLogin();
                $scope.getWorkouts();
            }else{
                $scope.loginError.errorMsg = "Email or Password is Invalid!";
                $scope.loginError.showErrorMsg = true;
            }
        });
    };
    
    /**
     * Logs out the current user.
     */
    $scope.logout = function(){
        $http.get('/logout').success(function(response){
            if (response.success){
                $scope.loggedin = false;
                $scope.resetRegistration();
            }
        });
    };
    
    /**
     * Register a new user
     */
    $scope.registerUser = function(){
        
        $scope.resetErrorLogs();
        
        $http.post('/register', $scope.register).success(function(response){
            if (response.auth){
                $scope.loggedin = true;
                $scope.resetRegistration();
            }else{
                $scope.loginError.errorMsg = "User already exists!";
                $scope.register.email = "";
                $scope.loginError.showErrorMsg = true;
            }
        });
    };
    
    /**
     * Adds a new workout
     */
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
    
    /**
     * Adds a new Set to a selected Routine
     */
    $scope.addSet = function(){
        var weight = $scope.newSet.weight;
        var reps = $scope.newSet.reps;
        
        if ($scope.selectedRoutine === null){
            $scope.addSetError.errorMsg = "A routine must be selected";
            $scope.addSetError.showErrorMsg = true;
            return;
        }
        
        if (weight <= 0 || reps <= 0){
            $scope.addSetError.errorMsg = "Weight/Reps must be greater than 0";
            $scope.addSetError.showErrorMsg = true;
            return;
        }
        
        var data = {
            routine:$scope.selectedRoutine.id,
            weight:weight,
            reps:reps
        };
        
        $scope.resetErrorLogs();
        
        $http.post('/add/set', data).success(function(response){
            var newId = response.id;
            $scope.selectedRoutine.sets.push({weight:weight, reps:reps, id:newId});
        }).error(function(data, status){
            $scope.addSetError.errorMsg = "Set not added: " + status;
            $scope.addSetError.showErrorMsg = true;
        });
        
    };
    
    
    /**
     * Adds a new Routine
     * @param {type} name The name of the new routine
     * @param {type} workout The workout that routine is being added to
     */
    $scope.addRoutine = function(name, workout){
        var data = {
            workout:workout.id,
            name:name
        };
        
        $http.post('/add/routine', data).success(function(response){
            workout.newRoutine.name = "";
            workout.routines.push({name:name, id:response.id});
        });
    };
    
    /**
     * Selects a workout and persists the workout object.
     * @param {type} workout The workout being selected.
     */
    $scope.selectWorkout = function(workout){
        $scope.selectedWorkout = workout;
        $scope.selectedRoutine = null;
    };
    
    /**
     * Selects a routine and persists the routine object.
     * @param {type} routine The routine being selected.
     */
    $scope.selectRoutine = function(routine){
        $scope.selectedRoutine = routine;
        
        if (typeof $scope.selectedRoutine.sets === 'undefined'){
            $scope.selectedRoutine.sets = [];
        }
        
        $scope.resetErrorLogs();
    };
    
    /**
     * Removes a routine.
     * @param {type} routine The routine being removed
     * @param {type} workout The workout that the routine is being removed from.
     */
    $scope.deleteRoutine = function(routine, workout){
        var data = {
            routineId:routine.id
        };
        
        $http.post('/delete/routine', data).success(function(){
            var index = workout.routines.indexOf(routine);
            workout.routines.splice(index, 1);
            $scope.selectedRoutine = null;
        });
    };
    
    /**
     * Deletes a set from a selected routine
     * @param {type} set The set being deleted
     */
    $scope.deleteSet = function(set){
        var data = {
            setId:set.id
        };
        $http.post('/delete/set', data).success(function(){
            var index = $scope.selectedRoutine.sets.indexOf(set);
            $scope.selectedRoutine.sets.splice(index, 1);
        });
    };
    
    /**
     * Deletes a specified workout
     * @param {type} workout The workout being deleted
     */
    $scope.deleteWorkout = function(workout){
        var data = {
            workoutId:workout.id
        };
        $http.post('/delete/workout', data).success(function(){
            var index = $scope.workouts.indexOf(workout);
            $scope.workouts.splice(index, 1);
            $scope.selectedRoutine = null;
            $scope.selectedWorkout = null;
        });
    };
    
    
    
});
