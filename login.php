<?php
if (!isset($_GET['Error']))
    $mensaje = '';
else
    $mensaje = $_GET['Error'];
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar sesión</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    </head>
    <body>

        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-4 text-center">
                    <!-- Icono de sombrero de graduación -->
                    <i class="fas fa-graduation-cap fa-3x mb-4"></i>
                    <!-- Formulario de inicio de sesión -->
                    <form action="Validar.php" method="POST">
                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="text" class="form-control" id="username" name="nombre" placeholder="Ingrese su nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="clave" placeholder="Contraseña">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Acceder</button>
                        <div class="text-center mt-3">
                            <a href="#" class="text-primary">¿Olvidó su contraseña?</a>
                        </div>
                    </form>
                    <p class="mt-2">Español - Internacional (es)</p>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
