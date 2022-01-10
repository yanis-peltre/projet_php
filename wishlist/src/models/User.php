<?php

namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = "user";
    protected $primaryKey = "userid";
    public $timestamps = false;

    public function role(){
        return $this->belongsTo(Role::class,'roleid');
    }

}