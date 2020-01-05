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
            <button class="btn btn-link" id="add_det"><i class="fa fa-plus" id="add_det_btn"></i> Agregar Detalles</button>
            <button class="btn btn-link" id="add_sol"><i class="fa fa-plus" id="add_sol_btn"></i> Cargar Solicitud</button>
            <button class="btn btn-link" id="add_iti"><i class="fa fa-plus" id="add_iti_btn"></i> Agretar Itinerario</button>
            <form id="form_pasajero"></form>
            <form id="form_solicitud"></form>
            <div id="dialogo"></div>
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
                <div id="pax_datos" class="card">
                    <div class="card-header">
                        <h5>Pasajero</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Nombre: <span id="pax_nom"></span> <span id="pax_app"></span></h5>
                        <p>Teléfono: <span id="pax_tel"></span></p><p>Correo: <span id="pax_cor"></span></p>
                    </div>
                </div>

                <div class="card" id="det_datos">
                    <div class="card-header">
                        <h5>Detalles de la Solicitud</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Destino: <span id="det_des"></span></h5>
                        <p>Origen: <span id="det_ori"></span></p>
                        <p>Pasajeros: ADT(<span id="det_adt">0</span>) CHD(<span id="det_chd">0</span>) INF(<span id="det_inf">0</span>)</p>
                        <p>Fechas: <span id="det_fec_tip"></span>, Salida: <span id="det_fec_ini"></span>, Retorno:<span id="det_fec_ret"></span></p>
                        <p>Servicios a Incluir: <span id="det_ser"></span></p>
                        <p>Observaciones: <span id="det_obs"></span></p>
                    </div>
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
<script>
var new_pax = false;
var old_pax = false;
var new_det = false;
var new_iti = false;
var add_sol = false;
var valores=[];
var solicitud = {};
var pasajero="";
var html, sol;
$("#pax_datos").hide();
$("#det_datos").hide();
$("#solicitud_buscar").hide();
$("#dialogo").dialog({
    autoOpen:false,
    width:600,
    height:500,
    modal:true,
})
$("#add_pasajero").click(()=>{
    if(new_pax){
        $("#form_pasajero").html("");
        $("#add_pasajero_btn").removeClass("fa-minus");
        $("#add_pasajero_btn").addClass("fa-plus");
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
                            $("#cotizacion_view").html('<div class="alert alert-success"><h5>Pasajero Agregado</h5><p>Ahora debes           eccionarlo</p></div>');
                            $("#form_pasajero").html("");
                            $("#add_pasajero").hide();
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
$("#add_iti").click(()=>agregarItinerario())

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
    old_pax = !old_pax;
    pasajero = res.id;
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
function agregarItinerario(){
    $("#dialogo").dialog('open');
    $("#dialogo").load(plugin_ruta+'src/views/forms/itinerario.php');
}
</script>

