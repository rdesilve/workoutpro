<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'desc', 'name'
    ];
    
    public function routines(){
        return $this->hasMany('App\Routine');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
