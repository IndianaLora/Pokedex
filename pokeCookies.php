<?php

require_once 'Ipokes.php';

class pokeCookies implements Ipokes
{
    private $pokeMetodos;
    private $cookiName;

    public function __construct()
    {
        $this->pokeMetodos = new PokeMetodos();
        $this->cookieName = 'pokemones';
    }
    public function GetList()
    {
        $pokeList=array();
        if (isset($_COOKIE[$this->cookieName])) {
            $pokemonesDecode = json_decode($_COOKIE[$this->cookieName], false);
            foreach ($pokemonesDecode as $elementDecode) {
                $element = new pokemones();
                $element->set($elementDecode);
                array_push($pokeList, $element);
            }
        } else {
            setcookie($this->cookieName, json_encode($pokeList), $this->pokeMetodos->GetCookieTime(), "/");
        }
        return $pokeList;
    }
    public function GetbyId($id)
    {
        $pokeList = $this->GetList();
        $elementDecode = $this->pokeMetodos->edit($pokeList, 'id', $id)[0];
        $pokemones = new pokemones();
        $pokemones->set($elementDecode);
        return $pokemones;
    }
    public function Add($entity)
    {
        $pokeList = $this->GetList();
        $pokeId = 1;
        if (!empty($pokeList)) {
            $pokeUltimo = $this->pokeMetodos->ultimaPosicion($pokeList);
            $pokeId = $pokeUltimo->id + 1;
        }
        $entity->id = $pokeId;
        $entity->pokeFoto = "";

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
                    $entity->pokeFoto =$nombre;
                }
            }
        }
        array_push($pokeList, $entity);
        setcookie($this->cookieName, json_encode($pokeList), $this->pokeMetodos->GetCookieTime(), "/");
    }
    public  function Update($id,$entity)
    
    {
        $element = $this->GetbyId($id);
        $pokeList = $this->GetList();

        $elementIndex = $this->pokeMetodos->delete($pokeList, 'id', $id);

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
                $entity->pokeFoto = $nombre;
            }
        }

        $pokeList[$elementIndex] = $entity;

        setcookie($this->cookieName, json_encode($pokeList), $this->pokeMetodos->GetCookieTime(), "/");


    }
    public function Delete($id)
    {
        $pokeList=$this->GetList();
        $elementIndex= $this->pokeMetodos->delete($pokeList,'id',$id);
        unset($pokeList[$elementIndex]);
        $pokeList= array_values($pokeList);
        setcookie($this->cookieName,json_encode($pokeList),$this->pokeMetodos->GetCookieTime(),"/");
        
    }
    
}
?>