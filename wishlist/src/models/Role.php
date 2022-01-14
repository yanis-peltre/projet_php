<?php

namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = "role";
    protected $primaryKey = "roleid";
    public $timestamps = false;

    public function users(){
        return $this->hasMany(User::class, 'roleid');
    }

}