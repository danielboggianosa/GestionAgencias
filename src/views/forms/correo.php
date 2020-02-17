<h4>Correo</h4> 
<div id="correo_dinamico" class="row">
    <div class="col-4">
        <input type="email" name="correo[]" placeholder="correo"/>
    </div>
</div>
<input class="btn btn-link" type="button" value="Agregar Correo " onClick="AgregarCorreo();">

<script>
    var web_counter = 1;
    function AgregarCorreo(){        
        web_counter++;
        $("#correo_dinamico").append("<div class='col-4'><input type='email' name='correo[]' placeholder='correo " + web_counter + "'/></div>");
    }
</script>