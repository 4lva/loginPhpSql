<?php
require('database.php');
session_start();
if (isset($_SESSION['user_username'])) {
    $user = $_SESSION['user_username'];
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
            <a class="navbar-brand" href="home.php">Pagina</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="home.php">Inicio</a>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn dropdown-toggle btn-dark" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
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
                    <li><a class="dropdown-item" href="#">Configurar perfil</a></li>
                    <li class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-auto">
                <div class="card text-white text-center bg-dark" style="border-radius: 5%;">
                    <div class="card-body">
                        <h5 class="card-title">Editar usuario</h5>
                        <?php
                        $sql = "SELECT imagen FROM imagenes WHERE usuario=:usuario";
                        $query = $conn->prepare($sql);
                        $query->bindParam(":usuario", $user);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);
                        if (isset($result['imagen'])):
                        ?>
                        <img src="obtenerfoto.php?user=<?= $user ?>" class="rounded-circle" height="300" width="300"
                            style="margin-bottom: 15px;"><br>
                        <?php else: ?>
                        <img src="./usuariopordefecto.png" class="rounded-circle" height="300" width="300"
                            style="margin-bottom: 15px;"><br>
                        <?php endif; ?>
                        <div class="d-grid gap-2">
                            <a class="btn btn-primary" href="cambiarcontra.php" role="button">Cambiar contraseña</a>
                            <a class="btn btn-primary" href="cambiarfoto.php" role="button">Cambiar perfil</a>
                            <a class="btn btn-primary" href="darbaja.php" role="button">Dar de baja</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>