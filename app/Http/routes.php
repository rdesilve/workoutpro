<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Authen;
use App\User;
use App\Workout;

Route::get('/', function () {
    return view('root');
});

Route::post('/logout', function(){
    Authen::logout();
});

Route::post('/login', function(){
    
    if (Auth::attempt(Input::only('email', 'password'))){
        Authen::grant(Auth::user()->id);
        return "true";
    }else{
        return "false";
    }
});

Route::get('/auth', function(){
    return Authen::check()? "true":"false";
});

Route::get('/workouts', function(){
    if (Authen::check()){
        $id = Authen::data();
        $user = User::findOrFail($id);
        $workouts = $user->workouts;
        
        foreach ($workouts as $workout){
            $workout->routines = Workout::find($workout->id)->routines;
        }
        
        return $workouts;
    }
});