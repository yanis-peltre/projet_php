<?php

require_once __DIR__ . "/../../vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as DB;

$db=new DB();
$config=parse_ini_file('conf.ini');

if($config){
	$db->addConnection($config);
}

$db->setAsGlobal();
$db->bootEloquent();

//echo "Connecté à la base de données";