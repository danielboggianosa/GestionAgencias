<?php 
if(isset($_POST["valor"])){
    echo json_encode("el valor es: ".$_POST["valor"]);
}
?>

<form action="<?php echo get_site_url()."/?page_id=".get_the_ID() ?>" method="post">
            <h3>Datos del Cliente</h3>
        <div class="form-group" id="cliente-registrado">
            <label for="buscar" class="control-label">Buscar cliente:</label>
            <input class="form-control" type="text" name="buscar" id="buscar" placeholder="Busca por nombre, apellido o ID" onkeyup="VerListaClientes(this.value)">
        </div>
    <div id="lista"></div>
        <input type="checkbox" class="hidden" name="nuevo" id="nuevo" onchange="MostrarFormulario('pasajero-nuevo',this.id)">
        <label style="cursor: pointer;" for="nuevo" class="btn-link">Registrar Nuevo Cliente</label>
    <div >
    <div id="pasajero_nuevo"></div>
    </div>
        
        <div class="form-horizontal panel panel-default">
            <h3>Detalles de la Solicitud</h3>
            <div class="form-group">
            <label class="control-label col-sm-4" for="destino">Origen:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="origen" placeholder="Origen o Ruta">
                </div>
            <label class="control-label col-sm-4" for="destino">Destino:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="destino" placeholder="Destino o Ruta">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="servicio">Cantidad de pasajeros:</label>
                <div class="col-sm-2">
                    <label for="adultos">Adultos<br>(12 años a más):</label>
                    <input type="number" min="0" class="form-control" name="adultos">
                </div>
                <div class="col-sm-2">
                    <label for="menores">Niños<br>(2 a 12 años):</label>
                    <input type="number" min="0"  class="form-control" name="menores">
                </div>
                <div class="col-sm-2">
                    <label for="infantes">Infantes<br>(0 a 2 años):</label>
                    <input type="number" min="0" class="form-control" name="infantes">
                </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-4" for="servicio">Servicios:</label>
                <div class="col-sm-7">
                    <label class="cursor-pointer">
                        <input type="checkbox" name="vuelo" value="VUELO">
                        Vuelo
                    </label>
                    <label class="cursor-pointer">
                        <input type="checkbox" name="Hotel" value="HOTEL">
                        Hotel
                    </label>
                    <label class="cursor-pointer">
                        <input type="checkbox" name="traslado" value="TRASLADO">
                        Traslados
                    </label>
                    <label class="cursor-pointer">
                        <input type="checkbox" name="Tours" value="TOURS">
                        Tours
                    </label>
                </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-4" for="flexible">Fecha:</label>
                <div class="col-sm-7">
                    <label class="cursor-pointer">
                        <input type="radio" name="flexible" option="SI">
                        Flexible
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="flexible" option="NO">
                        Exacta
                    </label>
                </div>
            </div>
            <div class="form-group" id="exacta">
            <label class="control-label col-sm-4" for="salida">Fecha de Salida:</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="salida">
                </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-4" for="retorno">Fecha de Retorno:</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="retorno">
                </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-4" for="comentario">Observaciones:</label>
                <div class="col-sm-7">
                    <textarea class="form-control" name="comentario"></textarea>
                </div>
            </div>
        </div>
        <input class="form-control btn-success" type="submit" name="enviar" value="Registrar Solicitud">
    </form>