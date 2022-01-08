<?php

namespace mywishlist\models;

use mywishlist\models\Liste;
use Illuminate\Database\Eloquent\Model;

class Item extends Model{
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;
	
	public function __construct (){
		
	}

    public function liste() {
		$ob=$this->belongsTo('mywishlist\models\Liste', 'liste_id')->first();
    }
	
	public function getItem(){
		return Item::where('id','=',$this->id)->first();
	}
	
	public function getToken(){
		$liste=$this->belongsTo('mywishlist\models\Liste', 'liste_id')->first();
		
		return $liste->token;
	}
	
	public static function createItem($nom,$id_liste,$prix){
		$item=new Item();
		
		$item->nom=$nom;
		$item->liste_id=$id_liste;
		$item->tarif=$prix;
		
		$item->save();
	}
	
	/**
	* Permet d'ajouter un item dans une liste
	*/
	public function addItem($des,$tarif,$nom,$token){
		$l=Liste::where('token','=',filter_var($token,FILTER_SANITIZE_NUMBER_INT))->first();
		$this->descr=filter_var(filter_var($des,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
		$this->tarif=filter_var($tarif,FILTER_SANITIZE_NUMBER_FLOAT); 
		$this->nom=filter_var(filter_var($nom,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
		$this->liste_id=$l->no;
			
		$this->save();
	}
	
	/**
	* Permet de modifier un item
	*/
	public function modifyItem($des,$tarif,$nom){
		$this->descr=filter_var(filter_var($des,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
		$this->tarif=filter_var($tarif,FILTER_SANITIZE_NUMBER_FLOAT); 
		$this->nom=filter_var(filter_var($nom,FILTER_SANITIZE_STRING),FILTER_SANITIZE_SPECIAL_CHARS);
			
		$this->save();
	}
	
	/**
	* Permet de supprimer des items
	*/
	public function deleteItem(){
		$this->delete();
	}
}






















