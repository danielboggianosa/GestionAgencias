<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

class Solicitud {
    private $tabla = "pdm_solicitud";
    
    function __construct(){

    }

    function insertar(){
        global $wpdb;
        $servicios = $_POST['vuelo'].",".$_POST['hotel'].",".$_POST['traslados'].",".$_POST['tours'];
        $data=array(
            $this->tabla."_inicio" => current_time('mysql'),
            $this->tabla."_usuario" => get_current_user_id(),
            $this->tabla."_responsable" => get_current_user_id(),
            $this->tabla."_pasajero_ID" => $_POST['pasajero'],
            $this->tabla."_servicios" => $servicios,
            $this->tabla."_estado" => "EN PROGRESO",
            $this->tabla."_fecha_tipo" => $_POST['flexible'],
            $this->tabla."_fecha_salida" => $_POST['salida'],
            $this->tabla."_fecha_retorno" => $_POST['retorno'],
            $this->tabla."_origen" => $_POST['origen'],
            $this->tabla."_destino" => $_POST['destino'],
            $this->tabla."_cantidad_adt" => $_POST['adultos'],
            $this->tabla."_cantidad_chd" => $_POST['menores'],
            $this->tabla."_cantidad_inf" => $_POST['infantes'],
            $this->tabla."_descripcion" => $_POST['comentario']
        );
        $wpdb->insert($this->tabla, $data);
        echo json_encode($data);
    }
}

$solicitud = new Solicitud;

if($_POST['insertar']){
    $solicitud->insertar();
}