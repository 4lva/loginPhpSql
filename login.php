<?php
//accedemos a la sesion
session_start();
require 'database.php';
//si los datos almacenados en $_POST mediante el formulario no estan vacios ...
if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
    //...seleccionamos el nombre y contraseña del usuario en la base de datos...
    $records = $conn->prepare('SELECT username,contrasenia FROM usuarios WHERE username=:username');
    $records->bindParam(':username', $_POST['usuario']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $message = '';
    //...si existe y las contraseña introducida coincide con la del usuario almacena el usuario en la sesion e inicia session
    if (isset($results['username'])) {
        if (password_verify($_POST['password'], $results['contrasenia'])) {
            $_SESSION['user_username'] = $results['username'];
            header('Location: /hlc/loginPhpSql/home.php');
        } else {
            //si no la variable message varia su valor
            $message = 'Credenciales incorrectas';
        }
    } else {
        $message = 'El usuario no existe';
    }
}
if (isset($_SESSION['user_username'])) {
    //si la sesion ya esta establecida redireccionamos a home
    header('Location: /hlc/loginPhpSql/home.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-auto">
                <div class="card text-white text-center bg-dark" style="border-radius: 5%;">
                    <div class="card-body">
                        <h5 class="card-title">Inicio de Sesión</h5>
                        <form action="login.php" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de
                                        usuario">
                                <label style="color:black" for="usuario">Usuario</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Contraseña">
                                <label style="color:black" for="password">Contraseña</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="recordar" name="recordar">
                                <label class="form-check-label" for="recordar">Mantener
                                    sesion iniciada</label>
                            </div>
                            <!--Muestra la variable message-->
                            <p style="color: red">
                                <?= $message ?>
                            </p>
                            <div class="d-grid">
                                <button type="submit" class="btn
                                        btn-primary">Iniciar
                                    Sesión</button>
                            </div>
                        </form>
                        <!--Da la opcion de acceder a registrarse por si el usuario no dispone de cuenta-->
                        <p>o <a href="signup.php">Registrate</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>