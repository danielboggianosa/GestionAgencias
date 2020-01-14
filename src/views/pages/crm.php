<?php include RUTA."src/views/common/head.php"?>

<div class="wrap">
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">CRM</h1>
<p class="mb-4">Base de datos de contactos con detalles para realizar seguimiento.</p>
<div class="buttons">
  <a class="btn btn-link" href="#" data-toggle="modal" data-target="#nuevoContacto" id="nuevoContactoBtn">
    <i class="fa fa-plus"></i>
    Nuevo Contacto
  </a>
</div>


<!-- DataTales Example -->
<div class="shadow mb-4">
  <div class="py-3">
    <h6 class="m-0 font-weight-bold text-primary">Contactos</h6>
  </div>
  <div class="">
    <div class="p-2">
      <div class="d-flex float-left">
        <label for="items">Mostrar:&nbsp;</label>
        <select name="items" id="item" class="form-control">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        &nbsp;Elementos
      </div>
      <div class="d-flex float-right">
        <input type="search" name="buscar" id="buscar" placeholder="Filtrar" class="form-control">
      </div>
    </div>
    <br>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th></th>
            <th class="filtro" id="Tnombres">Nombres <i class="fa fa-angle-down"></i></th>
            <th class="filtro" id="Tapellidos">Apellidos <i class="fa fa-angle-down"></i></th>
            <th class="filtro" id="Tfuente">Fuente <i class="fa fa-angle-down"></i></th>
            <th class="filtro" id="Ttelefono">Telefono <i class="fa fa-angle-down"></i></th>
            <th class="filtro" id="Tinteraccion">Última Interacción <i class="fa fa-angle-up"></i></th>
            <th class="filtro" id="Tusuario">Usuario <i class="fa fa-angle-down"></i></th>
            <th class="filtro" id="Tnota">Comentario <i class="fa fa-angle-down"></i></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th></th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Fuente</th>
            <th>Telefono</th>
            <th>Última Interacción</th>
            <th>Usuario</th>
            <th>Nota</th>
          </tr>
        </tfoot>
        <tbody id="contactos">
          
        </tbody>
      </table>
      <div class="d-flex float-right">        
        <button class="btn btn-default" onclick="paginaAnterior()" >Anterior</button>
        <div id="paginasBtns"></div>
        <button class="btn btn-default" onclick="paginaSiguiente()">Siguiente</button>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- Modal Para Nuevo Contacto -->
<div class="modal fade" id="nuevoContacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Contacto</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"><form id="form_pasajero"><form></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal" id="closeModal">Cancel</button>
        <button class="btn btn-primary" type="button" onclick="agregarPax()" data-dismiss="modal">Registrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Para ver el  historial del contacto -->
<div class="modal fade" id="historialContacto" tabindex="-1" role="dialog" aria-labelledby="historialModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historialModalLabel">Interacciones con el Contacto</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="historialBody">        
        <div class="user">
          <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <label for="">Nombres:</label>
              <input type="text" class="form-control form-control-user" id="hsNombres">
            </div>
            <div class="col-sm-6">
              <label for="">Apellidos:</label>
              <input type="text" class="form-control form-control-user" id="hsApellidos">
            </div>
          </div>
          <div class="form-group">
            <label for="">Correo:</label>
            <input type="text" class="form-control form-control-user" id="hsCorreo">
          </div>
          <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <label for="">Telefono:</label>
              <input type="text" class="form-control form-control-user" id="hsTelefono">
            </div>
            <div class="col-sm-6">
              <label for="">Fuente:</label>
              <input type="text" class="form-control form-control-user" id="hsFuente">
            </div>
          </div>
          <hr>
          <h3>Historial</h3>
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Agregar un comentario:</div>
                  <div class="p mb-0 font-weight-bold text-gray-800"><textarea name="contenido" id="contenido" rows="3" class="form-control"></textarea><button class="btn btn-success float-right" type="button" id="agregarComentario">Agregar Comentario</button></div>
                </div>                
              </div>
            </div>
          </div>
          <div id="comentarios" class="row"></div>
        </div>                     
      </div>
      <!-- <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal" id="closeModal">Cancel</button>
        <button class="btn btn-primary" type="button" onclick="agregarPax()" data-dismiss="modal">Registrar</button>
      </div> -->
    </div>
  </div>
</div>

</div>

<style>
.filtro{
  cursor:pointer;
  white-space: nowrap;
}
</style>

<script>
$(document).ready(()=>{
  
  consultar();

  $(".filtro").click((e)=>{
    arrow = e.currentTarget.firstElementChild.classList[1];
    orden = (arrow.split('-')[2]=='down') ? "ASC" : "DESC";
    campo = e.currentTarget.id;
    campo = campo.split('T')[1];
    $.ajax({
      url: plugin_ruta+'src/controllers/crmController.php',
      type: 'POST',
      data: 'listar=true&orden='+orden+'&campo='+campo,
      success: (res)=>{listar(res)}
    });
    // $(".fa").removeClass('fa-angle-up');
    // $(".fa").addClass('fa-angle-down');
    e.currentTarget.firstElementChild.className = (arrow == "fa-angle-down") ? "fa fa-angle-up" : "fa fa-angle-down";
  });
  
  $("#item").change((e)=>{
    items = e.currentTarget.value 
    paginar(1, items);
  });

  $("#buscar").keyup(()=>{
      $.ajax({
          url: plugin_ruta+'src/controllers/crmController.php',
          type:"POST",
          data:'buscar='+$("#buscar").val(),
          success: (res)=>{listar(res)}
      });               
  });

  $("#nuevoContactoBtn").click(()=>{$("#form_pasajero").load(plugin_ruta+'/src/views/forms/pasajero-nuevo.php')});  

  $("#agregarComentario").click(()=>{
    $.ajax({
      url: plugin_ruta+'src/controllers/crmController.php',
      type: 'POST',
      data: 'contenido='+$("#contenido").val()+'&contactoId='+contactoId,
      success: ()=>{
        // console.log(res);
        ahora = new Date();
        $("#comentarios").prepend('<div class="col-12"><div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">'+$.timeago(ahora)+' por '+contactoUser+'</div><div class="p mb-0 font-weight-bold text-gray-800">'+$("#contenido").val()+'</div></div></div></div></div></div>');
        $("textarea").val('');
      }
    })
  })

});

var contactos, paginaActual = 1, paginas;
function listar(r){
    var res = eval(r);
    contactos = res;
    items = ($("#item").val()*1 > res.length) ? res.length : $("#item").val()*1;
    $("#contactos").html("");
    for(i=0;i<items;i++){
        var correo=(res[i].correo==null) ? "" : res[i].correo;
        var telefono=(res[i].telefono==null) ? "" : res[i].telefono;
        var fuente=(res[i].fuente==null) ? "" : res[i].fuente;
        $("#contactos").append('<tr><td><button class="btn btn-success" onclick="verHistorial('+i+')" title="Ver Historial" data-toggle="modal" data-target="#historialContacto"><i class="fa fa-plus"></i></button></td><td>'+res[i].nombres+'</td><td>'+res[i].apellidos+'</td><td>'+fuente+'</td><td>'+res[i].telefono+'</td><td>'+$.timeago(res[i].interaccion)+'</td><td>'+res[i].usuario+'</td><td>'+res[i].nota+'</td></tr>');
    }
    paginas = contactos.length / $("#item").val()*1;
    $("#paginasBtns").html('');
    for(i=0;i<=paginas;i++){
      active = ((i+1)==paginaActual) ? "btn-primary" : "btn-default" ;
      $("#paginasBtns").append('<input type="button" class="btn '+active+'" value="'+eval(i+1)+'" onclick="paginar(this.value, item.value)">')
    }
}

function agregarPax(){
    // $("#form_pasajero").submit((e)=>e.preventDefault);
    var data = $("#form_pasajero").serialize();
    
    if($("input[name='nombre']").val()){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'insertar=true&'+data,
            success: consultar,
        });
    }
    $("input").val('');
}
function consultar(){
  $.ajax({
      url: plugin_ruta+'src/controllers/crmController.php',
      type: 'POST',
      data: 'listar=true',
      success: (res)=>{listar(res)}
  });
}

function paginar(pagina, items){
    paginas = contactos.length / items;
    paginaActual = (pagina > (paginas + 1).toFixed(0)*1) ? (pagina - 1) : pagina;
    res = contactos;
    $("#contactos").html("");
    inicio = (pagina - 1) * items;
    final = (pagina * items);
    final = (final >= contactos.length) ? contactos.length : final;

    for(i=inicio;i<final;i++){
        var correo=(res[i].correo==null) ? "" : res[i].correo;
        var telefono=(res[i].telefono==null) ? "" : res[i].telefono;
        var fuente=(res[i].fuente==null) ? "" : res[i].fuente;
        $("#contactos").append('<tr><td><button class="btn btn-success" onclick="verHistorial('+i+')" title="Ver Historial" data-toggle="modal" data-target="#historialContacto"><i class="fa fa-plus"></i></button></td><td>'+res[i].nombres+'</td><td>'+res[i].apellidos+'</td><td>'+fuente+'</td><td>'+res[i].telefono+'</td><td>'+$.timeago(res[i].interaccion)+'</td><td>'+res[i].usuario+'</td><td>'+res[i].nota+'</td></tr>');
    }
    
    $("#paginasBtns").html('');
    for(i=0;i<=paginas;i++){
      active = ((i+1)==paginaActual) ? "btn-primary" : "btn-default" ;
      $("#paginasBtns").append('<input type="button" class="btn '+active+'" value="'+eval(i+1)+'" onclick="paginar(this.value, item.value)">')
    }  
}

function paginaSiguiente(){
    pagina = ((paginaActual + 1) > (paginas+1).toFixed(0)*1) ? (paginas+1).toFixed(0) : (paginaActual + 1);
    items = $("#item").val()*1;
    paginar(pagina, items)
}

function paginaAnterior(){
    pagina = ((paginaActual - 1) <= 0) ? 1 : (paginaActual - 1);
    items = $("#item").val()*1;
    paginar(pagina, items)
}

function verHistorial(e){
    console.log(contactos[e]);
    c = contactos[e]
    contactoId = c.conId;
    contactoUser = c.usuario;
    $("input[type='text']").prop('disabled', true);
    $("#hsNombres").val(c.nombres);
    $("#hsApellidos").val(c.apellidos);
    $("#hsCorreo").val(c.correo);
    $("#hsTelefono").val(c.telefono);
    $("#hsFuente").val(c.fuente);
    $.ajax({
      url: plugin_ruta+'src/controllers/crmController.php',
      tyep: 'GET',
      data: 'historial='+contactoId,
      success: (res)=>{
        hs = eval(res);
        console.log(hs);
        $("#comentarios").html('');
        hs.forEach(h=>{             
          $("#comentarios").append('<div class="col-12"><div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">'+$.timeago(h.interaccion)+' por '+h.usuario+'</div><div class="p mb-0 font-weight-bold text-gray-800">'+h.contenido+'</div></div></div></div></div></div>');
        });
      }
    })
}

</script>