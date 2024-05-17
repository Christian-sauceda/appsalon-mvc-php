<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>
<?php 
include_once __DIR__ . '/../templates/alertas.php';
?>
<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        type="email" 
        name="email" 
        id="email" 
        placeholder="Tu email">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input 
        type="password" 
        name="password" 
        id="password" 
        placeholder="Tu password">
    </div>
    <input type="submit" value="Iniciar Sesión" class="boton boton-verde"> 
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿No tienes cuenta? Regístrate</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>