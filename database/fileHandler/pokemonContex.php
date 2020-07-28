<?php 

require_once '../pokedex/database/fileHandler/JsonFile.php';
class PokemonContext{

    public $db;

    public $json;
    
    public function __construct($directory)
    {
               //analizar
        $this->json = new JsonFile("./database","configuration");
        $configuration = $this->json->ReadConfiguration();
        $this->db = new mysqli($configuration->server,$configuration->user,$configuration->password,$configuration->database);
        if($this->db->connect_error){
            exit('ERROR AL CONECTAR');
        }
    }
}
?>