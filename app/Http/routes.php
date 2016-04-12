<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Authen;

Route::get('/', function () {
    return view('root');
});

Route::post('/logout', function(){
    Authen::logout();
    Authen::authenticate();
});

Route::post('/login', function(){
    
    if (Auth::attempt(Input::only('email', 'password'))){
        Authen::grant();
        Authen::authenticate();
        return Authen::check() == 1 ? "true":"false";
    }else{
        return "invalid";
    }
});

Route::get('/auth', function(){
    Authen::authenticate();
    return Authen::check() == 1 ? "true":"false";
});