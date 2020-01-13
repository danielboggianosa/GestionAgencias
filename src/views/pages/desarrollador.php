<?php include RUTA."/src/views/common/head.php" ?>

<div class="wrap container">
    <form method="post">
        <label for="query">CONSULTA SQL</label>
        <div class="code-block">
        <textarea name="query" id="query" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <button class="btn btn-info">Cargar Query</button>
    </form>
    <div class="panel">
        <?php
            if(isset($_POST["query"])){
                global $wpdb;
                $resultados = $wpdb->get_results($_POST["query"], OBJECT);
                ?>
                <div class="panel-info p-3"><?php echo $_POST["query"]; ?></div>
                <div class="panel-success p-3">
                    <table class="table tabla-hover">
                        <thead>
                            <tr id="titulos">                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($resultados as $valores){
                                echo "<tr>";
                                    foreach($valores as $valor){
                                        echo "<td>$valor</td>";
                                    }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            else{
                $resultados = array("");
            }
        ?>
    </div>
</div>
<script>
$(document).ready(()=>{
    var titulos = Object.keys(<?php echo json_encode($resultados[0]) ?>);
    titulos.forEach(t => $("#titulos").append('<th>'+t+'</th>'));
})
</script>
