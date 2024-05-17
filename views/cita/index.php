<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<div class="app">
    <nav class="tabs">
        <button class="actual" data-paso="1">Servicios</button>
        <button data-paso="2">Informacion cita</button>
        <button data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2 class="servicios">Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación.</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2 class="datos">Tus Datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita.</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input disabled type="text" id="nombre" placeholder="Tu Nombre" value="<?php echo $nombre ?> ">
            </div>
            <div class="campo">
                <?php
                //en php obtener fecha (yyyy-mm-dd) actual tegucigalpa
                date_default_timezone_set('America/Tegucigalpa');
                $fecha = date('Y-m-d');
                $fecha = date('Y-m-d', strtotime($fecha . ' + 1 day'));
                ?>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" min="<?php echo $fecha ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora:</label>
                <input type="time" id="hora">
            </div>
            <input type="hidden" id="id" value="<?php echo $id ?> ">
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2 class="confirmacion">Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta.</p>

    </div>
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo</button>
    </div>
</div>

<?php
$script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/app.js'></script>
    ";
?>