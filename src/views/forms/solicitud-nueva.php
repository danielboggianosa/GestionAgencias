<form id="form_detalles">
    <div class="card">
        <div class="card-header">
            <h3>Detalles de la Solicitud</h3>
        </div>
        <div class="card-body">
        <div class="form-group row">
            <label class="control-label col-sm-4" for="destino">Origen:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="origen" placeholder="Origen o Ruta">
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-sm-4" for="destino">Destino:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="destino" placeholder="Destino o Ruta">
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-3" for="servicio">Cantidad de pasajeros:</label>
            <div class="col-sm-3">
                <label for="adultos">Adultos<br>(12+):</label>
                <input type="number" min="0" class="form-control" name="adultos">
            </div>
            <div class="col-sm-3">
                <label for="menores">Niños<br>(2 a 12):</label>
                <input type="number" min="0"  class="form-control" name="menores">
            </div>
            <div class="col-sm-3">
                <label for="infantes">Infantes<br>(0 a 2):</label>
                <input type="number" min="0" class="form-control" name="infantes">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="control-label col-sm-3" for="servicio">Servicios:</label>
            <div class="col-sm-9">
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
        
        <div class="form-group row">
            <label class="control-label col-sm-3" for="flexible">Fecha:</label>
            <div class="col-sm-9">
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

        <div class="form-group row" id="exacta">
            <label class="control-label col-sm-5" for="salida">Fecha de Salida:</label>
            <div class="col-sm-7">
                <input type="date" class="form-control" name="salida">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="control-label col-sm-5" for="retorno">Fecha de Retorno:</label>
            <div class="col-sm-7">
                <input type="date" class="form-control" name="retorno">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="control-label col-sm-5" for="comentario">Observaciones:</label>
            <div class="col-sm-7">
                <textarea class="form-control" name="comentario"></textarea>
            </div>
        </div>
    </div>
    </div>
    
    <input class="btn btn-success" type="submit" name="enviar" value="Registrar Solicitud">
</form>