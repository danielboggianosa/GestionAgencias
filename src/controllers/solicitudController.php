<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

class Solicitud {
    private $tabla = "pdm_solicitud";
    
    function __construct(){

    }

    function listar($paxId = null){
        global $wpdb;
        $sql = "SELECT pdm_solicitud_usuario AS usuario, pdm_solicitud_pasajero_ID AS paxId, ";
        $resultados = $wpdb->get_results($sql, OBJECT);
    }

    function insertar(){
        global $wpdb;
        $servicios = $_POST['vuelo'].",".$_POST['hotel'].",".$_POST['traslados'].",".$_POST['tours'];
        $servicios = array($_POST['vuelo'],$_POST['hotel'],$_POST['traslados'],$_POST['tours']);
        $data=array(
            $this->tabla."_"."inicio" => current_time('mysql'),
            $this->tabla."_"."usuario" => get_current_user_id(),
            $this->tabla."_"."responsable" => get_current_user_id(),
            $this->tabla."_"."pasajero_ID" => $_POST['pasajero'],
            $this->tabla."_"."servicios" => json_encode($servicios),
            $this->tabla."_"."estado" => "EN PROGRESO",
            $this->tabla."_"."fecha_tipo" => $_POST['flexible'],
            $this->tabla."_"."fecha_salida" => $_POST['salida'],
            $this->tabla."_"."fecha_retorno" => $_POST['retorno'],
            $this->tabla."_"."origen" => $_POST['origen'],
            $this->tabla."_"."destino" => $_POST['destino'],
            $this->tabla."_"."cantidad_adt" => $_POST['adultos'],
            $this->tabla."_"."cantidad_chd" => $_POST['menores'],
            $this->tabla."_"."cantidad_inf" => $_POST['infantes'],
            $this->tabla."_"."descripcion" => $_POST['comentario']
        );
        $wpdb->insert($this->tabla, $data);
        echo json_encode($data);
    }
}

$solicitud = new Solicitud;

if($_POST['insertar']){
    $solicitud->insertar();
}