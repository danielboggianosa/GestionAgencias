<?php include RUTA."src/views/common/head.php" ?>
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
            <button class="btn btn-link" id="add_pax"><i class="fa fa-plus" id="add_iti_btn"></i> Agretar Itinerario</button>
            <form id="form_pasajero"></form>
            <div id="cotizacion_detalles"></div>
            <div id="cotizacion_view"></div>
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
var new_iti = false;
var valores=[];
var html;
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
                            // console.log(res);  
                            $("#form_pasajero").html("");
                            $("#add_pasajero_btn").removeClass("fa-minus");
                            $("#add_pasajero_btn").addClass("fa-plus");
                            new_pax = !new_pax;
                            $("#cotizacion_view").append('<div id="datos_pax" class="card">');
                            $("#datos_pax").append('<div class="card-header"><h5>Pasajero</h5></div>');
                            $("#datos_pax").append('<div class="card-body"><p>Nombre: '+res.nombres+' '+res.apelldios+'</p><p>Teléfono: '+res.telefono+'</p><p>Correo: '+res.correo+'</p></div>');
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
                        html+='<tr onclick="seleccionar('+i+')"><th>'+valores[i].id+'</th><td>'+valores[i].nombres+'</td><td>'+valores[i].apellidos+'</td><td>'+valores[i].telefono+'</td><td>'+valores[i].correo+'</td></tr>';
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
    alert("deatlles");
    $("#cotizacion_detalles").load(plugin_ruta+"src/views/forms/solicitud-nueva.php");
})

function seleccionar(index){
    var res=valores[index];
    $("#cotizacion_view").append('<div id="datos_pax" class="card">');
    $("#datos_pax").append('<div class="card-header"><h5>Pasajero</h5></div>');
    $("#datos_pax").append('<div class="card-body"><h5>Nombre: '+res.nombres+' '+res.apellidos+'</h5><p>Teléfono: '+res.telefono+'</p><p>Correo: '+res.correo+'</p></div>');
    $("#form_pasajero").html("");
    $("#add_pax").hide();
    $("#add_pasajero").hide();
    old_pax = !old_pax;
}

</script>

