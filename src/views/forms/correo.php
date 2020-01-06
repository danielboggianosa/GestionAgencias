<div class="row">
    <h4 class="col-12">Correo</h4> 
    <div id="correo_dinamico" class="col-md-12">
        <input type="email" name="correo[]" placeholder="correo"/>
    </div>
    <input class="btn btn-link" type="button" value="Agregar Correo " onClick="AgregarCorreo('correo_dinamico');"><br>
</div>

<script>
    var web_counter = 1;
    function AgregarCorreo(divName){        
        web_counter++;
        var newdiv = document.createElement('div');
        newdiv.innerHTML = "<input type='email' name='correo[]' placeholder='correo " + web_counter + "'/>";
        document.getElementById(divName).appendChild(newdiv);
    }
</script>