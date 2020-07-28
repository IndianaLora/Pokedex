<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registros</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="registro">
  <?php
   include 'header.php';
   require_once '../pokedex/database/fileHandler/pokemonContex.php';
   require_once 'pokeMetodos.php';
   require_once 'pokeDatabase.php';
   require_once 'pokemones.php';
  
  $metodos= new pokeMetodos();
  
  //verbos HTTP
  //Si es usado 
  if($_SERVER['REQUEST_METHOD']==='POST')
  {
    $metodos->getPokemones();
  }
  ?>
<div class="">
  <div id="container">

    <div class="formulario-center">
      <h1 class="text-center">Pokedex</h1>
      <div class="form-group">
        <!--Get Post redirect-->
        <form action="index.php" enctype="multipart/form-data" method="POST" name="pokemones">
          <!--POST se utiliza para los form siempre -->
          </br>
          <table align="center">
            <th><label for="">Nombre</label>
            <td><input type="text" name="nombre" id="" class="form-control"></td>
            <tr>
              <th><label for="">PokeFoto</label>
              <td><input type="file" name="pokeFoto" class="form-control" rows="3"></td>
            <tr>
            
              <th><label for="">Region</label>
              <td><select name="region" id="region">

                  <?php foreach ($metodos->region as $id => $text) : ?>

                    <option value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php endforeach; ?>

                </select>
                <th><label for="">Tipo</label>
              <td><select name="tipo"id="region" >

                  <?php foreach ($metodos->tipo as $id => $text) : ?>

                    <option value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php endforeach; ?>

                </select>
              </td>
        
              <th><th><label for="">Segundo tipo</label>
              <td><select name="Stipo"id="region" >

                  <?php foreach ($metodos->Stipo as $id => $text) : ?>

                    <option value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php endforeach; ?>

                </select>
              </td>
            <tr>
              <th>
              <th><label for="">Color</label>
            <td><input type="color" class="form-control" name="color" value="purple"></td>
            <tr>
              </th>
          </table>
          <button type="submit" name="submit"class="btn btn-danger float-right"onclick="pokeList.php">Guardar</button>
        </form>
      </div>
    </div>
  </div>
  </div>
</body>

</html>