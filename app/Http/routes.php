<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Authen;

Route::get('/', function () {
    return view('root');
});

Route::post('/login', function(){
    
    if (Auth::attempt(Input::only('email', 'password'))){
        Authen::grant(Auth::user()->name());
    }else{
        return "{attempt:false}";
    }
});

Route::get('/authen', function(){
    Authen::authenticate();
    return (string)Authen::check();
});