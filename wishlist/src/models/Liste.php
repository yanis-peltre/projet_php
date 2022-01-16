<?php

namespace mywishlist\models;

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
        return $this->hasMany(Item::class, 'liste_id')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo l'id créateur de la liste
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
	
	/**
	* Retourne toutes les listes
	*/
	public static function allListe(){
		return Liste::OrderBy('expiration')->get();
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
			if(isset($_SESSION['profile'])){
				$this->user_id=$_SESSION['profile']['userid'];
			}
			
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
	
	/**
	* Rendre une liste publique
	*/
	public function putPublic(){
		if($this->publique==null){
			$this->publique='x';
		}
		else{
			$this->publique=null;
		}
		
		$this->save();
	}
}









