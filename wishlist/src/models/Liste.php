<?php

namespace mywishlist\models;

use mywishlist\models\Item;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;
	
	public function __construct(){
		
	}
	
	/**
	* Retourne les items de la liste
	*/
    public function items() {
        return $this->hasMany('mywishlist\models\Item', 'liste_id')->get();
    }
	
	/**
	* Retourne toutes les listes
	*/
	public static function allListe(){
		return Liste::OrderBy('no')->get();
	}
	
	/**
	* Permet de creer une liste et l'ajoute a la base
	*/
	public function createList($des,$exp,$titre){
		$title=filter_var($titre,FILTER_SANITIZE_STRING); 
		$test=Liste::where('titre','=',$title)->first();
		
		if($test==null){
			$this->description=filter_var($des,FILTER_SANITIZE_STRING);
			$this->expiration=filter_var($exp,FILTER_SANITIZE_STRING);
			$this->titre=$title;
			$this->token=random_int(1,10000);
			
			$this->save();
		}
	}
	
	/**
	* Permet de modifier une liste
	*/
	public function modifyList($des,$exp,$titre){
		$this->description=filter_var($des,FILTER_SANITIZE_STRING);
		$this->expiration=filter_var($exp,FILTER_SANITIZE_STRING); 
		$this->titre=filter_var($titre,FILTER_SANITIZE_STRING);
			
		$this->save();
	}
	
	/**
	* Permet de supprimer une liste
	*/
	public function deleteList(){
		$this->delete();
	}
	
	/**
	* Permet de générer un token de partage de liste
	*/
	public function shareList(){
		$this->token_partage=random_int(1,10000);
		
		$this->save();
	}
}









