<?php
require('database.php');
session_start();
if (isset($_SESSION['user_username'])) {
  $user = $_SESSION['user_username'];
  //seleccionamos todas las personas
  $records = $conn->prepare('SELECT * FROM personas');
  $records->execute();
  $results = $records->fetchAll();
  //calculamos cuantos articulos habra por pagina y cuantas paginas hay
  $articulosxpagina = 40;
  $nump = $records->rowCount();
  $paginas = $nump / $articulosxpagina;
  $paginas = ceil($paginas);
} else {
  header('Location: /hlc/loginPhpSql/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Pagina</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
          </li>
        </ul>
      </div>
      <div class="dropdown">
        <button class="btn dropdown-toggle btn-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php
          $sql = "SELECT imagen FROM imagenes WHERE usuario=:usuario";
          $query = $conn->prepare($sql);
          $query->bindParam(":usuario", $user);
          $query->execute();
          $result = $query->fetch(PDO::FETCH_ASSOC);
          if (isset($result['imagen'])):
          ?>
          <img src="obtenerfoto.php?user=<?= $user ?>" class="rounded-circle" height="35">
          <?php else: ?>
          <img src="./usuariopordefecto.png" class="rounded-circle" height="35">
          <?php endif; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
          <li><a class="dropdown-item" href="editarusuario.php">Configurar perfil</a></li>
          <li class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!--Paginacion-->
  <div class="container my-5">
    <h1 style="color: white;">Paginación</h1>
    <!--si no hay ningun get redireccionamos a la pagina uno-->
    <?php
    if (!$_GET) {
      header('Location: /hlc/loginPhpSql/home.php?pagina=1');
    }
    if ($_GET['pagina']>$paginas||$_GET['pagina']<=0) {
      header('Location: /hlc/loginPhpSql/home.php?pagina=1');
    }
    //seleccionamos las personas deseadas segun la pagina
    $inicio = ($_GET['pagina'] - 1)*$articulosxpagina;
    $rec = $conn->prepare('SELECT * FROM personas LIMIT :inicio,:final');
    $rec->bindParam(':inicio',$inicio,PDO::PARAM_INT );
    $rec->bindParam(':final',$articulosxpagina,PDO::PARAM_INT );
    $rec->execute();
    $results2 = $rec->fetchAll();
    ?>
    <!--mostramos los datos de las personas-->
    <?php foreach ($results2 as $dato): ?>
    <div class="alert alert-light" role="alert">
      <?php echo ($dato['first_name']) ?>
    </div>
    <?php endforeach; ?>
    <!--mostramos las paginas para poder seleccionarlas-->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item <?php echo $_GET['pagina'] <= 1 ? 'disabled' : '' ?>"><a class="page-link"
            href="home.php?pagina=<?php echo $_GET['pagina'] - 1; ?>">Anterior</a></li>
        <!--Generamos el numero de paginas de forma dinamica-->
        <?php for ($i = 0; $i < $paginas; $i++): ?>
        <li class="page-item <?php echo $_GET['pagina'] == $i + 1 ? 'active' : '' ?>">
          <a class="page-link" href="home.php?pagina=<?php echo ($i + 1) ?>">
            <?php echo ($i + 1) ?>
          </a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?php echo $_GET['pagina'] >= $paginas ? 'disabled' : '' ?>"><a class="page-link"
            href="home.php?pagina=<?php echo $_GET['pagina'] + 1; ?>">Siguiente</a></li>
      </ul>
    </nav>
  </div>
</body>

</html>