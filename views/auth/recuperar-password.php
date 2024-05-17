<h1 class="nombre-pagina">Recuperar Password</h1><br>
<p class="desecripcion-pagina">Coloca tu nuevo password a continuación:</p>

<?php 
include_once __DIR__ . '/../templates/alertas.php';
?>

<?php if($error) return; ?>
<form class="formulario" method="POST">
    <br>
    <div class="campo">
        <label for="password">Password</label>
        <input 
        type="password" 
        id="password" 
        name="password" 
        placeholder="Tu nuevo Password" 
        />
    </div>
    <input type="submit" value="Guardar Nuevo Password" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tiene una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Obtener una</a>
</div>