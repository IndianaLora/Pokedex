<?php

class pokemones
{
    public $id;
    public $nombre;
    public $pokeFoto;
    public $region;
    public $tipo;
    public $Stipo;
    public $color;


    private $pokeMetodos;
    public function __construct()
    {
        $this->pokeMetodos = new pokeMetodos();
    }
    public function InicializeData($id, $nombre, $pokeFoto, $region, $tipo, $Stipo, $color)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->foto = $pokeFoto;
        $this->region = $region;
        $this->tipo = $tipo;
        $this->Stipo = $Stipo;
        $this->color = $color;
    }
    public function set($data)
    {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }
}
?>