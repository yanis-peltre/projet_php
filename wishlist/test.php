<?php

require_once __DIR__. "/vendor/autoload.php";
require_once 'src/conf/Database.php';
require_once 'src/models/Item.php';
require_once 'src/models/Liste.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;

/*$objets=Item::select('id','liste_id','nom')->get();
foreach($objets as $ob){
	print $ob->id . ' de la liste '.$ob->liste_id. ' : '.$ob->nom.'<br>';
}

$listes=Liste::select('no','titre')->get();
foreach($listes as $li){
	print $li->no . ' : '.$li->titre.'<br>';
}

$p=$_SERVER['QUERY_STRING'];
if($p !== []){
	$objetid=Item::where('id','=',$p[0])->first();
	print $objetid->nom.'<br>';
}

$i=new Item();

$i->nom='Livre nul';
$i->liste_id=Liste::select('no')->first()->no;
$i->save();

$i->delete();

if($p !== []){
	$objetsparam=Item::select('id','liste_id','nom')->where('liste_id','=',$p[0])->get();
	foreach($objetsparam as $obs){
		print $obs->id . ' de la liste '.$obs->liste_id. ' : '.$obs->nom.'<br>';
	}
}

$liste=Liste::select('no','titre')->first();
echo $liste->items();*/

$l=new Liste();
$l->createList('nul','01/01/2022','Pas terribles','Je sais pas',23);

$i=new Item();
$i->addItem('Objet quelconque',2);



















