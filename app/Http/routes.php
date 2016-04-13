<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Authen;
use App\User;
use App\Workout;
use App\Routine;
use App\Set;

Route::get('/', function () {
    return view('root');
});

Route::post('/logout', function(){
    Authen::logout();
});

Route::post('/login', function(){
    
    if (Auth::attempt(Input::only('email', 'password'))){
        Authen::grant(Auth::user()->id);
        return "200";
    }else{
        return "500";
    }
});

Route::post('/register', function(){

    if (!Auth::attempt(Input::only('email', 'password'))){
        $user = new User;
        
        $user->name = Input::get('name');
        $user->password = Hash::make(Input::get('password'));
        $user->email = Input::get('email');
        
        $user->save();
        
        Authen::grant($user->id);
        
        return "200";
    }else{
        return "100";
    }
});

Route::get('/auth', function(){
    return Authen::check()? "200":"500";
});

Route::get('/workouts', function(){
    if (Authen::check()){
        $id = Authen::data();
        $user = User::findOrFail($id);
        $workouts = $user->workouts;
        
        foreach ($workouts as $workout){
            $workout->routines = Workout::find($workout->id)->routines;
            
            if ($workout->routines){
                foreach ($workout->routines as $routine){
                    $routine->sets = Routine::find($routine->id)->sets;
                }
            }
        }
        
        return $workouts;
    }
});

Route::post('/add/workout', function(){
    $user = User::findOrFail(Authen::data());
    $workout = Workout::create(Input::all());
    $user->workouts()->save($workout);
});

Route::post('/add/routine', function(){
    
    $workout = Workout::findOrFail(Input::get('workout'));
    $routine = Routine::create(Input::get('name'));
    $workout->routines()->save($routine);
    
});

Route::post('/add/set', function(){
    
    $routine = Routine::findOrFail(Input::get('routine'));
    
    $set = new Set;
    $set->weight = Input::get('weight');
    $set->reps = Input::get('reps');
    $set->save();
    
    $routine->sets()->save($set);
    
});