<?php
require($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

class Pasajero {
    private $tabla = "pdm_contacto";

    public function __construct() {}
    
    public function listar(){
        global $wpdb;
        $sql = "SELECT ".$this->tabla."_id as id, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_foto as foto, ".$this->tabla."_fuente as fuente, ".$this->tabla."_estado as estado, pdm_telefono_numero as telefono, pdm_correo_correo as correo, pdm_identificacion_numero as documento FROM ".$this->tabla." LEFT JOIN pdm_telefono ON pdm_telefono_tabla = '".$this->tabla."' AND pdm_telefono_tabla_ID = ".$this->tabla."_id LEFT JOIN pdm_correo ON pdm_correo_tabla = '".$this->tabla."' AND pdm_correo_tabla_ID = ".$this->tabla."_id LEFT JOIN pdm_identificacion ON pdm_identificacion_tabla = '".$this->tabla."' AND pdm_identificacion_tabla_ID = ".$this->tabla."_id GROUP BY id LIMIT 1500;";
        $resultados = $wpdb->get_results($sql, OBJECT);
        // console_log($sql);
        echo json_encode($resultados);
    }

    public function obtener($id){
        global $wpdb;
        $sql = "SELECT ".$this->tabla."_id as id, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_nacimiento as nacimiento, ".$this->tabla."_nacionalidad as nacionalidad, ".$this->tabla."_foto as foto, ".$this->tabla."_notas as notas, ".$this->tabla."_fuente as fuente FROM ".$this->tabla." WHERE ".$this->tabla."_id = $id;";
        $pasajero = $wpdb->get_results($sql, OBJECT);

        $sql="SELECT pdm_telefono_id as id, pdm_telefono_numero as telefono FROM pdm_telefono WHERE pdm_telefono_tabla = 'pdm_contacto' AND pdm_telefono_tabla_ID = $id;";
        $telefono = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_correo_id as id, pdm_correo_correo as correo FROM pdm_correo WHERE pdm_correo_tabla = 'pdm_contacto' AND pdm_correo_tabla_ID = $id;";
        $correo = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_identificacion_id as id, pdm_identificacion_numero as numero, pdm_identificacion_tipo as tipo, pdm_identificacion_pais as pais, pdm_identificacion_emision as emision, pdm_identificacion_vencimiento as vencimiento, pdm_identificacion_nota as nota, pdm_identificacion_foto as foto FROM pdm_identificacion WHERE pdm_identificacion_tabla = 'pdm_contacto' AND pdm_identificacion_tabla_ID = $id;";
        $identificacion = $wpdb->get_results($sql, OBJECT);

        $sql = "SELECT pdm_direccion_pais as pais, pdm_direccion_ciudad as ciudad, pdm_direccion_distrito as distrito, pdm_direccion_nombre as nombre, pdm_direccion_id as id FROM pdm_direccion WHERE pdm_direccion_tabla = 'pdm_contacto' AND pdm_direccion_tabla_id = $id";
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

    public function agregarTel(){
        global $wpdb;
        $telefono = $_POST['telefono'];
        $paxid = $_POST['paxId'];
        $wpdb->insert($tab = "pdm_telefono", $data = array(
            "pdm_telefono_numero" => $telefono,
            "pdm_telefono_tabla" => $this->tabla,
            "pdm_telefono_tabla_ID" => $paxid
        ));
        $tabid = $wpdb->insert_id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data)),
            "pdm_registro_usuario" => get_current_user_id()
        ));
    }

    public function agregarCor(){
        global $wpdb;
        $correo = $_POST['correo'];
        $paxid = $_POST['paxId'];
        $wpdb->insert($tab = "pdm_correo", $data = array(
            "pdm_correo_correo" => $correo,
            "pdm_correo_tabla" => $this->tabla,
            "pdm_correo_tabla_ID" => $paxid
        ));
        $tabid = $wpdb->insert_id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data)),
            "pdm_registro_usuario" => get_current_user_id()
        ));
    }

    public function borrar($id){
        global $wpdb;
        $table = $this->tabla;
        $cid = $this->tabla."_id";
        $sql = "DELETE FROM $table WHERE $cid = $id;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }

    public function borrarTel(){
        global $wpdb;
        $id=$_POST['telId'];
        $table = 'pdm_telefono';
        $cid = $table."_id";
        $sql = "DELETE FROM $table WHERE $cid = $id;";
        $wpdb->query($sql);
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($table, $id, 'eliminado')),
            "pdm_registro_usuario" => get_current_user_id()
        ));
    }

    public function borrarCor(){
        global $wpdb;
        $id=$_POST['corId'];
        $table = 'pdm_correo';
        $cid = $table."_id";
        $sql = "DELETE FROM $table WHERE $cid = $id;";
        $wpdb->query($sql);
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($table, $id, 'eliminado')),
            "pdm_registro_usuario" => get_current_user_id()
        ));
    }

    public function actualizar(){
        // $campo = $table."_".$campo;
        // $sql = "UPDATE $table SET $campo = '$valor' WHERE $cid = $id;";
        // $resultado = $wpdb->query($sql);
        global $wpdb;
        $table = $this->tabla;
        $cid = $table."_id";
        $id = $_POST['paxId'];
        $wpdb->update(
            $table,
            $data = array(
                $table.'_nombres' => $_POST["nombre"],
                $table.'_apellidos' => $_POST["apellido"],
                $table.'_nacionalidad' => $_POST["nacionalidad"],
                $table.'_nacimiento' => $_POST["nacimiento"],
                $table.'_notas' => $_POST["observacion"],
                $table.'_fuente' => $_POST["fuente"]
            ),
            array($cid => $id)
        );
        $tabid = $id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($table, $tabid, $data, 'actualizado')),
            "pdm_registro_usuario" => get_current_user_id()
        ));
        echo json_encode($id);
    }

    public function actualizarTel(){
        global $wpdb;
        $table = "pdm_telefono";
        $cid = $table."_id";
        $campo = $table."_numero";
        $id = $_POST['telId'];
        $valor = $_POST['telefono'];
        $sql = "UPDATE $table SET $campo = '$valor' WHERE $cid = $id;";
        $wpdb->query($sql);
        $tabid = $id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($table, $tabid, array($campo => $valor), 'actualizado')),
            "pdm_registro_usuario" => get_current_user_id()
        ));
    }

    public function actualizarCor(){
        global $wpdb;
        $table = "pdm_correo";
        $cid = $table."_id";
        $campo = $table."_correo";
        $id = $_POST['corId'];
        $valor = $_POST['correo'];
        $sql = "UPDATE $table SET $campo = '$valor' WHERE $cid = $id;";
        $wpdb->query($sql);
        $tabid = $id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($table, $tabid, array($campo => $valor), 'actualizado')),
            "pdm_registro_usuario" => get_current_user_id()
        ));
    }
    
    public function buscar($valor){
        global $wpdb;
        $sql = "SELECT ".$this->tabla."_id as id, ".$this->tabla."_nombres as nombres, ".$this->tabla."_apellidos as apellidos, ".$this->tabla."_foto as foto, ".$this->tabla."_fuente as fuente, ".$this->tabla."_estado as estado, pdm_telefono_numero as telefono, pdm_correo_correo as correo, pdm_identificacion_numero as documento FROM ".$this->tabla." LEFT JOIN pdm_telefono ON pdm_telefono_tabla = '".$this->tabla."' AND pdm_telefono_tabla_ID = ".$this->tabla."_id LEFT JOIN pdm_correo ON pdm_correo_tabla = '".$this->tabla."' AND pdm_correo_tabla_ID = ".$this->tabla."_id LEFT JOIN pdm_identificacion ON pdm_identificacion_tabla = '".$this->tabla."' AND pdm_identificacion_tabla_ID = ".$this->tabla."_id WHERE ".$this->tabla."_nombres LIKE '%$valor%' OR ".$this->tabla."_apellidos LIKE '%$valor%' GROUP BY id LIMIT 20;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }
    public function insertar(){
        global $wpdb; 
        $wpdb->insert($this->tabla, $pasajero = array(
            $this->tabla.'_nombres' => $_POST["nombre"],
            $this->tabla.'_apellidos' => $_POST["apellido"],
            $this->tabla.'_nacionalidad' => $_POST["nacionalidad"],
            $this->tabla.'_nacimiento' => $_POST["nacimiento"],
            $this->tabla.'_notas' => $_POST["observacion"],
            $this->tabla.'_fuente' => $_POST["fuente"],
            $this->tabla.'_estado' => "PROSPECTO",
        ));
        $paxid = $wpdb->insert_id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($this->tabla, $paxid, $pasajero, 'insertado')),
            "pdm_registro_usuario" => get_current_user_id()
        ));

        $telefono = $_POST['telefono'];
        $codigo = $_POST['codigo'];
        for($i=0;$i<sizeof($telefono);$i++){
            $wpdb->insert($tab = "pdm_telefono", $data = array(
                "pdm_telefono_numero" => $codigo[$i].$telefono[$i],
                "pdm_telefono_tabla" => $this->tabla,
                "pdm_telefono_tabla_ID" => $paxid
            ));
            $tabid = $wpdb->insert_id;
            $wpdb->insert("pdm_registro", array(
                "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data, 'insertado')),
                "pdm_registro_usuario" => get_current_user_id()
            ));
        }
        $correo = $_POST['correo'];
        for($i=0;$i<sizeof($correo);$i++){
            $wpdb->insert($tab = "pdm_correo", $datos = array(
                "pdm_correo_correo" => $correo[$i],
                "pdm_correo_tabla" => $this->tabla,
                "pdm_correo_tabla_ID" => $paxid
            ));
            $tabid = $wpdb->insert_id;
            $wpdb->insert("pdm_registro", array(
                "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data, 'insertado')),
                "pdm_registro_usuario" => get_current_user_id()
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
                $wpdb->insert($tab = "pdm_identificacion", $datos = array(
                    "pdm_identificacion_tabla" => $this->tabla,
                    "pdm_identificacion_tabla_ID" => $paxid,
                    "pdm_identificacion_tipo" => $identificacion['tipo'][$i],
                    "pdm_identificacion_numero" => $identificacion['numero'][$i],
                    "pdm_identificacion_pais" => $identificacion['pais'][$i],
                    "pdm_identificacion_emision" => $identificacion['f_ini'][$i],
                    "pdm_identificacion_vencimiento" => $identificacion['f_fin'][$i],
                    "pdm_identificacion_nota" => $identificacion['nota'][$i],
                    "pdm_identificacion_foto" => $identificacion['foto'][$i]
                ));
                $tabid = $wpdb->insert_id;
                $wpdb->insert("pdm_registro", array(
                    "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data, 'insertado')),
                    "pdm_registro_usuario" => get_current_user_id()
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
                $wpdb->insert($tab = "pdm_direccion", $datos = array(
                    "pdm_direccion_tabla" => $this->tabla,
                    "pdm_direccion_tabla_ID" => $paxid,
                    "pdm_direccion_nombre" => $direccion['nombre'][$i],
                    "pdm_direccion_distrito" => $direccion['distrito'][$i],
                    "pdm_direccion_ciudad" => $direccion['ciudad'][$i],
                    "pdm_direccion_pais" => $direccion['pais'][$i],
                ));
                $tabid = $wpdb->insert_id;
                $wpdb->insert("pdm_registro", array(
                    "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data, 'insertado')),
                    "pdm_registro_usuario" => get_current_user_id()
                ));
            }
        }
        $wpdb->insert($tab = "pdm_historial", $datos = array(
            "pdm_historial_tabla" => $this->tabla,
            "pdm_historial_tabla_id" => $paxid,
            "pdm_historial_usuario" => get_current_user_id(),
            "pdm_historial_contenido" => "Contacto creado",
        ));
        $tabid = $wpdb->insert_id;
        $wpdb->insert("pdm_registro", array(
            "pdm_registro_contenido" => json_encode(array($tab, $tabid, $data)),
            "pdm_registro_usuario" => get_current_user_id()
        ));
        echo json_encode($paxid);
    }

    public function solicitudes($id){
        global $wpdb;
        $sql="SELECT pdm_solicitud_id as id, pdm_solicitud_inicio as inicio, pdm_solicitud_estado as estado, pdm_solicitud_servicios as servicios, pdm_solicitud_fecha_tipo as fechaTipo, pdm_solicitud_fecha_salida as salida, pdm_solicitud_fecha_retorno as retorno, pdm_solicitud_origen as origen, pdm_solicitud_destino as destino, pdm_solicitud_cantidad_adt as adultos, pdm_solicitud_cantidad_chd as ninos, pdm_solicitud_cantidad_inf as bebes, pdm_solicitud_descripcion as descripcion FROM pdm_solicitud WHERE pdm_solicitud_pasajero_ID = $id;";
        $resultado = $wpdb->get_results($sql, OBJECT);
        echo json_encode($resultado);
    }
    public function AgregarFoto(){
        global $wpdb;
        $table = $this->tabla;
        $id=$_POST['paxId'];
        if($_FILES["fileToUpload"]["size"] != 0){
            $target_dir = RUTA."src/imagenes/$table/";
            $target_file = $target_dir . basename($id.".jpg");
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            // if(isset($_POST["submit"])) {
            //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            //     if($check !== false) {
            //         echo "File is an image - " . $check["mime"] . ".";
            //         $uploadOk = 1;
            //     } else {
            //         echo "File is not an image.";
            //         $uploadOk = 0;
            //     }
            // }
            // Check if file already exists
            // if (file_exists($target_file)) {
            //     echo "Sorry, file already exists.";
            //     $uploadOk = 0;
            // }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 2000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } 
            else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    // echo "The file ". basename($id). " has been uploaded.";
                } else {
                    // echo "No se subió ningún archivo.";
                }
            }
            $wpdb->update(
                $table,
                $data = array( $table."_foto" => "/wp-content/plugins/pdm-admin/src/imagenes/$table/$id.jpg" ),
                array( $table."_id" => $id )
            );
            $wpdb->insert("pdm_registro", array(
                "pdm_registro_contenido" => json_encode(array($table, $id, $data)),
                "pdm_registro_usuario" => get_current_user_id()
            ));    
            echo json_encode($id);
        }
    }       
}

$pasajero = new Pasajero;

if(isset($_POST['buscar'])){
    $pasajero->buscar($_POST['buscar']);
}

if(isset($_GET['obtener'])){
    $pasajero->obtener($_GET['obtener']);
}

if($_POST['listar']){
    $pasajero->listar();
}

if(isset($_POST['insertar'])){
    $pasajero->insertar();
}

if(isset($_POST['actualizar'])){
    $pasajero->actualizar();
}

if(isset($_POST['actualizarTel'])){
    $pasajero->actualizarTel();
}

if(isset($_POST['actualizarCor'])){
    $pasajero->actualizarCor();
}

if(isset($_POST['agregarTel'])){
    $pasajero->agregarTel();
}

if(isset($_POST['agregarCor'])){
    $pasajero->agregarCor();
}

if(isset($_POST['borrarTel'])){
    $pasajero->borrarTel();
}

if(isset($_POST['borrarCor'])){
    $pasajero->borrarCor();
}

if(isset($_POST['actualizarFoto'])){
    $pasajero->AgregarFoto();
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
