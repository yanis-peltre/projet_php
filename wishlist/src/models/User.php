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

    public function inscrireUser($nom, $password)
    {
        $this->username = filter_var(filter_var($nom,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
        $this->password = filter_var(filter_var($password,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
        $this->roleid = 1;
        $this->save();
    }
}