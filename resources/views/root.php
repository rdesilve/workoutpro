<?php

?>

<html ng-app="workoutroot">
    
    <head>
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        <script type="text/javascript" src="/js/app.js"></script>
    
    </head>
    
    
    
    <body ng-controller="rootCtrl">
        
        <h2>Workout-Pro</h2>
        <!-- Navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <strong class="navbar-brand">Workout Logger</strong>
                </div>
                
                <!-- If the user is not logged in, show the login inputs-->
                <div ng-if="!loggedin">
                    <form class="navbar-form navbar-right" ng-submit="login()">
                        <div class="form-group">
                            <input class="form-control" placeholder="Email" type="email" 
                               ng-model="loginForm.email" required/>
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" type="password" 
                               ng-model="loginForm.password" required/>
                        </div>
                        
                        <button class="btn btn-success" type="submit">Log In</button>
                    </form>
                </div>
                
                <!-- If the user is logged in then display a log out button -->
                <div ng-if="loggedin">
                    <div class="navbar-form form-group">
                        <button class="btn btn-success navbar-right" ng-click="logout()">Log Out</button>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Login error message -->
        <div ng-if="loginError.showErrorMsg" class="alert alert-danger" role="alert">{{loginError.errorMsg}}</div>
        
        <!--The container that holds the workouts table and workout log-->
        <div ng-if="loggedin">
            
            <!--The container that holds the workout display table-->
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title" >
                            <a href="" ng-click="showWorkoutTable = !showWorkoutTable">Workouts</a>
                        </h3>
                    </div>
                    <div class="panel-body" ng-show="showWorkoutTable">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Workout
                                        </th>
                                        <th>
                                            Routines
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="workout in workouts">
                                        <td>
                                            {{workout.name}}
                                        </td>
                                        <td>
                                            <ul>
                                                <li ng-repeat="routine in workout.routines">
                                                    {{routine.name}} <button ng-click="deleteRoutine(routine, workout)" class="btn btn-xs btn-link">Remove</button>
                                                </li>
                                            </ul>
                                            <div class="form-group">
                                                <form ng-submit="addRoutine(workout.newRoutine.name, workout)">
                                                    <input class="form-control" placeholder="name of routine" type="text" 
                                                       ng-model="workout.newRoutine.name" required/>
                                                    <button type="submit" class="btn btn-xs btn-primary">Add</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <button ng-click="deleteWorkout(workout)" class="btn btn-xs btn-primary">Delete Workout</button>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <form ng-submit="addWorkout()">
                                                    <input class="form-control" placeholder="name of workout" type="text" 
                                                       ng-model="newWorkout.name" required/>
                                                    <button type="submit" class="btn btn-xs btn-primary">Add Workout</button>
                                                </form>
                                            </div>
                                            
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--The container that holds the workout log-->
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                           <a href="" ng-click="showWorkoutLogTable = !showWorkoutLogTable">Workout Log</a>
                        </h3>
                    </div>
                    <div class="panel-body" ng-show="showWorkoutLogTable">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        Select Workout
                                    </th>
                                    <th>
                                        Select Routine
                                    </th>
                                    <th>Add Set</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                                Workout
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li ng-repeat="workout in workouts">
                                                    <button ng-click="selectWorkout(workout)" class="btn btn-xs btn-link">{{workout.name}}</button>
                                                </li>
                                            </ul>
                                            <br/>
                                        </div>
                                        <strong>Selected Workout:</strong> 
                                        <br/>
                                        {{selectedWorkout.name}}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                                Routine
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li ng-repeat="routine in selectedWorkout.routines">
                                                    <button ng-click="selectRoutine(routine)" class="btn btn-xs btn-link">{{routine.name}}</button>
                                                </li>
                                            </ul>
                                            <br/>
                                        </div>
                                         <strong>Selected Routine:</strong> 
                                        <br/>
                                        {{selectedRoutine.name}}
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <form ng-submit="addSet()">
                                                <input class="form-control" placeholder="weight/distance" type="text" 
                                                   ng-model="newSet.weight" required/>
                                                <input class="form-control" placeholder="reps/time" type="text" 
                                                   ng-model="newSet.reps" required/>
                                                <button type="submit" class="btn btn-xs btn-primary">Add Set</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr ng-show="selectedRoutine !== null">
                                    <td colspan="3">
                                        Sets for Routine: {{selectedRoutine.name}}
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Weight</th>
                                                    <th>Reps</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="set in selectedRoutine.sets">      
                                                    <td>
                                                        {{set.weight}}
                                                    </td>
                                                    <td>
                                                        {{set.reps}}
                                                    </td>
                                                    <td><button ng-click="deleteSet(set)" class="btn btn-xs btn-primary">Delete</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div ng-if="addSetError.showErrorMsg" class="alert alert-danger" role="alert">{{addSetError.errorMsg}}</div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!--The container that holds the registration form-->
        <div ng-if="!loggedin">
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Welcome!</h3>
                    </div>
                    <div class="panel-body">
                        To view/edit your workout log, log in at the top
                        or register below to get started.
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <form class="form-signin" ng-submit="registerUser()">
                            <h3 class="form-signin-heading">Register</h3>
                            <input class="form-control" type="text" placeholder="Name"
                                   ng-model="register.name" required/>
                            <input class="form-control" type="email" placeholder="Email"
                                   ng-model="register.email" required/>
                            <input class="form-control" type="password" placeholder="Password"
                                   ng-model="register.password" required/>
                            <input class="form-control" type="password" placeholder="Confirm Password"
                                   ng-model="register.confirmPassword" required/>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    
</html>