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
		$ob=$this->belongsTo('mywishlist\models\Liste', 'liste_id')->first();;
		return $ob->id . ' appartient à la liste '.$ob->liste_id.'<br>';
    }
	
	public static function listItem(){
		$res="";
		
		$objets=Item::select('id','liste_id','nom')->get();
		foreach($objets as $ob){
			$res=$res.$ob->id . ' de la liste '.$ob->liste_id. ' : '.$ob->nom.'<br>';
		}
		
		return $res;
	}
	
	public function getItem(){
		$res="";
		
		$objetid=Item::where('id','=',$this->id)->first();
		$res=$objetid->id." : ".$objetid->nom.'<br>';
		
		return $res;
	}
	
	public function createItem($nom,$id_liste,$prix){
		$this->nom=$nom;
		$this->liste_id=$id_liste;
		$this->tarif=$prix;
		
		$this->save();
	}
	
	/**
	* Permet de creer une item dans une liste
	*/
	public function addItem($des,$prix,$nom){
		$nom=filter_var($nom,FILTER_SANITIZE_STRING); 
		$nom=filter_var($nom,FILTER_SANITIZE_SPECIAL_CHARS);
		
		$this->descr=filter_var($des,FILTER_SANITIZE_STRING);
		$this->descr=filter_var($des,FILTER_SANITIZE_SPECIAL_CHARS);
		$this->tarif=filter_var($prix,FILTER_SANITIZE_NUMBER_FLOAT); 
		$this->nom=$nom;
			
		$this->save();
			
		return "Objet ".$nom. " ajouté à la liste ".$this->liste_id.".";
	}
}






















