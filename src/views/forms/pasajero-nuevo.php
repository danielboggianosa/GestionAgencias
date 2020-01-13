<div class="form-style-8 row" id="pasajero-nuevo">
    <h3 class="col-md-12">Datos Principales</h3>
    <div class="col-md-6 col-sm-12" id="nombre">
        <label for="nombre">Nombres:</label>    
        <input name="nombre" type="text" placeholder="Escribe el nombre del cliente o solicitante" required>
    </div>

    <div class="col-md-6 col-sm-12" id="apellidos">
        <label for="apellido">Apellidos:</label>
        <input name="apellido" type="text" placeholder="Escribe el apellido del cliente o solicitante" required>
    </div>

    <div class="col-md-6 col-sm-12" id="nacion">
        <label for="nacionalidad">Nacionalidad:</label>
        <select name="nacionalidad" id="nacionalidad"></select>
    </div>

    <div class="col-md-6 col-sm-12" id="nacimiento">
        <label for="nacimiento">Fecha de nacimiento:</label>
        <input type="date" name="nacimiento">
    </div>

    <div class="col-md-6 col-sm-12" id="fuente">
        <label for="fuente">Fuente de Marketing:</label>
        <input type="text" name="fuente">
    </div>

    <button class="btn btn-link col-md-12" type="button" id="DetallesAdd">Agregar Más Detalles</button>
    <div id="masdetalles"></div>

    <div id="telefono"></div>
    <div id="correo"></div>    
    <div id="identificacion"></div>    

</div>

<script>
$("#DetallesAdd").click(()=>{
    $("#masdetalles").html('<label for="observacion">Observaciones: </label><textarea name="observacion"></textarea><label for="foto">Foto: </label><input type="file" name="foto" id="foto"><div id="direccion"></div>');
    $("#direccion").load(plugin_ruta+"src/views/forms/direccion.php");
});
$("#nacionalidad").load(plugin_ruta+"src/views/forms/option-pais.php");
$("#identificacion").load(plugin_ruta+"src/views/forms/identificacion.php");
$("#telefono").load(plugin_ruta+"src/views/forms/telefono.php");
$("#correo").load(plugin_ruta+"src/views/forms/correo.php");


</script>