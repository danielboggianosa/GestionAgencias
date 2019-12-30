<div class="panel panel-default">
<fieldset>
<legend class="card-header">Teléfono</legend>
<div class="card-body">

    <div id="tel_dinamico">     
        <input class="form-control" type="text" name="telefono[]" placeholder="Número">
    </div>
    <input class="btn btn-link" type="button" value="Agregar Teléfono" onClick="AgregarTelefono('tel_dinamico');">
</div>
</fieldset>
</div>

<script>
    var tel_counter = 1;
    function AgregarTelefono(divName){
        var newdiv = document.createElement('div');
        newdiv.innerHTML = "<input class='form-control' type='text' name='telefono[]' placeholder='Número " + (tel_counter+1) + "'>";
        document.getElementById(divName).appendChild(newdiv);
        tel_counter++;
    }
</script>