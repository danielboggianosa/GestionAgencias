<div >
<fieldset class="panel panel-default">
<legend class="card-header">Correo</legend>  
<div class="card-body">
    <div id="correo_dinamico">
        <input class="form-control" type="email" name="correo[]" placeholder="correo"/>
    </div>
    <input class="btn btn-link" type="button" value="Agregar Correo " onClick="AgregarCorreo('correo_dinamico');"><br>
</div>  
</fieldset>
</div>

<script>
    var web_counter = 1;
    function AgregarCorreo(divName){        
        web_counter++;
        var newdiv = document.createElement('div');
        newdiv.innerHTML = "<input class='form-control' type='email' name='correo[]' placeholder='correo " + web_counter + "'/>";
        document.getElementById(divName).appendChild(newdiv);
    }
</script>