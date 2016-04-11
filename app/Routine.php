<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function sets(){
        return $this->hasMany('App\Set');
    }
    
    public function workout(){
        return $this->belongsTo('App\Workout');
    }
}
