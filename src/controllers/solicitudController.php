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

    public function solicitudes($id){
        global $wpdb;
        $sql="SELECT pdm_solicitud_id as id, pdm_solicitud_inicio as inicio, pdm_solicitud_estado as estado, pdm_solicitud_servicios as servicios, pdm_solicitud_fecha_tipo as fechaTipo, pdm_solicitud_fecha_salida as salida, pdm_solicitud_fecha_retorno as retorno, pdm_solicitud_origen as origen, pdm_solicitud_destino as destino, pdm_solicitud_cantidad_adt as adultos, pdm_solicitud_cantidad_chd as ninos, pdm_solicitud_cantidad_inf as bebes, pdm_solicitud_descripcion as descripcion FROM pdm_solicitud WHERE pdm_solicitud_pasajero_ID = $id;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }
}

$solicitud = new Solicitud;

if($_POST['insertar']){
    $solicitud->insertar();
}

if($_POST['solicitud']){
    $id=$_POST['id'];
    $solicitud->solicitudes($id);
}