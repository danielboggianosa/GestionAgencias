<?php include RUTA."src/views/common/head.php"?>

<div class="wrap">
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">CRM</h1>
<p class="mb-4">Base de datos de contactos con detalles para realizar seguimiento.</p>
<div class="buttons">
  <a class="btn btn-link" href="#" data-toggle="modal" data-target="#nuevoContacto">
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
            <th class="filtro" id="Tinteraccion">Última Interacción <i class="fa fa-angle-down"></i></th>
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
        <button class="btn btn-default">Anterior</button>
        <div id="paginasBtns"></div>
        <button class="btn btn-default">Siguiente</button>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<!-- Logout Modal-->
<div class="modal fade" id="nuevoContacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Contacto</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"><form id="form_pasajero"><?php include RUTA."src/views/forms/pasajero-nuevo.php" ?><form></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal" id="closeModal">Cancel</button>
        <button class="btn btn-primary" type="button" onclick="agregarPax()" data-dismiss="modal">Registrar</button>
      </div>
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
  $.ajax({
      url: plugin_ruta+'src/controllers/crmController.php',
      type: 'POST',
      data: 'listar=true',
      success: (res)=>{listar(res)}
  });

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
    console.log(e)
    valor = e.currentTarget.value
  })

  $("#buscar").keyup(()=>{
        $.ajax({
            url: plugin_ruta+'src/controllers/crmController.php',
            type:"POST",
            data:'buscar='+$("#buscar").val(),
            success: (res)=>{listar(res)}
        });               
    });

});

var contactos, paginas;
function listar(r){
    var res = eval(r);
    contactos = res;
    $("#contactos").html("");
    for(i=0;i<res.length;i++){
        var correo=(res[i].correo==null) ? "" : res[i].correo;
        var telefono=(res[i].telefono==null) ? "" : res[i].telefono;
        var fuente=(res[i].fuente==null) ? "" : res[i].fuente;
        $("#contactos").append('<tr><td><i class="fa fa-plus"></i></td><td>'+res[i].nombres+'</td><td>'+res[i].apellidos+'</td><td>'+fuente+'</td><td>'+res[i].telefono+'</td><td>'+$.timeago(res[i].interaccion)+'</td><td>'+res[i].usuario+'</td><td>'+res[i].nota+'</td></tr>');
    }
    paginas = contactos.length / $("#item").val()*1;
    $("#paginasBtns").html('');
    for(i=0;i<=paginas;i++){
      $("#paginasBtns").append('<button class="btn btn-default">'+eval(i+1)+'</button>')
    }    
}
// <tr><th></th></tr>
function agregarPax(){
    // $("#form_pasajero").submit((e)=>e.preventDefault);
    var data = $("#form_pasajero").serialize();
    if($("input[name='nombre']").val()){
        $.ajax({
            type:"POST",
            url: plugin_ruta+'src/controllers/pasajeroController.php',
            data: 'insertar=true&'+data,
        });
        $.ajax({
            url: plugin_ruta+'src/controllers/crmController.php',
            type: 'POST',
            data: 'listar=true',
            success: (res)=>{listar(res)}
        });
    }
}

</script>