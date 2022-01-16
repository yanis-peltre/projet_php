<?php

namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;

class Partage extends Model{
    protected $table = 'listePartage';
    protected $primaryKey = ['userid','no'];
    public $timestamps = false;
	
	public function __construct(){
		
	}
	
	/**
	* Retourne les items de la liste
	*/
    /*public static function register(int $idliste) {
		if(isset($_SESSION['profile'])){
			$id=$_SESSION['profile']['userid'];
			$test=ListePartage::select('userid','no')->where('userid','=',$id)
			->
			$l=new ListePartage();
			$l->userid=;
			$l->no=$idliste;
			$l->save();
		}
    }*/
}









