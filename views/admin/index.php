<h1 class="nombre-pagina">Panel de Administracion</h1>
<p class="descripcion-pagina"></p>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha ?>">
        </div>

    </form>
<?php
    if (count($citas) === 0) { ?>
        <h2 style="padding: 1rem; color:#0da6f3;" class="mensaje">No hay citas programadas para esta fecha</h2>
    <?php
    }
    ?>
</div>
<div class="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach($citas as $key => $cita) {
            if ($idCita !== $cita->id) {
                $idCita = $cita->id;
                $total = 0;
        ?>
                <li>
                    <div class="info-cita">
                    <p>Hora: <span><?php echo $cita->hora ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
                    <p>Email: <span><?php echo $cita->email ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono ?></span></p>
                    </div>
                    <h3>Servicios</h3>
                <?php } //fin de if 
                $total += $cita->precio;
                ?>
                <p class="servicios"><span><?php echo $cita->servicio ?></span> <?php echo "$". $cita->precio ?></p>
                <?php
                    $actual = $cita->id;
                    $proximo = $citas[$key + 1]->id ?? 0;
                    if(esUltimo($actual, $proximo)) { ?>
                        <p class="total">Total: <span><?php echo "$". $total ?></span></p>
                        
                        <form class="eliminar-cita" action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                            <input type="submit" value="Eliminar" class="boton-eliminar">
                        </form>
                        <?php

                    }
                ?>
            <?php
        } //fin foreach 
            ?>
    </ul>
    
</div>

<?php
$script = "
    <script src='build/js/buscador.js'></script>
    ";
?>