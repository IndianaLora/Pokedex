<?php

require_once 'Ipokes.php';
//require_once '../pokedex/database/fileHandler/pokemonesContex.php';


class pokeDatabase implements Ipokes
{
    private $pokeMetodos;
    private $context;
   
    public function __construct($directory)
    {
        
        $this->pokeMetodos = new PokeMetodos();
        $this->context = new PokemonContext($directory);
        
    }
    public function GetList()
    {
        $pokeList= array();
        
        $stmt = $this->context->db->prepare("Select * from pokemones");
        $stmt->execute();
        $result= $stmt->get_result();

        if($result->num_rows === 0){
            return $pokeList;

        }else{
            while($row = $result->fetch_object()){
              $pokemones = new pokemones();

              $pokemones->id  = $row->id;
              $pokemones->nombre  = $row->nombre;
              $pokemones->pokeFoto  = $row->pokeFoto;
              $pokemones->region  = $row->region;
              $pokemones->tipo  = $row->tipo;
              $pokemones->Stipo  = $row->Stipo;
              $pokemones->color  = $row->color;

              array_push($pokeList,$pokemones);
              
            }
        }
        $stmt->close();
        return $pokeList;
    }
    public function GetbyId($id)
    {
        $pokemones = new pokemones();
        $stmt = $this->context->db->prepare("Select * from pokemones where id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        
        $result= $stmt->get_result();

        if($result->num_rows === 0){
            return null;

        }else{
            while($row = $result->fetch_object()){
             

              $pokemones->id  = $row->id;
              $pokemones->nombre  = $row->nombre;
              $pokemones->pokeFoto  = $row->pokeFoto;
              $pokemones->region  = $row->region;
              $pokemones->tipo  = $row->tipo;
              $pokemones->Stipo  = $row->Stipo;
              $pokemones->color  = $row->color;

            }
        }
        $stmt->close();
        return $pokemones;
    }
    public function Add($entity)
    {
        
        $stmt = $this->context->db->prepare("insert into pokemones(nombre,region,tipo,Stipo,color) Values(?,?,?,?,?)");
        $stmt->bind_param("sssss",$entity->nombre,$entity->region,$entity->tipo,$entity->Stipo,$entity->color);//nombre tipo region
        $stmt->execute();
        $stmt->close();
        //para retornar ultimo id
        $pokeId=$this->context->db->insert_id;
       
        $photoFile = $_FILES['pokeFoto'];
        if (isset($photoFile)) {


            if ($photoFile['error'] == 4) {
                $entity->pokeFoto = "";
            } else {
                $typeReplace = str_replace("image/","", $photoFile['type']);
                $type = $photoFile['type'];
                $size = $photoFile['size'];
                $nombre = "./img/pokemones/" . $pokeId . '.' . $typeReplace;
                $tmpname = $photoFile['tmp_name'];

                $succes = $this->pokeMetodos->uploadImage('./img/pokemones/', $nombre, $tmpname, $type, $size);

                if ($succes) {
                    $stmt = $this->context->db->prepare("Update pokemones set pokeFoto =? where id =?");
                    $stmt->bind_param("si",$nombre,$pokeId);//nombre tipo region
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
        
    }
    public function Update($id,$entity)
    
    {
          $element=$this->GetbyId($id);

        $stmt = $this->context->db->prepare("Update pokemones set nombre=?,region=?,tipo=?,Stipo=?,color=? where id = ?");
        $stmt->bind_param("sssssi",$entity->nombre,$entity->region,$entity->tipo,$entity->Stipo,$entity->color,$id);
        $stmt->execute();
        $stmt->close();

        if (isset($_FILES['pokeFoto'])) {

            $photoFile = $_FILES['pokeFoto'];
            if ($photoFile['error'] == 4) {
                $entity->pokeFoto = $element->pokeFoto;
            }

            $typeReplace = str_replace("image/", "",$photoFile['type']);
            $type = $photoFile['type'];
            $size = $photoFile['size'];
            $nombre = "./img/pokemones/" .$id . '.' . $typeReplace;
            $tmpname = $photoFile['tmp_name'];

            $succes = $this->pokeMetodos->uploadImage('./img/pokemones/', $nombre, $tmpname, $type, $size);

            if ($succes) {
                $stmt = $this->context->db->prepare("Update pokemones set pokeFoto =? where id =?");
                $stmt->bind_param("si",$nombre,$id);//nombre tipo region
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    public function Delete($id)
    {
        $stmt = $this->context->db->prepare("Delete from pokemones where id =?");
                $stmt->bind_param("i",$id);//nombre tipo region
                $stmt->execute();
                $stmt->close();
        
        
    }
    
}
?>