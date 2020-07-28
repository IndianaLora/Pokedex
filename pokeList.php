<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
 <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>

<body class="pokelist">
  <?php
  //////////////////si reinicio la pagina se repite el ultimo array en la lista de arrays
  include('header.php');

  require_once '../pokedex/database/fileHandler/pokemonContex.php';
   require_once 'pokeMetodos.php';
   require_once 'pokeDatabase.php';
   require_once 'pokemones.php';

  $codigo = new pokeMetodos();
  $service = new pokeDatabase("./database");
  $list = $service->GetList();

  if (isset($_POST["nombre"]) && isset($_POST["region"]) && isset($_POST["tipo"])) { //Verificamos que todos los elementos region
    $pokemon = new pokemones();

    $pokemon->InicializeData(0, $_POST["nombre"], $_POST["region"], $_POST["tipo"], $_POST["Stipo"], $_POST["color"],$_FILES["pokeFoto"]);

    $service->Add($pokemon);


    header("location:/podedex/pokeList.php");
  }
  ?>
  <table class="table">
    <thead class="thead-dark">
      <tr>

        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Tipo</th>
        <th scope="col">Segundo Tipo</th>
        <th scope="col">Region</th>
        <th scope="col">Color</th>
        <th scope="col">PokeFoto</th>
        <th scope="col">Editar</th>
        <th scope="col">Borrar</th>
        <th scope="col">
          <form action="pokeList.php" enctype="multipart/form-data" id="filtro" class="text-right">

        </th>

      </tr>
    </thead>
    <?php if (!empty($list)) : ?>

      <?php foreach ($list as $pokemon) : ?>

        <tbodyd <tr>
        <th><?php echo $pokemon->id; ?></th>
          <th><?php echo $pokemon->nombre; ?></th>
          <td><?php echo $pokemon->tipo; ?></td>
          <td><?php echo $pokemon->Stipo; ?></td>
          <td><?php echo $pokemon->region; ?></td>
          <td style="background-color:<?php echo $pokemon->color; ?>;">PokeColor☺</td>
          <td><img style="border: 5px solid grey;" src="<?php echo $pokemon->pokeFoto; ?>" width="160px" height="200px" aria-label="placeholder:Thumbnail"></td>

          <td><a href="pokeEditar.php?id=<?php echo $pokemon->id; ?>" class="btn btn-info">editar</a></td>
          <td><a href="delete.php?id=<?php echo $pokemon->id; ?>" class="btn btn-danger">Borrar</a></td>
          </tr>
          </tbody>

        <?php endforeach ?>
      <?php else : ?>
        <h2>No existen pokemones</h2>
      <a href="index.php" class="btn btn-warning">Crear nuevo pokemon</a>
      <?php endif ?>

  </table>

  </div>

</body>
<?php
include('footer.php');
?>

</html>