<?php

?>

<html ng-app='workoutroot'>
    
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script type="text/javascript" src="/js/app.js"></script>
    
    <body ng-controller='rootCtrl'>
        
        <h2>Workout-Pro</h2>
        
        <div ng-if='!loggedin'>
            <form ng-submit="login()">

                <input name='email' type='text' ng-model='loginForm.email'/>
                <br/>
                <input name='password' type='password' ng-model='loginForm.password'/>
                <br/>
                <button type='submit'>Log In</button>
            </form>
        </div>
        
        <div ng-if="loggedin">
            <button ng-click="logout()">Log Out</button>
        </div>
        
    </body>
    
</html>