<?php include RUTA."src/views/common/head.php"?>
<div class="wrap">
    <div id="tabs">
        <ul>
            <li class="nav-item"><a href="#nuevo">Nueva</a></li>
            <li class="nav-item"><a href="#progreso">En Progreso</a></li>
            <li class="nav-item"><a href="#antiguo">Antiguas</a></li>
        </ul>
        <div id="nuevo">
            <h3>Agregar Nueva Cotización</h3>
            <button class="btn btn-link" id="add_pasajero"><i class="fa fa-plus" id="add_pasajero_btn"></i> Nuevo Pasajero</button>
            <button class="btn btn-link" id="add_pax"><i class="fa fa-plus" id="add_pax_btn"></i> Pasajero Existente</button>
            <button class="btn btn-link" id="add_det" data-toggle="modal" data-target="#solicitudModal"><i class="fa fa-plus" id="add_det_btn"></i> Agregar Detalles</button>
            <button class="btn btn-link" id="add_sol" data-toggle="modal" data-target="#solicitudModal"><i class="fa fa-plus" id="add_sol_btn"></i> Cargar Solicitud</button>
    
            <form id="form_pasajero"></form>

            
            <div id="solicitud_buscar">
            <div class="card-header"><h4>Buscar Solicitud</h4></div>
                <div class="card-body">
                    <!-- <input type="search" class="form-control" id="buscar_sol" placeholder="Escribir Nombre o Apellido del pasajero"> -->
                    <!-- <div id="sol"></div> -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pasajero</th>
                                <th>Destino</th>
                                <th>Fechas</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody id="sol_datos"></tbody>
                    </table>
                </div>
            </div>
            <div id="cotizacion_view">
                <div id="pax_datos" class="form-style-8">
                    <h2>Pasajero</h2>
                    <h4><span id="pax_nom"></span> <span id="pax_app"></span></h4>
                    <p class="d-flex justify-content-between">
                    <button class="btn">
                        <i class="fa fa-phone"></i> <span id="pax_tel"></span>
                    </button>
                    <button class="btn">
                        <i class="fa fa-envelope"></i> <span id="pax_cor"></span></p>
                    </button>
                </div>

                <div id="det_datos" class="form-style-8">
                    <h2>Detalles de la Solicitud</h2>
                    <h4><span id="det_des"></span></h4>
                    <p>Origen: <span id="det_ori"></span></p>
                    <p>Pasajeros: ADT(<span id="det_adt">0</span>) CHD(<span id="det_chd">0</span>) INF(<span id="det_inf">0</span>)</p>
                    <p>Fechas: <span id="det_fec_tip"></span>, Salida: <span id="det_fec_ini"></span>, Retorno:<span id="det_fec_ret"></span></p>
                    <p>Servicios a Incluir: <span id="det_ser"></span></p>
                    <p>Observaciones: <span id="det_obs"></span></p>
                </div>

                <button class="btn btn-link" id="add_ser" data-toggle="modal" data-target="#servicioModal"><i class="fa fa-plus" id="add_ser_btn"></i> Agregar Servicio</button>
                <div id="det_itinerario" class="form-style-8">
                    <h2>Itinerario</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>DÍA</th>
                                <th>INICIO</th>
                                <th>FINAL</th>
                                <th>TÍTULO</th>
                                <th>DESCRIPCION</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="servicios">
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Costo:</th>
                                <th><span id="costoServicio"></span></th>
                                <th>Precio:</th>
                                <th><span id="precioServicio"></span></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div id="progreso">
            <h3>Cotizaciones En Progreso</h3>
        </div>
        <div id="antiguo">
            <h3>Cotizaciones Anteriores</h3>
        </div>
    </div>
</div>
<div class="modal fade" id="solicitudModal" tabindex="-1" role="dialog" aria-labelledby="solicitudModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="solicitudModalLabel">Detalles de la Solicitud</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">            
            <form id="form_solicitud"></form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" href="login.html">Agregar</button>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="servicioModal" tabindex="-1" role="dialog" aria-labelledby="servicioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="servicioModalLabel">Detalles de la Servicio</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">            
            <div id="dialogo"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" href="login.html">Agregar</button>
        </div>
      </div>
    </div>
  </div>
<script>
var new_pax = false;
var old_pax = false;
var new_det = false;
var new_iti = false;
var add_sol = false;
var valores=[];
var solicitud = {};
var pasajero="";
var html, sol, tituloDialogo, servicios=[], serIndex = 0, serModIndex, serTotal=0, serCosto=0;
$("#pax_datos").hide();
$("#det_datos").hide();
$("#det_itinerario").hide();
$("#add_det").hide();
$("#add_sol").hide();
$("#add_ser").hide();
$("#solicitud_buscar").hide();
$("#add_pasajero").click(()=>{
    if(new_pax){
        $("#form_pasajero").html("");
        $("#form_pasajero")[0].className = "";
        $("#add_pasajero_btn")[0].className = "fa fa-plus";
        new_pax = !new_pax;
    }
    else{        
        $("#form_pasajero").load(plugin_ruta+"src/views/forms/pasajero-nuevo.php", ()=>{
            $("#form_pasajero").append('<button type="submit" class="btn btn-success" id="save_pax">Guardar Datos</button>');
            $("#identificacion").hide();
            $("#nacimiento").hide();
            $("#DetallesAdd").hide();
            $("#save_pax").click(()=>{
                var data = $("#form_pasajero").serialize();
                if($("input[name='nombre']").val() && $("input[name='apellido']").val()){
                    $.ajax({
                        type:"POST",
                        url: plugin_ruta+'src/controllers/pasajeroController.php',
                        data: 'insertar=true&'+data,
                        success: (res)=>{
                            $("#cotizacion_view").html('<div class="alert alert-success"><h5>Pasajero Agregado</h5><p>Ahora debes seleccionarlo</p></div>');
                            $("#form_pasajero").html("");
                            $("#add_pasajero").hide();
                            $("#add_det").show();
                            $("#add_sol").show();
                            new_pax = !new_pax;
                            pasajero = res.id;               
                        }
                    });
                }
            })
        });
        $("#add_pasajero_btn").removeClass("fa-plus");
        $("#add_pasajero_btn").addClass("fa-minus");
        new_pax = !new_pax;
        $("#form_pasajero").submit((e)=>e.preventDefault());        
    }
});
$("#add_pax").click(()=>{
    if(old_pax){
        $("#form_pasajero").html("");
        $("#add_pax_btn").removeClass("fa-minus");
        $("#add_pax_btn").addClass("fa-plus");
        old_pax = !old_pax;
    }
    else{
        $("#form_pasajero").load(plugin_ruta+"src/views/forms/pasajero-existente.php",()=>{
            $("#form_pasajero").addClass('form-style-8');
            $("#form_pasajero").append('<div id="res_pasajero"></div>');
            $("#buscar_pax").keyup(()=>{
                $.ajax({
                    url: plugin_ruta+'src/controllers/pasajeroController.php',
                    type:"POST",
                    data:'buscar='+$("#buscar_pax").val()
                }).done((res) => {
                    valores = eval(res);
                    console.log(valores);
                    html='<table class="table table-hover"><thead><tr><th>ID</th><th>Nombre</th><th>Apellildos</th><th>Teléfono</th><th>Correo</th></tr></thead><tbody style="cursor:pointer">';
                    for(i=0;i<valores.length;i++){
                        html+='<tr onclick="selpax('+i+')"><th>'+valores[i].id+'</th><td>'+valores[i].nombres+'</td><td>'+valores[i].apellidos+'</td><td>'+valores[i].telefono+'</td><td>'+valores[i].correo+'</td></tr>';
                    }
                    html+='</tbody></table>';
                    $("#res_pasajero").html(html);
                });                
            });            
        });
        $("#add_pax_btn").removeClass("fa-plus");
        $("#add_pax_btn").addClass("fa-minus");
        old_pax = !old_pax;
        
    }
})
$("#add_det").click(()=>{
    if(new_det){
        $("#form_solicitud").html("");
        $("#add_det_btn").removeClass("fa-minus");
        $("#add_det_btn").addClass("fa-plus");
        new_det = !new_det;
    }
    else{
        if(pasajero == ""){
            alert("Primero debes agregar un pasajero");
        }
        else{
            $("#form_solicitud").load(plugin_ruta+"src/views/forms/solicitud-nueva.php",()=>{
                $("#registrar_solicitud").click((e)=>{
                    e.preventDefault();
                    var data = $("#form_solicitud").serialize();
                    $.ajax({
                        url:plugin_ruta+"src/controllers/solicitudController.php",
                        type:'POST',
                        data: 'pasajero='+pasajero+'&insertar=true&'+data,
                        success: (res)=>{
                            console.log("Respuesta",res);
                            solicitud = res;
                            console.log("Solicitud",solicitud);
                            $("#det_datos").show();
                            $("#det_des").html(solicitud.pdm_solicitud_destino);
                            $("#det_ori").html(solicitud.pdm_solicitud_origen);
                            $("#det_fec_tip").html(solicitud.pdm_solicitud_fecha_tipo);
                            $("#form_solicitud").html("");
                            $("#add_det_btn").removeClass("fa-minus");
                            $("#add_det_btn").addClass("fa-plus");
                            new_det = !new_det;                        
                        }
                    })
                });
            });
            $("#add_det_btn").removeClass("fa-plus");
            $("#add_det_btn").addClass("fa-minus");
            new_det = !new_det;
            $("#form_solicitud").submit((e)=>e.preventDefault());
        }
    }
});
$("#add_sol").click(()=>{
    if(add_sol){
        $("#solicitud_buscar").hide();
        $("#add_sol_btn").removeClass("fa-minus");
        $("#add_sol_btn").addClass("fa-plus");
        add_sol = !add_sol;
    }
    else{
        $("#solicitud_busar").show()
        $.ajax({
            url: plugin_ruta+'src/controllers/solicitudController.php',
            type: 'POST',
            data: "solicitud="+true+"&id="+pasajero,
            success: (res)=>showSol(res),
        })
    }
});
$("#add_ser").click(()=>{
    // $("#dialogo").dialog({
    //     width:600,
    //     height:500,
    //     modal:true,
    //     title: 'Nuevo Servicio',
    //     buttons: {
    //                 cancel: ()=>$("#dialogo").dialog('close'),
    //                 'Agregar Servicio': agregarServicio,
    //             },
    // });
    $("#dialogo").load(plugin_ruta+'src/views/forms/servicio.php');
})

function selpax(index){
    var res=valores[index];
    $("#pax_datos").show();
    $("#pax_nom").html(res.nombres);
    $("#pax_app").html(res.apellidos);
    $("#pax_tel").html(res.telefono);
    $("#pax_cor").html(res.correo);
    $("#form_pasajero").html("");
    $("#add_pax").hide();
    $("#add_pasajero").hide();
    $("#add_det").show();
    $("#add_sol").show();
    old_pax = !old_pax;
    pasajero = res.id;
    $("#form_pasajero").removeClass('form-style-8');
}
function showSol(res){
    var selector = "#form_solicitud";
    sol = eval(res);
    console.log(sol);
    html='<table class="table table-hover"><thead><tr><th>ID</th><th>ESTADO</th><th>DESTINO</th><th>SERVICIOS</th><th>DESCRIPCION</th></tr><tbody>';
    for(i=0;i<sol.length;i++){
        html+='<tr onclick="seleccionarSolicitud('+sol[i].id+')"><td>'+sol[i].id+'</td><td>'+sol[i].estado+'</td><td>'+sol[i].destino+'</td><td>'+sol[i].servicios+'</td><td>'+sol[i].descripcion+'</td></tr>';
    }
    html+='</tbody></table>';
    $(selector).html(html);
}
function seleccionarSolicitud(index){
    s = sol[index]; 
    $("#form_solicitud").html('');
    $("#det_datos").show();
    $("#add_ser").show();
    $("#add_det").hide();
    $("#add_sol").hide();
    $("#det_des").html(s.destino);
    $("#det_ori").html(s.origen);
    $("#det_adt").html(s.adultos);
    $("#det_chd").html(s.ninos);
    $("#det_inf").html(s.bebes);
    $("#det_fec_tip").html(s.fechaTipo);
    $("#det_fec_sal").html(s.salida);
    $("#det_fec_ret").html(s.retorno);
    $("#det_ser").html(s.servicios);
    $("#det_obs").html(s.descripcion);
}
function agregarServicio(){
    var servicio = $("#nuevoServicio").serializeArray();
    var n={};
    for(i=0;i<servicio.length;i++){
        n[servicio[i].name] = servicio[i].value;
    }
    servicios.push(n)
    index = servicios.indexOf(n);
    servicios[index]['id'] = serIndex;
    console.log(servicios);
    $("#servicios").append('<tr id="servicio_'+serIndex+'"><td>'+n.dia+'</td><td>'+n.hInicio+'</td><td>'+n.hFinal+'</td><td>'+n.servicio+'</td><td>'+n.descripcion+'</td><td><button class="btn btn-link" onclick="editarServicio('+serIndex+')"><i class="fa fa-eye"></i></button><button class="btn btn-link" onclick="borrarServicio('+serIndex+')"><i class="fa fa-trash"></i></button><button class="btn btn-link" onclick="editarServicio('+serIndex+')"><i class="fa fa-edit"></i></button></td></tr>');
    $("#det_itinerario").show();
    $("#dialogo").dialog('close');
    serIndex++;
    serTotal += n.precio*1;
    serCosto += n.costo*1;
    $("#precioServicio").html(serTotal+' '+n.moneda);
    $("#costoServicio").html(serCosto+' '+n.moneda);
}
function borrarServicio(index){
    for(i=0;i<servicios.length;i++){
        if(servicios[i].id == index){
            serTotal -= servicios[i].precio*1
            serCosto -= servicios[i].costo*1
            $("#precioServicio").html(serTotal);
            $("#costoServicio").html(serCosto);
            servicios.splice(i, 1);
            $("#servicio_"+index).remove();
        }
    }
    console.log(servicios);
}
function editarServicio(index){
    for(i=0;i<servicios.length;i++){
        if(servicios[i].id == index){
            n = servicios[i];
            serCosto -= n.costo*1;
            serTotal -= n.precio*1;
            serModIndex = i;
            $("#dialogo").dialog({
                width:600,
                height:500,
                modal:true,
                title: 'Nuevo Servicio',
                buttons: {
                            cancel: ()=>{
                                        serCosto += n.costo*1;
                                        serTotal += n.precio*1;
                                        $("#dialogo").dialog('close')
                                    },
                            'Editar Servicio': modificarServicio,
                        },
            });
            $("#dialogo").load(plugin_ruta+'src/views/forms/servicio.php', ()=>{
                $("input[name='dia']").val(n.dia);
                $("input[name='hInicio']").val(n.hInicio);
                $("input[name='hFinal']").val(n.hFinal);
                $("input[name='servicio']").val(n.servicio);
                $("input[name='foto']").val(n.foto);
                $("textarea[name='descripcion']").val(n.descripcion);
                $("input[name='operador']").val(n.operador);
                $("select[name='moneda']").val(n.moneda);
                $("input[name='costo']").val(n.costo);
                $("input[name='precio']").val(n.precio);
            });
        }
    }
}
function modificarServicio(){
    i = serModIndex;
    servicios[i].dia = $("input[name='dia']").val();
    servicios[i].hInicio = $("input[name='hInicio']").val();
    servicios[i].hFinal = $("input[name='hFinal']").val();
    servicios[i].servicio = $("input[name='servicio']").val();
    servicios[i].foto = $("input[name='foto']").val();
    servicios[i].descripcion = $("textarea[name='descripcion']").val();
    servicios[i].operador = $("input[name='operador']").val();
    servicios[i].moneda = $("select[name='moneda']").val();
    servicios[i].costo = $("input[name='costo']").val();
    servicios[i].precio = $("input[name='precio']").val();
    n = servicios[i];
    $("#servicio_"+servicios[i].id).html('<td>'+n.dia+'</td><td>'+n.hInicio+'</td><td>'+n.hFinal+'</td><td>'+n.servicio+'</td><td>'+n.descripcion+'</td><td><button class="btn btn-link" onclick="editarServicio('+servicios[i].id+')"><i class="fa fa-eye"></i></button><button class="btn btn-link" onclick="borrarServicio('+servicios[i].id+')"><i class="fa fa-trash"></i></button><button class="btn btn-link" onclick="editarServicio('+servicios[i].id+')"><i class="fa fa-edit"></i></button></td>')
    console.log(servicios);
    serCosto += n.costo*1;
    serTotal += n.precio*1;    
    $("#precioServicio").html(serTotal);
    $("#costoServicio").html(serCosto);
    $("#dialogo").dialog('close');
}
</script>




