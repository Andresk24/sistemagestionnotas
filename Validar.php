<?php
include_once 'ConexionBD.php';
include_once 'Usuario.php';

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];


$user = new Usuario('usuario', $usuario);
if (!$user->validar($clave)) {
    if ($user->getUsuario() != null);
    $mensaje = 'Usuario y / o contraseña incorrecta';
    header("location: index.php?Error=$mensaje");
} else {
    session_start();
    $_SESSION['usuario'] = $user->getUsuario();

    header("location: mostrar_estudiantes.php");
}
?>
