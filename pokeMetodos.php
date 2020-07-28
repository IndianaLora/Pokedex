<?php
require_once 'pokemones.php';
require_once '../pokedex/pokeDatabase.php';

class pokeMetodos
{
    public $region = [1 => 'Kanto', 2 => 'Johto', 3 => 'Hoenn', 4 => 'Sinnoh', 5 => 'Teselia', 7 => 'Kalos', 8 => 'Alola', 9 => 'Galar'];
    public $tipo = [1 => 'Acero', 2 => 'Agua', 3 => 'Bicho', 4 => 'Dragón', 5 => 'Eléctrico', 7 => 'Fantasma', 8 => 'Fuego', 9 => 'Hada', 10 => 'Hielo', 11 => 'Lucha', 12 => 'Normal',13 => 'Planta', 14 => 'Roca', 15 => 'Siniestro', 16 => 'Tierra', 17 => 'Veneno', 18 => 'Volador' ];
    public $Stipo = [1 => 'Acero', 2 => 'Agua', 3 => 'Bicho', 4 => 'Dragón', 5 => 'Eléctrico', 7 => 'Fantasma', 8 => 'Fuego', 9 => 'Hada', 10 => 'Hielo', 11 => 'Lucha', 12 => 'Normal',13 => 'Planta', 14 => 'Roca', 15 => 'Siniestro', 16 => 'Tierra', 17 => 'Veneno', 18 => 'Volador' ];
    public function getPokemones()
    {
        $service= new pokeDatabase("./database");
        if (!empty($_POST["nombre"]) && !empty($_POST["region"]) && !empty($_POST["tipo"])) { //Verificamos que todos los elementos esten
           
            $pokemon = new Pokemones();

            $pokemon->InicializeData(0,$_POST["nombre"],$_FILES["pokeFoto"], $_POST["region"], $_POST["tipo"],$_POST["Stipo"],$_POST["color"]);

            $service->Add($pokemon);

            header("location:/pokedex/pokeList.php");
        }
    }

    public function ultimaPosicion($lista)
    {
        $cuentaElementos = count($lista); //Haces una lista que cuente todos los elementos
        $ultimaPosicion = $lista[$cuentaElementos - 1]; //A ese ultimo elemento le restas uno ya que los arrays comienzan en [0]
        return $ultimaPosicion; //retornas el resultado

    }
    public function GetCookieTime()
    {
        return time() + 60 * 60 * 24 * 30;
    }
    //Analizar esto 
    
    //Para obtener la ultima posicion en un array


    //GetIndexElement
    public function delete($lista, $propiedad, $valor)
    {

        $index = 0;
        foreach ($lista as $key  => $elemento) {
            if ($elemento->$propiedad == $valor) {
                $index = $key;
            }
        }
        return $index;
    }
    //searchProperty
    public function edit($array, $atributo, $value)
    {

        $edit = [];
        foreach ($array as $objeto) {
            if ($objeto->$atributo == $value) {
                array_push($edit, $objeto);
            }
        }
        return $edit;
    }
    public function uploadImage($directory, $nombre, $tmpFile, $type, $size)
    {  
        $isSucces = false;
        if (($type == "image/gif")
            || ($type == "image/jpeg")
            || ($type == "image/png")
            || ($type == "image/jpg")
            || ($type == "image/JPG")
            || ($type == "image/pjpeg") && ($size < 1000000)
        ) {
            if (!file_exists($directory)) {

                mkdir($directory, 0777, true);
                if (file_exists($directory)) {
                    if (file_exists($nombre)) {
                        unlink($nombre);
                    }
                    $this->uploadFile($directory ,$nombre, $tmpFile);
                    $isSucces = true;
                }
            } else {
                if (file_exists($nombre)) {
                    unlink($nombre);
                }
                move_uploaded_file($tmpFile, $nombre);
                $isSucces = true;
            }
        } else {
            $isSucces = false;
        }
        return $isSucces;
    }
    private function uploadFile($nombre, $tmpFile)
    {
        if (file_exists($nombre)) {
            unlink($nombre);
        }
        move_uploaded_file($tmpFile, $nombre);
    }
}

