<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registros</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="editar">
  <?php
  //incluyo BD ,pokemones ya que voy a crear uno nuevo y los metodos para poder utilizarlos
  include 'header.php';
  require_once '../pokedex/database/fileHandler/pokemonContex.php';
  require_once 'pokeMetodos.php';
  require_once 'pokeDatabase.php';
  require_once 'pokemones.php';

  // un objeto de nombre $codigo y $service que contenga las variables y metodos que necesito
  $codigo = new pokeMetodos();
  $service = new pokeDatabase("./database");

  //si el id esta seteado almacena ese valor en $pokeId y se lo paso por parametro a GetbyId($pokeId);
  if (isset($_GET['id'])) {
    $pokeId = $_GET['id'];
    //GetbyId se utilza para obtener un obejeto en especifico por su ID
    $element = $service->GetbyId($pokeId);

    if (isset($_POST["nombre"]) && isset($_POST["region"]) && isset($_POST["tipo"])) { //Verificamos que todos los elementos esten

      $pokemon = new Pokemones(); // creamos un nuevo objeto o pokemon 

      $pokemon->InicializeData($pokeId, $_POST["nombre"], $_FILES["pokeFoto"], $_POST["region"], $_POST["tipo"], $_POST["Stipo"], $_POST["color"]); //seteamos los valores

      $service->Update($pokeId, $pokemon); //Lo actualizamos con el metodo previamente hecho update

      header("location:/pokedex/pokeList.php"); //redireccionamos la pagina a la lista de pokemones
    }
  }

  ?>
  <div>
    <br>
    <br>
    <div class="formulario-editar">
      <br>
      <br>
      <br>
      <h1 class="text-center">Poke Edicion</h1>
      <!--Get Post redirect-->
      <!-- especificamo el pokemon que se va a editar atraves del id que tiene -->

      <form action="pokeEditar.php?id=<?php echo $element->id ?>" enctype="multipart/form-data" method="POST" name="pokeEditar">
        <!--POST se utiliza para los form siempre -->
        </br>
        <table align="center">
          <th><label for="">Nombre</label>
          <td><input type="text" name="nombre" class="form-control" value="<?php echo $element->nombre; ?>"></td>
          <tr>

          <tr>
          <tr>
          <tr>
            <th><label for="photo">PokeFoto</label>
            <td><input type="file" name="pokeFoto" class="form-control" value="<?php echo $element->pokeFoto; ?>" rows="3"></td>
          <tr>

            <th><label for="">Region</label>
            <td><select name="region">
                <?php foreach ($codigo->region as $id => $text) : ?>
                  <?php if ($id == $element->region) : ?>
                    <option selected value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php else : ?>
                    <option value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php endif ?>

                <?php endforeach; ?>

              </select>
            <th><label for="">Tipos</label>
            <td><select name="tipo">
                <?php foreach ($codigo->tipo as $id => $text) : ?>
                  <?php if ($id == $element->tipo) : ?>
                    <option selected value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php else : ?>
                    <option value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php endif ?>

                <?php endforeach; ?>

              </select>
            </td>
          <tr>
            <th>
            <th><label for="">Segundo Tipos</label>
            <td><select name="Stipo">
                <?php foreach ($codigo->Stipo as $id => $text) : ?>
                  <?php if ($id == $element->Stipo) : ?>
                    <option selected value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php else : ?>
                    <option value="<?php echo $text ?>"><?php echo "{$text}" ?></option>
                  <?php endif ?>

                <?php endforeach; ?>

              </select>
            </td>
          <tr>
            <th>
            <th><label for="">Color</label>
            <td><input type="color" class="form-control" name="color" value="<?php echo $element->color; ?>"></td>
            </th>
            <th>
            </th>
            <button type="submit" name="submit" class="btn btn-info float-right" onclick="pokeList.php">Guardar</button>

        </table>
      </form>
    </div>
  </div>
</body>

</html>