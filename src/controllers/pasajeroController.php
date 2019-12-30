<?php

class Pasajero {
    public $tabla = "pdm_pasajero";
    public $id;
    public $nombre;
    public $apellido;
    public $nacimiento;
    public $notas;
    public $foto;
    public $identificacion=[];
    public $intereses=[];
    public $telefono=[];
    public $direccion=[]; //VARIABLES

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->naciemiento = $args['nacimiento'] ?? '';
        $this->notas = $args['notas'] ?? '';
        $this->intereses = $args['intereses'] ?? '';
        $this->foto = $args['foto'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->identificacion["tipo"] = $args['tipoID'] ?? '';
        $this->identificacion["numero"] = $args['numeroID'] ?? '';
        $this->direccion["calle"] = $args['calle'] ?? '';
        $this->direccion["distrito"] = $args['distrito'] ?? '';
        $this->direccion["ciudad"] = $args['ciudad'] ?? '';
        $this->direccion["pais"] = $args['pais'] ?? '';
    }
    
    
    public function buscar($valor){
        global $wpdb;
        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
        $sql = "SELECT pdm_pasajero_id as id, pdm_pasajero_nombres as nombres, pdm_pasajero_apellidos as apellidos, pdm_telefono_numero as telefono, pdm_correo_correo as correo FROM pdm_pasajero LEFT JOIN pdm_paxtel ON pdm_paxtel_pasajero_ID = pdm_pasajero_id LEFT JOIN pdm_telefono ON pdm_telefono_id = pdm_paxtel_telefono_ID LEFT JOIN pdm_paxcor ON pdm_paxcor_pasajero_ID = pdm_pasajero_id LEFT JOIN pdm_correo ON pdm_correo_id = pdm_paxcor_correo_ID WHERE pdm_pasajero_nombres LIKE '%$valor%' OR pdm_pasajero_apellidos LIKE '%$valor%';";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }
    public function insertar($data){
        global $wpdb;
        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
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
        $identificacion = array(
            "numero" => $data['id_num'],
            "f_ini" => $data['id_ini'],
            "f_fin" => $data['id_fin'],
            "pais" => $data['id_pais'],
            "foto" => $data['id_foto'],
            "tipo" => $data['id_tip'],
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
        $direccion = array(
            "nombre" => $data['direccion'],
            "distrito" => $data['dir_distrito'],
            "ciudad" => $data['dir_ciudad'],
            "pais" => $data['dir_pais']
        );
        for($i=0;$i<sizeof($direccion['direccion']);$i++){
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
        echo json_encode($data);
    }
}

$pasajero = new Pasajero;

if(isset($_POST['buscar'])){
    $pasajero->buscar($_POST['buscar']);
}

if(isset($_POST['insertar'])){
    $data = array(
        "nombres" => $_POST['nombre'], 
        "apellidos" => $_POST['apellido'],
        "nacionalidad" => $_POST['nacionalidad'],
        "nacimiento" => $_POST['nacimiento'],
        "notas" => $_POST['observacion'],
        "direccion" => $_POST['direccion'],
        "dir_distrito" => $_POST['distrito'],
        "dir_ciudad" => $_POST['ciudad'],
        "dir_pais" => $_POST['pais'],
        "telefono" => $_POST['telefono'],
        "correo" => $_POST['correo'],
        "id_tip" => $_POST['TipoID'],
        "id_num" => $_POST['identificacion'],
        "id_ini" => $_POST['f_emision'],
        "id_fin" => $_POST['f_vencimiento'],
        "id_nota" => $_POST['id_nota'],
        "id_pais" => $_POST['id_pais'],        
        "id_foto" => $_POST['id_foto'],        
    );
    $pasajero->insertar($data);
}
