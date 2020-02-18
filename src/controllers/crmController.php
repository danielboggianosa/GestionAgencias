<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

class Contacto {
    private $tabla = "pdm_contacto";

    public function __construct() {}
    
    public function listar(){
        global $wpdb;
        $wp_users = $wpdb->prefix."users";
        if(isset($_POST['campo']) and isset($_POST['orden'])){
            $campo = $_POST['campo'];
            $orden = $_POST['orden'];
            $filtro = "ORDER BY $campo $orden";
        }
        else{
            $filtro = "ORDER BY interaccion DESC";
        }
        $sql = "SELECT  
        a.pdm_contacto_id as conId, 
        a.pdm_contacto_nombres as nombres, 
        a.pdm_contacto_apellidos as apellidos,
        a.pdm_contacto_fuente as fuente,
        a.pdm_contacto_estado as estado,
        d.pdm_telefono_numero as telefono, 
        e.pdm_correo_correo as correo,
        b.pdm_historial_contenido as nota,
        b.pdm_historial_creado as interaccion,
        f.user_login as usuario
        FROM    pdm_contacto a
        LEFT JOIN pdm_telefono d
            ON d.pdm_telefono_tabla = 'pdm_contacto'
            AND d.pdm_telefono_tabla_ID = a.pdm_contacto_id
        LEFT JOIN pdm_correo e
            ON e.pdm_correo_tabla = 'pdm_contacto'
            AND e.pdm_correo_tabla_ID = a.pdm_contacto_id
        INNER JOIN pdm_historial b
            ON b.pdm_historial_tabla_ID = a.pdm_contacto_id
        INNER JOIN
        (
            SELECT  pdm_historial_tabla_ID, MAX(pdm_historial_creado) Max_Date
            FROM    pdm_historial
            GROUP   BY pdm_historial_tabla_ID
        ) c ON  b.pdm_historial_tabla_ID = c.pdm_historial_tabla_ID
            AND b.pdm_historial_creado = Max_date           
        INNER JOIN $wp_users f
            ON pdm_historial_usuario = f.ID
        WHERE a.pdm_contacto_estado != 'BORRADO'
        GROUP BY conId
        $filtro
        LIMIT 5000;";
        $resultados = $wpdb->get_results($sql, OBJECT);
        // echo $sql;
        echo json_encode($resultados);
    }

    public function obtener($id){
        global $wpdb;
        $sql = "SELECT ".$this->tabla."_id as id, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_nacimiento as nacimiento, ".$this->tabla."_nacionalidad as nacionalidad, ".$this->tabla."_foto as foto, ".$this->tabla."_notas as notas FROM ".$this->tabla." WHERE ".$this->tabla."_id = $id;";
        $contacto = $wpdb->get_results($sql, OBJECT);

        $sql="SELECT pdm_telefono_id as id, pdm_telefono_numero as telefono FROM pdm_telefono WHERE pdm_telefono_tabla = 'pdm_contacto' AND pdm_telefono_tabla_ID = $id;";
        $telefono = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_correo_id as id, pdm_correo_correo as correo FROM pdm_correo WHERE pdm_correo_tabla = 'pdm_contacto' AND pdm_correo_tabla_ID = $id;";
        $correo = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_identificacion_id as id, pdm_identificacion_numero as numero, pdm_identificacion_tipo as tipo, pdm_identificacion_pais as pais, pdm_identificacion_emision as emision, pdm_identificacion_vencimiento as vencimiento, pdm_identificacion_nota as nota, pdm_identificacion_foto as foto FROM pdm_identificacion WHERE pdm_identificacion_tabla = 'pdm_contacto' AND pdm_identificacion_tabla_ID = $id;";
        $identificacion = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_direccion_pais as pais, pdm_direccion_ciudad as ciudad, pdm_direccion_distrito as distrito, pdm_direccion_nombre as nombre, pdm_direccion_id as id FROM pdm_direccion WHERE pdm_paxdir_direccion_ID = 'pdm_contacto' AND pdm_direccion_tabla_id = $id";
        $direccion = $wpdb->get_results($sql, OBJECT);

        $resultado = array(
            $contacto[0], 
            $telefono, 
            $correo, 
            $identificacion, 
            $direccion
        );
        echo json_encode($resultado);
    }

    public function borrar($id){
        global $wpdb;
        $table = $this->tabla;
        $cid = $this->tabla."_id";
        $sql = "DELETE FROM $table WHERE $cid = $id;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }

    public function actualizar($id, $campo, $valor){
        global $wpdb;
        $table = $this->tabla;
        $cid = $table."_id";
        $campo = $table."_".$campo;
        $sql = "UPDATE $campo = $valor FROM $table WHERE ";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }
    
    public function buscar($valor){
        global $wpdb;
        $sql = "SELECT ".$this->tabla."_id as conId, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_fuente as fuente, ".$this->tabla."_estado as estado, pdm_telefono_numero as telefono, pdm_historial_contenido as nota, pdm_historial_creado as interaccion, user_login as usuario FROM ".$this->tabla." LEFT JOIN pdm_telefono ON pdm_telefono_tabla = '".$this->tabla."' AND pdm_telefono_tabla_ID = ".$this->tabla."_id INNER JOIN pdm_historial ON pdm_historial_tabla = '".$this->tabla."' AND pdm_historial_tabla_ID = ".$this->tabla."_id LEFT JOIN $wp_users ON pdm_historial_usuario = ID WHERE ".$this->tabla."_nombres LIKE '%$valor%' OR ".$this->tabla."_apellidos LIKE '%$valor%' GROUP BY conId $filtro LIMIT 1500;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }

    public function historial($id){
        global $wpdb;
        $sql = "SELECT pdm_historial_id as id, pdm_historial_creado as interaccion, pdm_historial_contenido as contenido, user_login as usuario FROM pdm_historial INNER JOIN $wp_users ON $wp_users.ID = pdm_historial_usuario WHERE pdm_historial_tabla = '".$this->tabla."' AND pdm_historial_tabla_ID = $id ORDER BY interaccion DESC;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }

    public function insertarHistorial(){
        global $wpdb;
        $wpdb->insert($tab = "pdm_historial", $datos = array(
            "pdm_historial_tabla" => $this->tabla,
            "pdm_historial_tabla_id" => $_POST['contactoId'],
            "pdm_historial_usuario" => get_current_user_id(),
            "pdm_historial_contenido" => $_POST['contenido']
        ));
        $tabid = $wpdb->insert_id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data)),
            "pdm_registro_usuario" => get_current_user_id()
        ));

    }
}

$contacto = new Contacto;

if(isset($_POST['buscar'])){
    $contacto->buscar($_POST['buscar']);
}

if(isset($_POST['obtener'])){
    $contacto->obtener($_POST['obtener']);
}

if($_POST['listar']){
    $contacto->listar();
}

if(isset($_GET['historial'])){
    $contacto->historial($_GET['historial']);
}

if(isset($_POST['contenido'])){
    $contacto->insertarHistorial();
}
