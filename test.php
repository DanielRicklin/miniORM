<?php 
require_once "src/query/Query.php";
$test = new Query();
/*$test::table("nom_de_table");
var_dump ($test->where("id","=","5"));
var_dump ($test->get());*/

$array = array(
    "name" => "John",
    "surname" => "Doe",
    "email" => "j.doe@intelligence.gov"
 );

$test->insert($array);

?>