<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Authen;

Route::get('/', function () {
    return view('root');
});

Route::post('/logout', function(){
    Authen::logout();
});

Route::post('/login', function(){
    
    if (Auth::attempt(Input::only('email', 'password'))){
        Authen::grant();
        return Authen::check() == 1 ? "true":"false";
    }else{
        return "invalid";
    }
});

Route::get('/auth', function(){
    return Authen::check() == 1 ? "true":"false";
});