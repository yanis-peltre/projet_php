<?php declare(strict_types = 1);

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

    public function listes(){
        return $this->hasMany(Liste::class,'user_id');
    }

    /**
     * @throws InscriptionException
     */
    public function inscrireUser($nom, $password, $roleId, $email)
    {
        $this->username = filter_var($nom,FILTER_SANITIZE_STRING);
        $password = filter_var($password,FILTER_SANITIZE_STRING);
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->email = filter_var($email,FILTER_SANITIZE_STRING);
        $this->roleid = $roleId;
        try{
            $this->save();
        }
        catch (QueryException $e){
            echo $e->getMessage();
            if($e->getCode() == 23000) throw new InscriptionException("Username déjà utilisé");
        }

    }
}