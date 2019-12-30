<div class="form-group <?php echo $cliente_show; ?>" id="pasajero-nuevo">
<div class="card">
    <legend class="card-header">Datos Principales</legend>
    <div class="card-body">
        <div class="form-group" id="nombre">
            <label for="nombre">Nombres:</label>    
            <input class="form-control" name="nombre" type="text" placeholder="Escribe el nombre del cliente o solicitante" required>
        </div>

        <label for="apellido">Apellidos:</label>
        <input class="form-control" name="apellido" type="text" placeholder="Escribe el apellido del cliente o solicitante" required>
        
        <input type="checkbox" id="detalles" name="detalles" class="invisible" onchange="MostrarFormulario('masdetalles',this.id)">
        <div class="form-group" id="nacion">
            <label for="nacionalidad">Nacionalidad:</label>
            <select name="nacionalidad" class="form-control" id="nacionalidad"></select>
        </div>
    
        <div class="form-group" id="nacimiento">
            <label for="nacimiento">Fecha de nacimiento:</label>
            <input type="date" name="nacimiento" class="form-control">
        </div>
        <div class="form-group" id="DetallesAdd">

            <label for="detalles" style="cursor: pointer;" class="btn-link">Agregar Más Detalles</label>
            <div id="masdetalles" class="hidden">
                <div id="direccion"></div>
                
                <label for="observacion">Observaciones</label>
                <textarea class="form-control" name="observacion"></textarea>
                
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
        </div>
    </div>
    
    
    
</div>
    
<div id="telefono" class="card"></div>
<div id="correo" class="card"></div>    
<div id="identificacion" class="card"></div>    

</div>

<script>

function MostrarFormulario(formid,checkid){
    checkbox1 = document.getElementById(checkid);
    if(checkbox1.checked){
        document.getElementById(formid).className -= "hidden";
    }else{        
        document.getElementById(formid).className = "hidden";
    }
    
};
$("#nacionalidad").load(plugin_ruta+"src/views/forms/option-pais.php");
$("#identificacion").load(plugin_ruta+"src/views/forms/identificacion.php");
$("#telefono").load(plugin_ruta+"src/views/forms/telefono.php");
$("#correo").load(plugin_ruta+"src/views/forms/correo.php");
$("#direccion").load(plugin_ruta+"src/views/forms/direccion.php");

</script>