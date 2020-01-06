<form id="nuevoServicio" class="form-style-8">
    <div class="row">
        <label class="col-md-4">Día: <input type="number" name="dia" /></label>
        <label class="col-md-4">Hora de Inicio: <input type="time" name="hInicio" /></label>
        <label class="col-md-4">Hora de Final: <input type="time" name="hFinal" /></label>
        <label class="col-md-12">Nombre del Servicio: <input type="text" name="servicio" /></label>
        <label class="col-md-12">Descripción: <textarea name="descripcion"></textarea></label>
        <label class="col-md-12">Foto: <input type="url" name="foto" /></label>
        <label class="col-md-6">Operador: <input type="text" name="operador" /></label>
        <label class="col-md-6">Moneda: 
            <select name="moneda">
                <option value="USD">Dólares Americanos</option>
                <option value="PEN">Soles</option>
                <option value="EUR">Euros</option>
                <option value="OTRA">Otra</option>
            </select></label>
        <label class="col-md-6">Costo: <input type="text" name="costo" /></label>
        <label class="col-md-6">Precio: <input type="text" name="precio" /></label>
    </div>
    <!-- <button type="button" class="btn btn-link"><i class="fa fa-plus"></i> Agregar Otro Servicio</button>
    <div class="button-section">
        <input type="submit" value="Agregar" />
    </div> -->
</form>