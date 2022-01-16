<?php

namespace mywishlist\models;

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

	public static function createItem($nom,$id_liste,$prix,$img=''){
		$item=new Item();

		$item->nom=$nom;
		$item->liste_id=$id_liste;
		$item->tarif=$prix;

		//rajout partie image
		$item->img=$img;

		$item->save();
	}

	/**
	* Permet d'ajouter un item dans une liste
	*/
	public function addItem($des,$tarif,$nom,$token){
		$l=Liste::where('token','=',filter_var($token,FILTER_SANITIZE_NUMBER_INT))->first();

		$this->descr=filter_var($des,FILTER_SANITIZE_STRING);
		$this->tarif=filter_var($tarif,FILTER_SANITIZE_NUMBER_FLOAT); 
		$this->nom=filter_var($nom,FILTER_SANITIZE_STRING);

		$this->liste_id=$l->no;

		$this->save();
	}

	/**
	* Permet de modifier un item
	*/
	public function modifyItem($des,$tarif,$nom){
		$this->descr=filter_var($des,FILTER_SANITIZE_STRING);
		$this->tarif=filter_var($tarif,FILTER_SANITIZE_NUMBER_FLOAT); 
		$this->nom=filter_var($nom,FILTER_SANITIZE_STRING);
			
		$this->save();
	}

	/**
	* Permet de supprimer des items
	*/
	public function deleteItem(){
		$this->delete();
	}
	
	/**
	* Ajout cagnotte
	*/
	public function addCagnotte(){
		if($this->cagnotte==null){
			$this->cagnotte=0;
			$this->save();
		}
	}
	
	/**
	* Donner de l'argent pour une cagnotte
	*/
	public function giveCagnotte(int $v){
		$this->cagnotte+=$v;
		$this->save();
	}
	
	/**
	* Réserver un item
	*/
	public function reservItem(string $n,string $m){
		$this->reserve=filter_var($n,FILTER_SANITIZE_STRING);
		$this->message=filter_var($m,FILTER_SANITIZE_STRING);
		$this->save();
	}
}











