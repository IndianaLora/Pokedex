<?php

interface Ipokes{
    public function GetbyId($id);
    public function GetList();
    public function Add($entity);
    public function Update($id,$entity);
    public function Delete($id);

}
?>