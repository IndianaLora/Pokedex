<?php

interface IFileHandler{

function CreateDirectory($path);
function SaveFile($directory,$filename,$value);
function ReadFile($directory,$filename);


}

?>