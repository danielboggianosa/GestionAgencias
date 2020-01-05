<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

class Pasajero {
    private $tabla = "pdm_pasajero";

    public function __construct() {}
    
    public function listar(){
        global $wpdb;
        $sql = "SELECT ".$this->tabla."_id as id, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_foto as foto, ".$this->tabla."_fuente as fuente, pdm_telefono_numero as telefono, pdm_correo_correo as correo, pdm_identificacion_numero as documento FROM ".$this->tabla." LEFT JOIN pdm_paxtel ON pdm_paxtel_pasajero_ID = ".$this->tabla."_id LEFT JOIN pdm_telefono ON pdm_telefono_id = pdm_paxtel_telefono_ID LEFT JOIN pdm_paxcor ON pdm_paxcor_pasajero_ID = ".$this->tabla."_id LEFT JOIN pdm_correo ON pdm_correo_id = pdm_paxcor_correo_ID LEFT JOIN pdm_paxid ON pdm_paxid_pasajero_ID = ".$this->tabla."_id LEFT JOIN pdm_identificacion ON pdm_identificacion_id = pdm_paxid_identificacion_ID GROUP BY id LIMIT 1500;";
        $resultados = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultados);
    }

    public function obtener($id){
        global $wpdb;
        $sql = "SELECT ".$this->tabla."_id as id, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_nacimiento as nacimiento, ".$this->tabla."_nacionalidad as nacionalidad, ".$this->tabla."_foto as foto, ".$this->tabla."_notas as notas FROM ".$this->tabla." WHERE ".$this->tabla."_id = $id;";
        $pasajero = $wpdb->get_results($sql, OBJECT);

        $sql="SELECT pdm_telefono_id as id, pdm_telefono_numero as telefono FROM pdm_telefono INNER JOIN pdm_paxtel ON pdm_paxtel_telefono_ID = pdm_telefono_id WHERE pdm_paxtel_pasajero_ID = $id;";
        $telefono = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_correo_id as id, pdm_correo_correo as correo FROM pdm_correo INNER JOIN pdm_paxcor ON pdm_paxcor_correo_ID = pdm_correo_id WHERE pdm_paxcor_pasajero_ID = $id;";
        $correo = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_identificacion_id as id, pdm_identificacion_numero as numero, pdm_identificacion_tipo as tipo, pdm_identificacion_pais as pais, pdm_identificacion_emision as emision, pdm_identificacion_vencimiento as vencimiento, pdm_identificacion_nota as nota, pdm_identificacion_foto as foto FROM pdm_identificacion INNER JOIN pdm_paxid ON pdm_paxid_identificacion_ID = pdm_identificacion_id WHERE pdm_paxid_pasajero_ID = $id;";
        $identificacion = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_direccion_pais as pais, pdm_direccion_ciudad as ciudad, pdm_direccion_distrito as distrito, pdm_direccion_nombre as nombre, pdm_direccion_id as id FROM pdm_direccion INNER JOIN pdm_paxdir ON pdm_paxdir_direccion_ID = pdm_direccion_id WHERE pdm_paxdir_pasajero_ID = $id";
        $direccion = $wpdb->get_results($sql, OBJECT);

        $resultado = array(
            $pasajero[0], 
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
        $sql = "SELECT ".$this->tabla."_id as id, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_foto as foto, pdm_telefono_numero as telefono, pdm_correo_correo as correo, pdm_identificacion_numero as documento FROM ".$this->tabla." LEFT JOIN pdm_paxtel ON pdm_paxtel_pasajero_ID = ".$this->tabla."_id LEFT JOIN pdm_telefono ON pdm_telefono_id = pdm_paxtel_telefono_ID LEFT JOIN pdm_paxcor ON pdm_paxcor_pasajero_ID = ".$this->tabla."_id LEFT JOIN pdm_correo ON pdm_correo_id = pdm_paxcor_correo_ID LEFT JOIN pdm_paxid ON pdm_paxid_pasajero_ID = ".$this->tabla."_id LEFT JOIN pdm_identificacion ON pdm_identificacion_id = pdm_paxid_identificacion_ID WHERE ".$this->tabla."_nombres LIKE '%$valor%' OR ".$this->tabla."_apellidos LIKE '%$valor%' GROUP BY id LIMIT 50;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }
    public function insertar($data){
        global $wpdb;        
        $pasajero = array(
            $this->tabla.'_nombres' => $data["nombres"],
            $this->tabla.'_apellidos' => $data["apellidos"],
            $this->tabla.'_nacionalidad' => $data["nacionalidad"],
            $this->tabla.'_nacimiento' => $data["nacimiento"],
            $this->tabla.'_notas' => $data["notas"],
        );
        $telefono = $data['telefono'];
        $correo = $data['correo'];
        $wpdb->insert($this->tabla, $pasajero);
        $paxid = $wpdb->insert_id;
        for($i=0;$i<sizeof($telefono);$i++){
            $wpdb->insert("pdm_telefono", array(
                "pdm_telefono_numero" => $telefono[$i]
            ));
            $telid = $wpdb->insert_id;
            $wpdb->insert("pdm_paxtel", array(
                "pdm_paxtel_pasajero_ID" => $paxid,
                "pdm_paxtel_telefono_ID" => $telid
            ));
        }
        for($i=0;$i<sizeof($correo);$i++){
            $wpdb->insert("pdm_correo", array(
                "pdm_correo_correo" => $correo[$i]
            ));
            $corid = $wpdb->insert_id;
            $wpdb->insert("pdm_paxcor", array(
                "pdm_paxcor_pasajero_ID" => $paxid,
                "pdm_paxcor_correo_ID" => $corid
            ));
        }
        if($_POST['identificacion'] != ""){
            $identificacion = array(
                "numero" => $_POST['identificacion'],
                "f_ini" => $_POST['f_emision'],
                "f_fin" => $_POST['f_vencimiento'],
                "pais" => $_POST['id_pais'],
                "foto" => $_POST['id_foto'],
                "nota" => $_POST['id_nota'],
                "tipo" => $_POST['TipoID']
            );
            for($i=0;$i<sizeof($identificacion['numero']);$i++){
                $wpdb->insert("pdm_identificacion", array(
                    "pdm_identificacion_tipo" => $identificacion['tipo'][$i],
                    "pdm_identificacion_numero" => $identificacion['numero'][$i],
                    "pdm_identificacion_pais" => $identificacion['pais'][$i],
                    "pdm_identificacion_emision" => $identificacion['f_ini'][$i],
                    "pdm_identificacion_vencimiento" => $identificacion['f_fin'][$i],
                    "pdm_identificacion_nota" => $identificacion['nota'][$i],
                    "pdm_identificacion_foto" => $identificacion['foto'][$i]
                ));
                $idid = $wpdb->insert_id;
                $wpdb->insert("pdm_paxid", array(
                    "pdm_paxid_pasajero_ID" => $paxid,
                    "pdm_paxid_identificacion_ID" => $idid
                ));
            }    
        }
        if(isset($_POST['direccion'])){
            $direccion = array(
                "nombre" => $_POST['direccion'],
                "distrito" => $_POST['distrito'],
                "ciudad" => $_POST['ciudad'],
                "pais" => $_POST['pais']
            );
            for($i=0;$i<sizeof($direccion['nombre']);$i++){
                $wpdb->insert("pdm_direccion", array(
                    "pdm_direccion_nombre" => $direccion['nombre'][$i],
                    "pdm_direccion_distrito" => $direccion['distrito'][$i],
                    "pdm_direccion_ciudad" => $direccion['ciudad'][$i],
                    "pdm_direccion_pais" => $direccion['pais'][$i],
                ));
                $dirid = $wpdb->insert_id;
                $wpdb->insert("pdm_paxdir", array(
                    "pdm_paxdir_pasajero_ID" => $paxid,
                    "pdm_paxdir_direccion_ID" => $dirid,
                ));
            }
        }
        echo json_encode($data);
    }

    public function solicitudes($id){
        global $wpdb;
        $sql="SELECT pdm_solicitud_id as id, pdm_solicitud_inicio as inicio, pdm_solicitud_estado as estado, pdm_solicitud_servicios as servicios, pdm_solicitud_fecha_tipo as fechaTipo, pdm_solicitud_fecha_salida as salida, pdm_solicitud_fecha_retorno as retorno, pdm_solicitud_origen as origen, pdm_solicitud_destino as destino, pdm_solicitud_cantidad_adt as adultos, pdm_solicitud_cantidad_chd as ninos, pdm_solicitud_cantidad_inf as bebes, pdm_solicitud_descripcion as descripcion FROM pdm_solicitud WHERE pdm_solicitud_pasajero_ID = $id;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }
}

$pasajero = new Pasajero;

if(isset($_POST['buscar'])){
    $pasajero->buscar($_POST['buscar']);
}

if(isset($_POST['obtener'])){
    $pasajero->obtener($_POST['obtener']);
}

if($_POST['listar']){
    $pasajero->listar();
}

if(isset($_POST['insertar'])){
    $data = array(
        "nombres" => $_POST['nombre'], 
        "apellidos" => $_POST['apellido'],
        "nacionalidad" => $_POST['nacionalidad'],
        "nacimiento" => $_POST['nacimiento'],
        "notas" => $_POST['observacion'],
        "telefono" => $_POST['telefono'],
        "correo" => $_POST['correo'],
    );
    $pasajero->insertar($data);
}

if(isset($_POST['addPost'])){
    $newPost = wp_insert_post(
        array(
            'ID' 					=> 0,
            'post_author' 			=> get_current_user_id(),
            'post_date' 			=> current_time('mysql', 0),
            'post_content' 			=> $_POST['contenido'],
            'post_content_filtered' => '',
            'post_title' 			=> $_POST['titulo'],
            'post_excerpt' 			=> '',
            'post_status' 			=> 'draft',
            'post_type' 			=> 'itinerario',
            'comment_status' 		=> 'open',
            'ping_status' 			=> '',
            'post_password' 		=> '',
            'post_name' 			=> '',
            'to_ping' 				=> '',
            'pinged'				=> '',
            'post_modified'			=> '',
            'post_modified_gmt'		=> '',
            'post_parent'			=> '',
            'menu_order'			=> '',
            'post_mime_type'		=> '',
            'guid'					=> '',
            'post_category'			=> '',
            'tags_input'			=> '',
            'tax_input'				=> '',
            'meta_input'			=> '',
        ),
        false
    );
    echo json_encode($newPost);
}

if($_POST['solicitud']){
    $id=$_POST['id'];
    $pasajero->solicitudes($id);
}
