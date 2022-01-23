<?php declare(strict_types = 1);

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
        return $this->hasMany('mywishlist\models\Item', 'liste_id');
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
	public function createList($des,$exp,$titre,$userid,$publique){
		$title=filter_var($titre,FILTER_SANITIZE_STRING);
        $this->description=filter_var($des,FILTER_SANITIZE_STRING);
        $this->expiration=filter_var($exp,FILTER_SANITIZE_STRING);
        $this->titre=$title;
        $this->token=bin2hex(openssl_random_pseudo_bytes(32));
        $this->user_id = $userid;
        if($publique){
            $this->publique = 'x';
        }
        $this->save();
	}
	
	/**
	* Permet de modifier une liste
	*/
	public function modifyList($des,$exp,$titre){
		$this->description=filter_var($des,FILTER_SANITIZE_STRING);
		$e=filter_var($exp,FILTER_SANITIZE_STRING);
		if($e>=date('Y-m-d', time())){
			$this->expiration=$e; 
		}
		$this->titre=filter_var($titre,FILTER_SANITIZE_STRING);
			
		$this->save();
	}
	
	/**
	* Permet de supprimer une liste
	*/
	public function deleteList(){
		$items=Item::where('liste_id','=',$this->no)->get();
		foreach($items as $ob){
			$ob->delete();
		}
		
		$this->delete();
	}
	
	/**
	* Permet de générer un token de partage de liste
	*/
	public function shareList(){
		$this->token_partage=bin2hex(openssl_random_pseudo_bytes(32));
		
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

    /**
     * Ajoute un message à une liste
     */
    public function ajouterMessage(String $message){
		$this->message=filter_var($message,FILTER_SANITIZE_STRING);
		$this->save();
    }
	
	/**
     * Permet de valider une liste
     */
    public function valider(){
		$this->valide='x';
		$this->save();
    }
}









