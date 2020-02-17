var Pasajeros = (function(){
    var pasajeros=[];
    var pasajero=[];
    
    //Cache DOM
    var $el=$("#pasajerosModule");
    // var $button=$el.find('button');
    var $input=$el.find('input');
    var $ul=$el.find('ul');
    var $span=$el.find('span');
    var $nuevo=$el.find("#nuevoPasajeroForm");
    var $nuevaDireccion=$("#nuevaDireccionForm");
    var $nuevaIdentificacion=$("#nuevaIdentificacionForm");
    var $pasajero=$el.find("#formPasajero");
    var template=$el.find('#pasajeros-template').html();
    var templatePax=$el.find('#pasajero-template').html();
    var $nuevoPasajeroBtn=$("#nuevoPasajeroBtn");
    
    //BIND EVENTS
    $input.on('keyup', buscarPasajero);
    $ul.delegate('li.pasajero', 'click', _seleccionarPasajero);
    $nuevo.delegate('#nuevoPasajeroSubmit','click', agregarPasajero);
    $('#actualizarPasajero').click(()=>alert('estoy vivo'));
    _getPasajeros();
    
    function _render(p){
        if(!p) p=pasajeros;
        $ul.html(Mustache.render(template,{pasajeros:p}));
        $nuevo.load(plugin_ruta+'src/views/forms/pasajero-nuevo.php');
        $nuevaDireccion.load(plugin_ruta+'src/views/forms/direccion.php');
        $nuevaIdentificacion.load(plugin_ruta+'src/views/forms/identificacion.php');
    }
    function _renderPax(p){
        var data = {
            pasajero: p[0],
            telefono: p[1],
            correo: p[2],
            identificacion: p[3],
            direccion: p[4],
        }
        $span.html(Mustache.render(templatePax,data));
    }
    function _getPasajeros(){
        $.ajax({
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            type: 'POST',
            data: 'listar=true&estado="PASAJERO"',
            success: (r)=>{                
                var res = eval(r);
                pasajeros = res;
                _render();                
            }
        });
    }
    function agregarPasajero(){
        var data = $nuevo.serialize();
        if($("input[name='nombre']").val() && $("input[name='apellido']").val()){
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'insertar=true&'+data,
                success: (res)=>{
                    var e={currentTarget:{id:eval(res)}};
                    console.log(res);
                    $nuevoPasajeroBtn.click();
                    _getPasajeros();
                    _seleccionarPasajero(e);
                }
            });
        }
        else{
            alert("Nombre y Apellidos no pueden estar vacíos")
        }
    }
    function actualizarPasajero(){
        var data = $("#formPasajero").serialize();
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'actualizar=true&'+data,
            success: (res)=>{
                var e={currentTarget:{id:eval(res)}};
                _getPasajeros();
                _seleccionarPasajero(e);
                alert('Contacto Actualizado');
            }
        });
    }
    function actualizarFoto(){
        var data=new FormData(document.getElementById("formPasajero"));
        data.append('fileToUpload', $("#foto")[0].files[0]);
        data.append('actualizarFoto', true);
        // console.log(data);
        if(foto.size>0){
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: (res)=>{
                    var e={currentTarget:{id:eval(res)}};
                    _getPasajeros();
                    _seleccionarPasajero(e);
                    alert('Foto actualizada. Por favor recarga la página');
                }
            });
        }
    }
    function agregarTelefono(){
        var telefono=$("#telefonoModal").val();
        if(telefono){
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'agregarTel=true&paxId='+pasajero[0].id+'&telefono='+telefono,
                success: (res)=>{
                    $("#telefonoModal").val('');
                    var e={currentTarget:{id:pasajero[0].id}};
                    _getPasajeros()
                    _seleccionarPasajero(e);
                }
            });
        }
    }
    function actualizarTelefono(e){
        if(e.keyCode==13){
            var id=e.target.id.split('_')[1];
            var telefono=e.target.value;
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'actualizarTel=true&telId='+id+'&telefono='+telefono,
                success: ()=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _getPasajeros()
                    _seleccionarPasajero(e);
                    alert('Teléfono actualizado');
                }
            });
        }
    }
    function borrarTelefono(id){
        var borrar = confirm('¿Realmente desea borrar este teléfono?')
        if(borrar){
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'borrarTel=true&telId='+id,
                success: ()=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _getPasajeros()
                    _seleccionarPasajero(e);
                }
            });
        }
    }
    function agregarCorreo(){
        var correo=$("#correoModal").val();
        if(correo){
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'agregarCor=true&paxId='+pasajero[0].id+'&correo='+correo,
                success: ()=>{
                    $("#correoModal").val('');
                    var e={currentTarget:{id:pasajero[0].id}};
                    _getPasajeros()
                    _seleccionarPasajero(e);
                }
            });
        }
    }
    function actualizarCorreo(e){
        if(e.keyCode==13){
            var id=e.target.id.split('_')[1];
            var correo=e.target.value;
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'actualizarCor=true&corId='+id+'&correo='+correo,
                success: ()=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _getPasajeros()
                    _seleccionarPasajero(e);
                    alert('Correo actualizado');
                }
            });
        }
    }
    function borrarCorreo(id){
        var borrar = confirm('¿Realmente desea borrar este correo?')
        if(borrar){
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'borrarCor=true&corId='+id,
                success: ()=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _getPasajeros()
                    _seleccionarPasajero(e);
                }
            });
        }
    }
    function buscarPasajero(){
        var b = $input.val();
        p = pasajeros.filter(p=>p.nombres.toString().toLowerCase().includes(b.toLowerCase()) || p.apellidos.toString().toLowerCase().includes(b.toLowerCase()));
        _render(p);
    }
    function _seleccionarPasajero(e){     
        $.ajax({
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            type: 'GET',
            data: 'obtener='+e.currentTarget.id,
            success: (r)=>{                
                pasajero = eval(r);
                console.log(pasajero);
                _renderPax(pasajero);                
            }
        });
    }
    function agregarDireccion(){
        console.log('nuevo Direccion')
    }
    function agregarIdentificacion(){
        console.log('nueva Identificación')
    }
    function actualizarDireccion(){
        console.log('nuevo Direccion')
    }
    function actualizarIdentificacion(){
        console.log('nueva Identificación')
    }
    function borrarDireccion(){
        console.log('nuevo Direccion')
    }
    function borrarIdentificacion(){
        console.log('nueva Identificación')
    }
    return{
        actualizar: actualizarPasajero,
        actualizarFoto: actualizarFoto,
        agregarCorreo: agregarCorreo,
        actualizarCorreo: actualizarCorreo,
        borrarCorreo: borrarCorreo,
        agregarTelefono: agregarTelefono,
        actualizarTelefono: actualizarTelefono,
        borrarTelefono: borrarTelefono,
        agregarDireccion: agregarDireccion,
        actualizarDireccion: actualizarDireccion,
        borrarDireccion: borrarDireccion,
        agregarIdentificacion: agregarIdentificacion,
        actualizarIdentificacion: actualizarIdentificacion,
        borrarIdentificacion: borrarIdentificacion,
    }
})();