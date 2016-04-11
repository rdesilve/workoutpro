<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $fillable = [
        'weight', 'reps'
    ];
    
    public function routine(){
        return $this->belongsTo('App\Routine');
    }
}
