<?php include RUTA."src/views/common/head.php"?>

<div class="wrap">
    <h2>Bienvenido <?php echo wp_get_current_user()->first_name ?></h2>
    <div class="container">
        
<div class="row">
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tipo de Cambio (Venta)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="tc_venta"></span></div>
          </div>
          <div class="col-auto">
          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tipo de Cambio (Compra)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="tc_compra"></span></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
              </div>
              <div class="col">
                <div class="progress progress-sm mr-2">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
        <div class="row">
            <div class="col col-md-4">
                <a href="#" class="btn btn-sq btn-primary">
                    <i class="fa fa-cart-plus fa-3x"></i><br/>
                    Nueva<br>Venta
                </a>
            </div>
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
            cambio = res.USD_PEN;
            compra = ((cambio*1) - 0.05).toFixed(3);
            venta = ((cambio*1) + 0.05).toFixed(3);
            $("#tc_compra").html(compra);
            $("#tc_venta").html(venta);
        }
    })  
})
</script>
