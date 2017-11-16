<?php

require_once ("src/mf/utils/ClassLoader.php");
$load = new mf\utils\ClassLoader('src');
$load->register();

use \query\Query as Query;
use \models\Article as Article;
use \models\Categorie as Categorie;
use \connection\ConnectionFactory as Connection;

$connection = new Connection();
$config=parse_ini_file('conf/config.ini');
$connection::makeConnection($config);

/*$query = new Query();
$req = $query::table('article')->where('nom', '=', 'velo')->delete();
var_dump($req);

$article = new \models\Categorie();
$article->nom="nul";
$article->descr="du vide";
$article->insert();

$article = new Article();

$article->nom = 'livrbgggte jdr';
$article->descr = "pathfinder edition gggcollector golden remasterised signed";
$article->tarif = 5979.99;
$article->id_categ = 1;
$article->insert();
$article->delete();*/


$a = Article::first(110) ;
$categorie = $a->categorie ;



var_dump($categorie);