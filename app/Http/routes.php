<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Authen, App\User, App\Workout, App\Routine, App\Set;

Route::get('/', function () {
    return view('root');
});

Route::get('/logout', function(){
    Authen::logout();
    return ['success'=>true];
});

Route::post('/login', function(){
    
    if (Auth::attempt(Input::all())){
        Authen::grant(Auth::user()->id);
        return ['auth'=>true];
    }else{
        return ['auth'=>false];
    }
});

Route::post('/register', function(){

    $user = User::where('column', 'EQUALS', Input::get('email'))->get() or null;
    
    if ($user == null){
        $user = new User;
        
        $user->name = Input::get('name');
        $user->password = Hash::make(Input::get('password'));
        $user->email = Input::get('email');
        
        $user->save();
        
        Authen::grant($user->id);
        
        return ['auth'=>true];
    }else{
        return ['auth'=>false];
    }
});

Route::get('/auth', function(){
    return ['auth'=>Authen::check()];
});

Route::get('/workouts', function(){
    if (Authen::check()){
        $id = Authen::data();
        $user = User::findOrFail($id);
        $workouts = $user->workouts;
        
        foreach ($workouts as $workout){
            $workout->routines = $workout->routines;
            
            if ($workout->routines){
                foreach ($workout->routines as $routine){
                    $routine->sets = $routine->sets;
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
    return $workout;
});

Route::post('/add/routine', function(){
    
    $workout = Workout::findOrFail(Input::get('workout'));
    $routine = Routine::create(Input::only('name'));
    $workout->routines()->save($routine);
    return $routine;
});

Route::post('/add/set', function(){
    
    $routine = Routine::findOrFail(Input::get('routine'));
    $set = Set::create(Input::only('weight', 'reps'));
    $routine->sets()->save($set);
    return $set;
});

Route::post('/delete/routine', function(){
    Routine::findOrFail(Input::get('routineId'))->delete();
});

Route::post('/delete/workout', function(){
    $workoutId = Input::get('workoutId');
    Workout::findOrFail($workoutId)->delete();
});

Route::post('/delete/set', function(){
    Set::findOrFail(Input::get('setId'))->delete();
});