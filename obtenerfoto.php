<?php
require('database.php');
if (isset($_GET['user'])) {
    $sql = "SELECT imagen, tipo_imagen FROM imagenes WHERE usuario=:usuario";
    $query = $conn->prepare($sql);
    $user = $_GET['user'];
    $query->bindParam(":usuario", $user);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $tipo = $result['tipo_imagen'];
    header("Content-type: $tipo");
    // A continuación enviamos el contenido binario de la imagen.
    echo ($result['imagen']);
}
?>