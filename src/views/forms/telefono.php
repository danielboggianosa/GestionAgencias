<div class="row">
    <h4 class="col-12">Teléfono</h4>
    <div id="tel_dinamico" class="col-md-12">     
        <input type="text" name="telefono[]" placeholder="Número">
    </div>
    <input class="btn btn-link" type="button" value="Agregar Teléfono" onClick="AgregarTelefono('tel_dinamico');">
</div>

<script>
    var tel_counter = 1;
    function AgregarTelefono(divName){
        var newdiv = document.createElement('div');
        newdiv.innerHTML = "<input type='text' name='telefono[]' placeholder='Número " + (tel_counter+1) + "'>";
        document.getElementById(divName).appendChild(newdiv);
        tel_counter++;
    }
</script>