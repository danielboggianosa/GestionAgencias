<h4>Datos del Contacto</h4>
<div class="row" id="pasajero-nuevo">
    <div class="col-sm-12 col-md-4" id="nombre">
        <label for="nombre">Nombres:</label>    
        <input name="nombre" type="text" placeholder="Escribe el nombre del cliente o solicitante" required>
    </div>

    <div class="col-sm-12 col-md-4" id="apellidos">
        <label for="apellido">Apellidos:</label>
        <input name="apellido" type="text" placeholder="Escribe el apellido del cliente o solicitante" required>
    </div>

    <div class="col-sm-12 col-md-4" id="nacion">
        <label for="nacionalidad">Nacionalidad:</label>
        <select name="nacionalidad" id="nacionalidad"></select>
    </div>

    <div class="col-sm-12 col-md-4" id="nacimiento">
        <label for="nacimiento">Fecha de nacimiento:</label>
        <input type="date" name="nacimiento">
    </div>

    <div class="col-sm-12 col-md-4" id="fuente">
        <label for="fuente">Fuente de Marketing:</label>
        <input type="text" name="fuente">
    </div>

    <div class="col-sm-12 col-md-4" id="observacion">
        <label for="observacion">Observaciones: </label>
        <textarea name="observacion"></textarea>
    </div>

    <div id="telefono" class="col-12"></div>
    <div id="correo" class="col-12"></div>    
    <div id="direccion" class="col-12"></div>
    <div id="identificacion" class="col-12"></div>    
</div>
<hr>
<div class="row">
    <input type="button" class="float-right col" value="Guardar Datos" id="nuevoPasajeroSubmit">
</div>

<script>
$("#direccion").load(plugin_ruta+"src/views/forms/direccion.php");
$("#nacionalidad").load(plugin_ruta+"src/views/forms/option-pais.php");
$("#identificacion").load(plugin_ruta+"src/views/forms/identificacion.php");
$("#telefono").load(plugin_ruta+"src/views/forms/telefono.php");
$("#correo").load(plugin_ruta+"src/views/forms/correo.php");


</script>