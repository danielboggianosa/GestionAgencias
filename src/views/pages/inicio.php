<?php include RUTA."src/views/common/head.php"?>

<div class="wrap">
    <h2>Bienvenido <?php echo wp_get_current_user()->first_name ?></h2>
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <a href="#" class="btn btn-sq btn-primary">
                    <i class="fa fa-cart-plus fa-3x"></i><br/>
                    Nueva<br>Venta
                </a>
            </div>
        </div>
        <div class="row">
            <label for="">Tipo de Cambio de Hoy:</label>
            <button class="btn">Compra: <span id="tc_compra"></span></button>
            <button class="btn">Venta: <span id="tc_venta"></span></button>
        </div>
    </div>
</div>


<script>
jQuery(document).ready(()=>{
    var plugin_ruta = "../wp-content/plugins/pdm-admin/";  
    $.ajax({
        url:'https://free.currconv.com/api/v7/convert?q=USD_PEN&compact=ultra&apiKey=7268e03a7dbeaa694dbd',
        type:'GET',
        success: (res)=>{
            console.log(res);
            $("#tc_compra").html((res.USD_PEN-0.05))
            $("#tc_venta").html((res.USD_PEN+0.05))
        }
    })  
})
</script>
