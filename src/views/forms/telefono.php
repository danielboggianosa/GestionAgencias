<div class="row" id="tel_dinamico" >
    <h4 class="col-12">Teléfono</h4>
    <div class="col-md-12 d-flex"> 
        <select name="codigo[]" id="codigo"></select>   
        <input type="text" id="telefono_0" name="telefono[]" placeholder="Número">
    </div>
</div>
<input class="btn btn-link" type="button" value="Agregar Teléfono" onClick="AgregarTelefono();">

<script>
    $("#codigo").load(plugin_ruta+'src/views/forms/option-telefono.php');
    var tel_counter = 1;
    function AgregarTelefono(){
        $("#tel_dinamico").append("<div class='col-md-12 d-flex'><select name='codigo[]' id='codigo_"+tel_counter+"'></select><input type='text' id='telefono_"+tel_counter+"' name='telefono[]' placeholder='Número " + (tel_counter+1) + "'></div>");
        $("#codigo_"+tel_counter).load(plugin_ruta+'src/views/forms/option-telefono.php');
        tel_counter++;
    }
</script>