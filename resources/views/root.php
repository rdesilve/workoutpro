<?php

?>

<html ng-app='workoutroot'>
    
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script type="text/javascript" src="/js/app.js"></script>
    
    <body ng-controller='rootCtrl'>
        
        <h2>Workout-Pro</h2>
        
        <form ng-if='!loggedin' ng-submit="login()">
            
            <input ng-model='login.email' type='text' value=''/>
            <br/>
            <input ng-model='login.password' type='password'/>
            <br/>
            <button type='submit'>Log In</button>
        </form>
        
    </body>
    
</html>