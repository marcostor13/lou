<?php

namespace Lou;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $table = 'roles';

    public function users(){
        return $this->belongsToMany('Lou\User');
    }

}
