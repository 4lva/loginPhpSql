<?php
require 'database.php';
//la variable mensaje almacenara los errores ocurridos
$message = '';
//comprueba que os datos almacenados en $_POST no esten vacios
if (!empty($_POST['usuario']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
    //comprueba que las contraseñas introducidas coincidan
    if (strcmp($_POST['password'], $_POST['password2']) == 0) {
        //comprueba que el usuario no exista ya
        $records = $conn->prepare('SELECT username FROM usuarios WHERE username=:username');
        $records->bindParam(':username', $_POST['usuario']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        if (strcmp($results['username'], $_POST['usuario']) != 0) {
            //inserta los datos en la base de datos y redirige a la pagina de error
            $sql = "INSERT INTO usuarios( username, contrasenia) VALUES ( :username, :contrasenia)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $_POST['usuario']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':contrasenia', $password);

            if ($stmt->execute()) {
                header('Location: /hlc/loginPhpSql/login.php');
            } else {
                $message = 'Error al crear el usuario';
            }
        } else {
            $message = 'El usuario ya existe';
        }
    } else {
        $message = 'Las contraseñas no coinciden';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-auto">
                <div class="card text-white text-center bg-dark" style="border-radius: 5%;">
                    <div class="card-body">
                        <h5 class="card-title">Registrarse</h5>
                        <form action="signup.php" method="post">
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
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password2" name="password2"
                                    placeholder="Contraseña">
                                <label style="color:black" for="password2">Contraseña</label>
                            </div>
                            <!--Muestra la variable message-->
                            <p style="color: red">
                                <?= $message ?>
                            </p>
                            <div class="d-grid">
                                <button type="submit" class="btn
                                        btn-primary">Registrarse</button>
                            </div>
                        </form>
                        <p>o <a href="login.php">Inicia sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>