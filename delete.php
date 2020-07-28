<?php
require_once 'pokemones.php'; 
require_once '../pokedex/database/fileHandler/pokemonContex.php';
require_once 'pokeMetodos.php';
require_once 'pokeDatabase.php';

$service = new pokeDatabase("./database");
$isContaintId= isset($_GET['id']);

if($isContaintId){
    $pokeId=$_GET['id'];
    $service->Delete($pokeId);
   }

header("Location:pokeList.php");
exit();

?>