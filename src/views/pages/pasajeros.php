<?php include RUTA."/src/views/common/head.php" ?>

<div class="wrap">
    <div class="">
        <div class="buttons">
            <button class="btn btn-link" id="ver_buscar"><i class="fa fa-angle-left"></i> Buscar</button>
            <button class="btn btn-link" id="agregar_pax"><i class="fa fa-plus"></i> Nuevo Pasajero</button>
            <button class="btn btn-link" id="historial_pax"><i class="fa fa-plus"></i> Ver Historial</button>
        </div>
        <div id="form_pasajeros_dialog" class="container mx-auto px-2">.
            <form id="form_pasajero">
            </form>
            <button class="btn btn-success form-control" onclick="agregarPax()">Agregar El Pasajero</button>
        </div>
        <div id="editar_pasajero_dialog">
            <form id="editar_pasajero"></form>
        </div>

        <div class="row">
            <div class="col-md-12" id="pax_lista" style="max-height:550px">
                <div class="md-form mt-0" id="pax_search">
                    <input class="form-control" name="buscar_pax" type="text" id="buscar_pax" onKeyup="filtrarPax(this.value)" placeholder="Filtrar por Nombre o Apellido del pasajero" aria-label="Filtrar por Nombre o Apellido del pasajero">
                </div>
                <div>
                    <div class="white z-depth-1 px-3 pt-3 pb-0 overflow-auto h-auto" style="padding:1%;max-height:500px">
                        <ul class="list-unstyled friend-list" id="pax_datos">
                        <h4>Haz click en <strong>Cargar Contactos</strong></h4>
                        </ul>
                    </div>                
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="pax_detalles">
                <div class="form-style-8">
                    <h2 class="">Detalles del Pasajero
                    <button class="btn btn-info float-right" onclick="actualizarPax()">
                        <i class="fa fa-edit"></i> Actualizar</button>
                    </h2>
                    <form id="detallesCargados" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                            <label for="foto">
                                <img src="../wp-content/plugins/pdm-admin/src/imagenes/dummy-pax.jpg" alt="avatar" class="avatar rounded-circle d-flex mr-2 z-depth-1 h-auto w-auto mx-auto" style="max-height:100%;max-width:100%" id="pax_foto">
                            </label>
                            <input class="d-none" type="file" name="foto" id="foto">
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <label>Nombres:</label>
                                <input type="text" id="pax_name" name="nombre">
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <label>Apellidos:</label>
                                <input type="text" class="" id="pax_apellidos" name="apellido">
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <label>Nacimiento:</label>
                                <input type="date" id="pax_nacimiento" name="nacimiento">
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <label>Nacionalidad:</label>
                                <input type="text" id="pax_nacionalidad" name="nacionalidad">
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <label>Notas:</label>
                                <input type="text" id="pax_notas" name="observacion">
                            </div>
                            <div class="col-md-6 col-xs-12">
                            <label>Fuente de Marketing</label>
                            <input type="text" id="pax_fuente" name="fuente">
                            </div>
                        </div>
                    </form>
                    <div class="row" id="pax_documentos"></div>
                    <h3>Datos de contacto</h3>
                    <div class="row" id="pax_telefonos"></div>
                    <div class="row" id="pax_correos"></div>
                    <div class="row" id="pax_direcciones"></div>
                </div>
            </div>            
            <div class="col-md-12 form-style-8" id="pax_historial">
                <h2 class="">Historial del Pasajero</h2>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <img src="../wp-content/plugins/pdm-admin/src/imagenes/dummy-pax.jpg" alt="avatar" class="avatar rounded-circle d-flex mr-2 z-depth-1 h-auto w-auto mx-auto" style="max-height:100%;max-width:100%" id="pax_foto">
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <label>Nombres:</label>
                        <input type="text" id="sol_name">
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <label>Apellidos:</label>
                        <input type="text" class="" id="sol_apellidos">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <label>Nacimiento:</label>
                        <input type="date" id="sol_nacimiento">
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <label>Nacionalidad:</label>
                        <input type="text" id="sol_nacionalidad">
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <label>Notas:</label>
                        <input type="text" id="sol_notas">
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <label>Fuente de Marketing</label>
                        <input type="text" id="sol_fuente">
                    </div>
                </div>
                <h3>Historial</h3>
                <div class="row" id="pax_solicitudes"></div>
            </div>
        </div>
        <!-- <button class="btn btn-danger" id="NuevoPost" onclick="agregarPost()">Crear Nuevo Post</button> -->
    </div>
</div>

<script>
var pasajeros=[];
var pax,tel,cor,dir,doc;
$(document).ready(()=>{
    listarPax();
    $("#foto").change((e)=>actualizarFoto(e));

    $("#pax_detalles").hide();
    $("#pax_historial").hide();
    $("#historial_pax").hide();
    $("#form_pasajeros_dialog").hide();
    $("#editar_pasajeros_dialog").hide();
    $("#ver_buscar").hide();
    $("#ver_buscar").click(()=>{
        $("#pax_detalles").effect('drop', '', 500, ()=>{
            $("#pax_detalles").hide();
            $("#pax_lista").show();
            $("#ver_buscar").hide();
            $("#agregar_pax").show()
        })
        $("#historial_pax").hide();
    });
    // $("#editar_pasajero_dialog").dialog({
    //     autoOpen:false,
    //     width:600,
    //     height:500,
    //     modal:true,
    //     title:"Actualizar Pasajero",
    //     buttons: {"Actualizar Datos": actualizarPax,
    //         cancel: ()=>{$("#editar_pasajero_dialog").dialog( "close" );}
    //     }
    // });

    $("#agregar_pax").click(()=>{
        $("#pax_lista").effect('drop', '', 500, ()=>{
            $("#form_pasajeros_dialog").show();
            $("#form_pasajero").load(plugin_ruta+'src/views/forms/pasajero-nuevo.php');
            $("#pax_lista").hide();
            $("#ver_buscar").show();
            $("#agregar_pax").hide();
        });
    })
    $("#historial_pax").click((e)=>{
        fa = e.currentTarget.children[0].className;
        e.currentTarget.children[0].className = (fa == "fa fa-plus") ? "fa fa-minus" : "fa fa-plus";
        verHistorial();
        
    })
})

function listarPax(){
    $.ajax({
        url: plugin_ruta+'src/controllers/pasajeroController.php',
        type: 'POST',
        data: 'listar=true&estado="PASAJERO"',
        success: (r)=>{
            var res = eval(r);
            pasajeros = res;
            $("#pax_datos").html("");
            for(i=0;i<res.length;i++){
                var foto=(res[i].foto==null || res[i].foto==undefined) ? plugin_ruta+"src/imagenes/dummy-pax.jpg" : res[i].foto;
                var documento=(res[i].documento==null) ? "" : res[i].documento;
                var correo=(res[i].correo==null) ? "" : res[i].correo;
                var telefono=(res[i].telefono==null) ? "" : res[i].telefono;
                $("#pax_datos").append('<li onclick="seleccionarPax('+res[i].id+')" class="active grey lighten-3 p-2 d-flex" style="cursor:pointer"><img src="'+foto+'" width:"50" height="50" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1"><div class="text-small text-left" style="width:70%"><strong>'+res[i].nombres+' '+res[i].apellidos+'</strong><p class="last-message text-muted"><i class="fa fa-phone"></i> '+telefono+' <i class="fa fa-envelope"></i> '+correo+'</p></div><div style="width:10%"><button class="btn btn-link"><i class="fa fa-angle-right align-middle"></i></button></div></li>');
            }
        }
    });
}

function listarBuscar(res){
    // var res = eval(r);
    // pasajeros = res;
    $("#pax_datos").html("");
    for(i=0;i<res.length;i++){
        var foto=(res[i].foto==null || res[i].foto==undefined) ? plugin_ruta+"src/imagenes/dummy-pax.jpg" : res[i].foto;
        var documento=(res[i].documento==null) ? "" : res[i].documento;
        var correo=(res[i].correo==null) ? "" : res[i].correo;
        var telefono=(res[i].telefono==null) ? "" : res[i].telefono;
        $("#pax_datos").append('<li onclick="seleccionarPax('+res[i].id+')" class="active grey lighten-3 p-2 d-flex" style="cursor:pointer"><img src="'+foto+'" width:"50" height="50" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1"><div class="text-small text-left" style="width:70%"><strong>'+res[i].nombres+' '+res[i].apellidos+'</strong><p class="last-message text-muted"><i class="fa fa-phone"></i> '+telefono+' <i class="fa fa-envelope"></i> '+correo+'</p></div><div style="width:10%"><button class="btn btn-link"><i class="fa fa-angle-right align-middle"></i></button></div></li>');
    }
}
function filtrarPax(b){
    console.log(b);
    paxFiltrados = pasajeros.filter(p=>p.nombres.toString().toLowerCase().includes(b.toLowerCase()) || p.apellidos.toString().toLowerCase().includes(b.toLowerCase()));
    listarBuscar(paxFiltrados);
}

function seleccionarPax(id){
    $.ajax({
        url: plugin_ruta+'src/controllers/pasajeroController.php',
        type: 'GET',
        data: 'obtener='+id,
        success: (res)=>{
            pax = eval(res)[0];
            tel = eval(res)[1];
            cor = eval(res)[2];
            doc = eval(res)[3];
            dir = eval(res)[4];
            if(pax.foto == null || pax.foto == undefined)
                pax.foto = plugin_ruta+"src/imagenes/logo.png";
            // console.log(pax);
            $("#pax_lista").effect('drop', '', 500, ()=>{
                $("#pax_lista").hide();
                $("#pax_detalles").show();
                $("#ver_buscar").show();
                $("#agregar_pax").hide();
            });
            $("#pax_foto").attr('src', pax.foto);
            $("#pax_name").val(pax.nombres);
            $("#pax_apellidos").val(pax.apellidos);
            $("#pax_nacimiento").val(pax.nacimiento);
            $("#pax_nacionalidad").val(pax.nacionalidad);
            $("#pax_notas").val(pax.notas);
            $("#pax_fuente").val(pax.fuente);
            $("#pax_telefonos").html('<div class="col-12"><h4>Teléfonos:<button class="float-right" onclick="nuevoTel()">Nuevo Teléfono</button></h4></div>');
            for(i=0;i<tel.length;i++){
                $("#pax_telefonos").append('<div class="col-md-4 col-xs-12" id="telefono_'+tel[i].id+'"><button class="btn btn-lnk" id="'+tel[i].id+'" ondblclick="editarTel('+tel[i].id+')" href="tel:'+tel[i].telefono+'"><i class="fa fa-phone"></i> '+tel[i].telefono+'</button><button class="btn btn-danger" onclick="borrarTel('+tel[i].id+')"><i class="fa fa-trash"></i></button></div>')
            }
            $("#pax_correos").html('<div class="col-12"><h4>Correos:<button class="float-right" onclick="nuevoCor()">Nuevo Correo</button></h4></div>');
            for(i=0;i<cor.length;i++){
                $("#pax_correos").append('<div class="col-md-6 col-xs-12" id="correo_'+cor[i].id+'"><button class="btn btn-lnk" id="'+cor[i].id+'" ondblclick="editarCor('+cor[i].id+')"><i class="fa fa-envelope"></i> '+cor[i].correo+'</button><button class="btn btn-danger" onclick="borrarCor('+cor[i].id+')"><i class="fa fa-trash"></i></button></div>')
            }
            $("#pax_direcciones").html('<div class="col-12"><h4>Direcciones:</h4></div>');
            for(i=0;i<dir.length;i++){
                $("#pax_direcciones").append('<div class="col-md-6 col-xs-12"><strong><i class="fa fa-home"></i> Dirección '+eval(i+1)+'</strong><input type="text" id="'+dir[i].nombre+'_'+dir[i].id+'" value="'+dir[i].nombre+'"><input type="text" id="'+dir[i].distrito+'_'+dir[i].id+'" value="'+dir[i].distrito+'"><input type="text" id="'+dir[i].ciudad+'_'+dir[i].id+'" value="'+dir[i].ciudad+'"><input type="text" id="'+dir[i].pais+'_'+dir[i].id+'" value="'+dir[i].pais+'"></div>')
            }
            // $("input").prop("disabled", true);
            $("#buscar_pax").prop("disabled", false);
            $("#historial_pax").show();
        }
    })
}

function agregarPax(){
    var data = $("#form_pasajero").serialize();
    if($("input[name='nombre']").val() && $("input[name='apellido']").val()){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'insertar=true&'+data,
            success: (res)=>{
                console.log(res);
                $("#form_pasajeros_dialog").effect('drop', '', 500, ()=>{
                    $("#form_pasajeros_dialog").hide();
                    $("#pax_lista").show();
                    $("#ver_buscar").hide();
                    $("#agregar_pax").hide();
                });
                listarPax();
            }
        });
    }
}

function agregarPost(){
    var contenido = $("#pax_detalles").html();
    var titulo = pax.nombres+' '+pax.apellidos;
    $.ajax({
        url: plugin_ruta+'src/controllers/pasajeroController.php',
        type: 'POST',
        data: 'addPost=true&contenido='+contenido+'&titulo='+titulo,
        success: (res)=>{alert(res)}
    })
}

function verHistorial(){
    if($("#pax_detalles")[0].hidden==false){
        $("#pax_detalles").effect('drop', '', 500, ()=>{
            $("#pax_detalles").hide();
            $("#pax_lista").hide();
            $("#pax_historial").show();
            $("#pax_detalles")[0].hidden = true;
            $("#ver_buscar").hide();
        });
        $("#sol_name").val(pax.nombres);
        $("#sol_apellidos").val(pax.apellidos);
        $("#sol_nacimiento").val(pax.nacimiento);
        $("#sol_nacionalidad").val(pax.nacionalidad);
        $("#sol_notas").val(pax.notas);
        $("#sol_fuente").val(pax.fuente);
        $.ajax({
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            type: 'POST',
            data: 'id='+pax.id+'&solicitud='+true,
            success: (res)=>{
                sol = eval(res);
                console.log(sol);
                html='<table class="table table-hover"><thead><tr><th>ID</th><th>ESTADO</th><th>DESTINO</th><th>SERVICIOS</th><th>DESCRIPCION</th></tr><tbody>';
                for(i=0;i<sol.length;i++){
                    html+='<tr><td>'+sol[i].id+'</td><td>'+sol[i].estado+'</td><td>'+sol[i].destino+'</td><td>'+sol[i].servicios+'</td><td>'+sol[i].descripcion+'</td></tr>';
                }
                html+='</tbody></table>';
                $("#pax_solicitudes").html(html);
            }
        })
    }
    else{
        $("#pax_historial").effect('drop', '', 500,()=>{
            $("#pax_historial").hide()
            $("#ver_buscar").show();
            $("#pax_detalles").show();
            $("#pax_lista").hide();
            $("#pax_detalles")[0].hidden = false;
        });
    }
}
function editarPasajero(){
    $("#editar_pasajero_dialog").dialog('open');
    $("#editar_pasajero").load(plugin_ruta+'src/views/forms/pasajero-nuevo.php',()=>{
        $("input[name='nombre']").val(pax.nombres);
        $("input[name='apellido']").val(pax.apellidos);
        $("input[name='nacimiento']").val(pax.nacimiento);
        $("input[name='nacionalidad']").val(pax.nacionalidad);
        $("input[name='fuente']").val(pax.fuente);
        $("#DetallesAdd").click();
        $("#DetallesAdd").remove();
        $("#telefono").remove();
        $("#correo").remove();
        $("#direccion").remove();
        $("#identificacion").remove();
        $("textarea[name='observacion']").val(pax.notas);
        console.log($("textarea[name='observacion']").val());
    });
}
function editarFoto(){
    $("#editar_foto_dialog").dialog('open');
    $("#editar_foto").html('<input type="file" name="fileToUpload" id="fileToUpload"><input type="hidden" value="Upload Image" name="submit">')
}

function actualizarPax(){
    var data = $("#detallesCargados").serialize();
    // var foto = $('#foto')[0].files[0];
    // data.append('file',foto);
    console.log(data);
    if($("input[name='nombre']").val() && $("input[name='apellido']").val()){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'actualizar=true&paxId='+pax.id+'&'+data,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
                // $("#editar_pasajero_dialog").dialog( "close" );
            }
        });
    }
}

function actualizarFoto(e){
    var foto = e.currentTarget.files[0];
    var data=new FormData(document.getElementById("detallesCargados"));
    data.append('fileToUpload', $("#foto")[0].files[0]);
    data.append('actualizarFoto', true);
    data.append('paxId', pax.id);
    console.log(data);
    if(foto.size>0){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
            }
        });
    }
}

function editarTel(id){
    var telefono = tel.filter(t=>t.id == id);
    $("#telefono_"+id).html('<input type="text" name="telefono" value="'+telefono[0].telefono+'" id="telefono"><input type="button" onclick="actualizarTel('+id+',telefono.value)" value="Actualizar">');
}

function actualizarTel(id, telefono){
    // console.log(id,telefono);
    $("#telefono_"+id).remove()
    if(telefono){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'actualizarTel=true&telId='+id+'&telefono='+telefono,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
            }
        });
    }
}

function editarCor(id){
    var correo = cor.filter(c=>c.id == id);
    $("#correo_"+id).html('<input type="text" name="correo" value="'+correo[0].correo+'" id="correo"><input type="button" onclick="actualizarCor('+id+',correo.value)" value="Actualizar">');
}

function actualizarCor(id, correo){
    // console.log(id,correo);
    if(correo){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'actualizarCor=true&corId='+id+'&correo='+correo,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
            }
        });
    }
}

function nuevoTel(){
    $("#pax_telefonos").append('<div class="col-4" id="nuevoTelefono"><input type="text" name="telefono" value="" id="telefono"><input type="button" onclick="agregarTel(telefono.value)" value="Agregar"></div>');
    $("#telefono").focus();
}

function agregarTel(telefono){
    if(telefono){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'agregarTel=true&paxId='+pax.id+'&telefono='+telefono,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
            }
        });
    }
}

function nuevoCor(){
    $("#pax_correos").append('<div class="col-4" id="nuevoCorreo"><input type="text" name="correo" value="" id="correo"><input type="button" onclick="agregarCor(correo.value)" value="Agregar"></div>');
    $("#correo").focus();
}

function agregarCor(correo){
    if(correo){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'agregarCor=true&paxId='+pax.id+'&correo='+correo,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
            }
        });
    }
}

function borrarTel(id){
    if(confirm("¿Realmente deseas borrar este teléfono?")){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'borrarTel=true&telId='+id,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
            }
        });
    }
}

function borrarCor(id){
    if(confirm("¿Realmente deseas borrar este correo?")){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'borrarCor=true&corId='+id,
            success: (res)=>{
                listarPax();
                seleccionarPax(pax.id);
            }
        });
    }
}

</script>
<style>
</style>