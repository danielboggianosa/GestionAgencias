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
    $nuevoPasajeroBtn.click(()=>$nuevo.load(plugin_ruta+'src/views/forms/pasajero-nuevo.php'))
    _getPasajeros();
    
    function _render(p){
        if(!p) p=pasajeros;
        p.forEach(pax=>{
            console.log(pax);
            if(pax.foto==null)
                pax.foto = '../wp-content/plugins/pdm-admin/src/imagenes/dummy-pax.jpg';
        });
        $ul.html(Mustache.render(template,{pasajeros:p}));        
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
        if(p[0].foto==null) data.pasajero.foto = '../wp-content/plugins/pdm-admin/src/imagenes/dummy-pax.jpg'
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
    function _seleccionarPasajero(e){     
        $.ajax({
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            type: 'GET',
            data: 'obtener='+e.currentTarget.id,
            success: (r)=>{                
                pasajero = eval(r);
                // _getSolicitudes();
                _renderPax(pasajero);                
            }
        });
    }
    function _alerta(mensaje){
        $("#alertaBtn").click();
        $("#alertaMsg").html(mensaje);
    }
    function _confirmar(mensaje){
        $("#confirmarBtn").click();
        $("#confirmarMsg").html(mensaje);
    }
    function _getSolicitudes(){
        $.ajax({
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            type: 'POST',
            data: 'id='+pasajero[0].id+'&solicitud=true',
            success: (res)=>{
                sol = eval(res);
                // console.log(sol);
                html='<table class="table table-hover"><thead><tr><th>ID</th><th>ESTADO</th><th>DESTINO</th><th>SERVICIOS</th><th>DESCRIPCION</th></tr><tbody>';
                for(i=0;i<sol.length;i++){
                    html+='<tr><td>'+sol[i].id+'</td><td>'+sol[i].estado+'</td><td>'+sol[i].destino+'</td><td>'+sol[i].servicios+'</td><td>'+sol[i].descripcion+'</td></tr>';
                }
                html+='</tbody></table>';
                $("#solicitudes").html(html);
            }
        })
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
            _alerta("Nombre y/o Apellidos no pueden estar vacíos")
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
                _alerta('Contacto Actualizado');
            }
        });
    }
    function actualizarFoto(){
        var foto = $("#foto")[0].files[0];
        var data=new FormData();
        data.append('fileToUpload', foto);
        if(foto.size>0){
            $.ajax({
                type:"POST",
                url: 'http://138.197.196.196/api/',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: res=>{
                    $.ajax({
                        type:"POST",
                        url:plugin_ruta+'src/controllers/pasajeroController.php',
                        data:'actualizarFoto=true&paxId='+pasajero[0].id+'&foto='+eval(res),
                        success: r=>{
                            var e={currentTarget:{id:eval(r)}};
                            _getPasajeros();
                            _seleccionarPasajero(e);
                        }
                    })
                }
            });
        }
    }
    function actualizar_Foto(){
        var foto = $("#foto")[0].files[0];
        var data=new FormData();
        data.append('fileToUpload', foto);
        data.append('actualizarFoto', true);
        data.append('paxId', pasajero[0].id);
        if(foto.size>0){
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: res=>{
                    var e={currentTarget:{id:eval(res)}};
                    _getPasajeros();
                    _seleccionarPasajero(e);
                }
            })
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
                    _alerta('Teléfono actualizado');
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
                    _alerta('Correo actualizado');
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
    function agregarDireccion(){
        var data = $("#nuevaDireccionForm").serialize();
        if(pasajero){
            $.ajax({
                type:'POST',
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data:'agregarDir=true&paxId='+pasajero[0].id+'&'+data,
                success: res=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _alerta('Dirección agregada correctamente');
                    _seleccionarPasajero(e);
                }
            })
        }
    }
    function agregarIdentificacion(){
        var data = $("#nuevaIdentificacionForm").serialize();
        if(pasajero){
            $.ajax({
                type:'POST',
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data:'agregarDoc=true&paxId='+pasajero[0].id+'&'+data,
                success: (res)=>{
                        var e={currentTarget:{id:pasajero[0].id}};
                        _alerta(res);
                        _getPasajeros();
                        _seleccionarPasajero(e);
                    }
            })
        }
    }
    function actualizarDireccion(e){
        if(pasajero){
            var id=e.target.id.split('_')[1];
            var data = $("#formActualizarDireccion").serialize();
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'actualizarDir=true&dirId='+id+'&'+data,
                success: ()=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _seleccionarPasajero(e);
                    _alerta('Dirección actualizada');
                }
            });
        }
    }
    function actualizarIdentificacion(e){
        if(pasajero){
            var id=e.target.id.split('_')[1];
            var data = $("#formActualizarIdentificacion").serialize();
            $.ajax({
                type:"POST",
                url: plugin_ruta+'src/controllers/pasajeroController.php',
                data: 'actualizarDoc=true&docId='+id+'&'+data,
                success: ()=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _seleccionarPasajero(e);
                    _alerta('Identificación actualizada');
                }
            });
        }
    }
    function borrarDireccion(e){
        var borrar = confirm("Realmente desea borrar esta dirección")
        var dirId = e.currentTarget.id.split('_')[1];
        if(borrar){
            $.ajax({
                type:"POST",
                url:plugin_ruta+"src/controllers/pasajeroController.php",
                data:"borrarDir=true&dirId="+dirId,
                success: res=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _alerta(eval(res));
                    _seleccionarPasajero(e);
                }
            })
        }
    }
    function borrarIdentificacion(e){
        var borrar = confirm("Realmente desea borrar esta identificación")
        var docId = e.currentTarget.id.split('_')[1];
        if(borrar){
            $.ajax({
                type:"POST",
                url:plugin_ruta+"src/controllers/pasajeroController.php",
                data:"borrarDoc=true&docId="+docId,
                success: res=>{
                    var e={currentTarget:{id:pasajero[0].id}};
                    _alerta(eval(res));
                    _seleccionarPasajero(e);
                }
            })
        }
    }
    function borrarPasajero(){
        if(pasajero){
            $.ajax({
                type:"POST",
                url:plugin_ruta+"src/controllers/pasajeroController.php",
                data:"borrarPax=true&paxId="+pasajero[0].id,
                success: res=>{
                    $("#expandirPasajero").click();
                    _getPasajeros()
                    _alerta('Contacto eliminado con éxito');
                }
            })
        }
    }
    return{
        actualizar: actualizarPasajero,
        actualizarFoto: actualizar_Foto,
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
        borrarPasajero: borrarPasajero,
    }
})();