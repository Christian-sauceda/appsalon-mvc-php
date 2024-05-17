<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <div class="contenedor-app">
        <div class="imagen">
        </div>
        <div class="app">
            <?php if (isset($_SESSION['login'])) : ?>
                <div class="barra">
                    <p>¡Hola, <?php echo $nombre ?? '' ?>!</p>
                    <a class="botonsesion" href="/logout">Cerrar Sesión</a>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['admin'])) { ?>
                <div class="barra-servicios">
                    <a class="boton-azul" href="/admin">Ver Citas</a>
                    <a class="boton-azul" href="/servicios">Ver Servicios</a>
                    <a class="boton-azul" href="/servicios/crear">Nuevo Servicio</a>
                </div>
            <?php } ?>

            <?php echo $contenido; ?>

        </div>
    </div>
    <?php
    echo $script ?? '';
    ?>

</body>

</html>