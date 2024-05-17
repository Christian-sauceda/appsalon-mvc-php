<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestrablece tu password escribiendo tu E-mail a continuación</p>

<?php
include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email" 
        name="email" 
        id="email" 
        placeholder="Tu email"
        />
    </div>
    <input type="submit" value="Enviar Instrucciones" class="boton boton-verde"> 
</form>

<div class="acciones">
    <a href="/">¿No tienes cuenta? Regístrate</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>