<?php include RUTA."/src/views/common/head.php" ?>

<div class="wrap">
    <div class="container-fluid">
        <div class="buttons">
            <button class="btn btn-link" id="agregar_pax"><i class="fa fa-plus"></i> Nuevo Pasajero</button>
            <button class="btn btn-link" id="historial_pax"><i class="fa fa-plus"></i> Ver Historial</button>
        </div>
        <div id="form_pasajero_dialog">
            <form id="form_pasajero"></form>
        </div>

        <div class="row">
            <div class="col-md-4" id="pax_lista" style="max-height:550px">
                <div class="md-form mt-0" id="pax_search">
                    <input class="form-control" type="text" id="buscar_pax" placeholder="Filtrar por Nombre o Apellido del pasajero" aria-label="Filtrar por Nombre o Apellido del pasajero">
                </div>
                <div>
                    <div class="white z-depth-1 px-3 pt-3 pb-0 overflow-auto h-auto" style="padding:1%;max-height:500px">
                        <ul class="list-unstyled friend-list" id="pax_datos">
                        <li class="active grey lighten-3 p-2 d-flex justify-content-between">
                            <img src="../wp-content/plugins/pdm-admin/src/imagenes/dummy-pax.jpg" height="50" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1">
                            <div class="text-small text-left">
                                <strong>John Doe</strong>
                                <p class="last-message text-muted"><i class="fa fa-phone"></i> telefono <i class="fa fa-envelope"></i> correo</p>
                            </div>
                            <div class="">
                                <i class="fa fa-angle-right align-middle"></i>
                            </div>      
                        </li>          
                        </ul>
                    </div>                
                </div>
            </div>
            <div class="col-md-8" id="pax_detalles">
                <div class="form-style-8">
                    <h2 class="">Detalles del Pasajero
                        <button class="btn btn-info float-right">
                        <i class="fa fa-edit"></i> Editar</button>
                    </h2>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="../wp-content/plugins/pdm-admin/src/imagenes/dummy-pax.jpg" alt="avatar" class="avatar rounded-circle d-flex mr-2 z-depth-1 h-auto w-auto mx-auto" style="max-height:100px;max-width:100px">
                        </div>
                        <div class="col-md-4">
                            <label>Nombres:</label>
                            <input type="text" id="pax_name">
                        </div>
                        <div class="col-md-4">
                            <label>Apellidos:</label>
                            <input type="text" class="" id="pax_apellidos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Nacimiento:</label>
                            <input type="date" id="pax_nacimiento">
                        </div>
                        <div class="col-md-4">
                            <label>Nacionalidad:</label>
                            <input type="text" id="pax_nacionalidad">
                        </div>
                        <div class="col-md-4">
                            <label>Notas:</label>
                            <input type="text" id="pax_notas">
                        </div>
                        <div class="col-md-6">
                        <label>Fuente de Marketing</label>
                        <input type="text" id="pax_fuente">
                    </div>
                    </div>
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
                    <div class="col-4">
                        <img src="../wp-content/plugins/pdm-admin/src/imagenes/dummy-pax.jpg" alt="avatar" class="avatar rounded-circle d-flex align-self-center mr-2 z-depth-1 h-auto w-auto" style="max-height:100px;max-width:100px">
                    </div>
                    <div class="col-4">
                        <label>Nombres:</label>
                        <input type="text" id="sol_name">
                    </div>
                    <div class="col-4">
                        <label>Apellidos:</label>
                        <input type="text" class="" id="sol_apellidos">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Nacimiento:</label>
                        <input type="date" id="sol_nacimiento">
                    </div>
                    <div class="col-md-4">
                        <label>Nacionalidad:</label>
                        <input type="text" id="sol_nacionalidad">
                    </div>
                    <div class="col-md-4">
                        <label>Notas:</label>
                        <input type="text" id="sol_notas">
                    </div>
                    <div class="col-md-6">
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
    $("#pax_detalles").hide();
    $("#pax_historial").hide();
    $("#historial_pax").hide();
    $("#form_pasajero_dialog").dialog({
        autoOpen:false,
        width:600,
        height:500,
        modal:true,
        title:"Nuevo Pasajero",
        buttons: {"Agregar Pasajero": agregarPax,
            cancel: ()=>{$("#form_pasajero_dialog").dialog( "close" );}
        }
    });
    $.ajax({
        url: plugin_ruta+'src/controllers/pasajeroController.php',
        type: 'POST',
        data: 'listar=true&estado="PASAJERO"',
        success: (res)=>{listarPax(res)}
    });

    $("#buscar_pax").keyup(()=>{
        $.ajax({
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            type:"POST",
            data:'buscar='+$("#buscar_pax").val(),
            success: (res)=>{listarPax(res)}
        });               
    });

    $("#agregar_pax").click(()=>{
        $("#form_pasajero_dialog").dialog('open');
        $("#form_pasajero").load(plugin_ruta+'src/views/forms/pasajero-nuevo.php');
    })
    $("#historial_pax").click((e)=>{
        fa = e.currentTarget.children[0].className;
        e.currentTarget.children[0].className = (fa == "fa fa-plus") ? "fa fa-minus" : "fa fa-plus";
        verHistorial();
        
    })
})

function listarPax(r){
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
                pax.foto = plugin_ruta+"src/imagenes/dummy-pax.jpg";
            console.log(pax);
            $("#pax_detalles").show();
            $("#pax_name").val(pax.nombres);
            $("#pax_apellidos").val(pax.apellidos);
            $("#pax_nacimiento").val(pax.nacimiento);
            $("#pax_nacionalidad").val(pax.nacionalidad);
            $("#pax_notas").val(pax.notas);
            $("#pax_fuente").val(pax.fuente);
            $("#pax_telefonos").html('<div class="col-12"><h4>Teléfonos:</h4></div>');
            for(i=0;i<tel.length;i++){
                $("#pax_telefonos").append('<div class="col-4"><button class="btn btn-lnk" id="'+tel[i].id+'"><i class="fa fa-phone"></i> '+tel[i].telefono+'</button></div>')
            }
            $("#pax_correos").html('<div class="col-12"><h4>Correos:</h4></div>');
            for(i=0;i<cor.length;i++){
                $("#pax_correos").append('<div class="col-6"><button class="btn btn-lnk" id="'+cor[i].id+'"><i class="fa fa-envelope"></i> '+cor[i].correo+'</button></div>')
            }
            $("#pax_direcciones").html('<div class="col-12"><h4>Direcciones:</h4></div>');
            for(i=0;i<dir.length;i++){
                $("#pax_direcciones").append('<div class="col-6"><strong><i class="fa fa-home"></i> Dirección '+eval(i+1)+'</strong><input type="text" id="'+dir[i].nombre+'_'+dir[i].id+'" value="'+dir[i].nombre+'"><input type="text" id="'+dir[i].distrito+'_'+dir[i].id+'" value="'+dir[i].distrito+'"><input type="text" id="'+dir[i].ciudad+'_'+dir[i].id+'" value="'+dir[i].ciudad+'"><input type="text" id="'+dir[i].pais+'_'+dir[i].id+'" value="'+dir[i].pais+'"></div>')
            }
            $("input").prop("disabled", true);
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
                $("#form_pasajero_dialog").dialog( "close" );
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
            $("#pax_detalles").show();
            $("#pax_lista").show();
            $("#pax_detalles")[0].hidden = false;
        });
    }
}
</script>
<style>
</style>


