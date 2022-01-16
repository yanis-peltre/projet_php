<?php

namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use mywishlist\exceptions\InscriptionException;

class User extends Model
{

    protected $table = "user";
    protected $primaryKey = "userid";
    public $timestamps = false;

    public function role(){
        return $this->belongsTo(Role::class,'roleid');
    }

    /**
     * @throws InscriptionException
     */
    public function inscrireUser($nom, $password, $roleId)
    {
        $this->username = filter_var(filter_var($nom,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_var(filter_var($password,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->roleid = $roleId;
        try{
            $this->save();
        }
        catch (QueryException $e){
            throw new InscriptionException("Username déjà utilisé");
        }

    }
}