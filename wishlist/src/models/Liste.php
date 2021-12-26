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
		$res="";
		
        $ob=$this->hasMany('mywishlist\models\Item', 'liste_id')->get();
		foreach($ob as $i){
			$res=$res.$i->id . ' : '.$i->nom.'<br>';
		}
		
		return $res;
    }
	
	/**
	* Retourne toutes les listes
	*/
	public static function allListe(){
		return Liste::OrderBy('no')->get();
	}
	
	/**
	* Retourne la liste en parametres sous forme html
	*/
	public static function listListe($liste){
		$res="";
		
		foreach($liste as $li){
			$res=$res.$li->no . ' : '.$li->titre.'<br>';
		}
		
		return $res;
	}
	
	/**
	* Permet de creer une liste et l'ajoute a la base
	*/
	public function createList($des,$exp,$titre){
		$title=filter_var($titre,FILTER_SANITIZE_STRING); 
		$title=filter_var($titre,FILTER_SANITIZE_SPECIAL_CHARS);
		$test=Liste::where('titre','=',$title)->first();
		
		if($test==null){
			$this->description=filter_var($des,FILTER_SANITIZE_STRING);
			$this->description=filter_var($des,FILTER_SANITIZE_SPECIAL_CHARS);
			$this->expiration=filter_var($exp,FILTER_SANITIZE_STRING); 
			$this->expiration=filter_var($exp,FILTER_SANITIZE_SPECIAL_CHARS);
			$this->titre=$title;
			$this->token=random_int(1,10000);
			
			$this->save();
			
			return "Liste ".$title. " ajoutée. Votre token est ".$this->token.".<br>";
		}
		else{
			return "Impossible d'ajouter la liste";
		}
	}
}









