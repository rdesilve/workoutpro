<?php

?>

<html ng-app='workoutroot'>
    
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script type="text/javascript" src="/js/app.js"></script>
    
    <body ng-controller='rootCtrl'>
        
        <h2>Workout-Pro</h2>
        
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <strong class="navbar-brand">Workout Log</strong>
                </div>
                
                <div ng-if='!loggedin'>
                    <strong>{{invalidLogin}}</strong>
                    <form class="navbar-form navbar-right" ng-submit="login()">
                        <div class="form-group">
                            <input class="form-control" placeholder='Email' type='text' 
                               ng-model='loginForm.email' required/>
                        </div>
                        
                        <div class="form-group">
                            <input class="form-control" placeholder='Password' type='password' 
                               ng-model='loginForm.password' required/>
                        </div>
                        
                        <button class="btn btn-success" type='submit'>Log In</button>
                    </form>
                </div>
                
                <div ng-if="loggedin">
                    
                    <div class="navbar-form form-group">
                        <button class="btn btn-success navbar-right" ng-click="logout()">Log Out</button>
                    </div>
                </div>
            </div>
        </nav>
        
        
        
        <div ng-if="loggedin">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Your Workout Log</h3>
                    </div>
                    <div class="panel-body">
                        Content
                    </div>
                </div>
            </div>
        </div>
        
        <div ng-if="!loggedin">
            <div class="container">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Welcome!</h3>
                    </div>
                    <div class="panel-body">
                        To view your workout log, log in at the top
                        or register to get started.
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    
</html>