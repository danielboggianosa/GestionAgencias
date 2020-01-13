<?php
/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link        https://danielboggiano.com
 * @since       1.0.0
 * @package     PDM-ADMIN
 *
 * @wordpress-plugin
 * Plugin Name: AA Gestión de Agencia de Viajes
 * Plugin URI:  https://danielboggiano.com/
 * Description: Este es un sistema de gestión especializado para agencias de viajes
 * Version:     1.0.0
 * Author:      Daniel Boggiano
 * Author URI:  https://danielboggiano.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: passajerosdelmundo
 * Domain Path: /languages
 */

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

global $wpdb;
$pdm_db_version = '2.0';

defined( 'ABSPATH' ) or die('Go Away');
$site = ABSPATH;
define('RUTA', "$site/wp-content/plugins/pdm-admin/");

//require RUTA."src/init/remove-menu.php";
require RUTA."src/init/funciones.php";

class PasajerosDelMundo {
    
    /*** LLAMADO A TODOS LOS ARCHIVOS DE CONFIGURACIÓN  ***/
    function __construct(){
        require RUTA."src/init/logindetails.php";     
        add_action('init', array($this, 'itinerario_post_type'), 0);
        add_action('init', array($this, 'instalar_db'), 0);
        add_action('init', array($this, 'crear_menus'), 0);
    }
    
    public function activation(){
    }

    // Register Custom Post Type
    function itinerario_post_type() {
    
        $labels = array(
            'name'                => _x( 'itinerario', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Itinerario', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Itinerarios', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'Todos', 'text_domain' ),
            'view_item'           => __( 'Ver Itinerario', 'text_domain' ),
            'add_new_item'        => __( 'Nuevo Itinerario', 'text_domain' ),
            'add_new'             => __( 'Nuevo', 'text_domain' ),
            'edit_item'           => __( 'Editar', 'text_domain' ),
            'update_item'         => __( 'Actualizar', 'text_domain' ),
            'search_items'        => __( 'Buscar', 'text_domain' ),
            'not_found'           => __( 'No se encontró', 'text_domain' ),
            'not_found_in_trash'  => __( 'No se encontró en la papelera', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'Itinerarios', 'text_domain' ),
            'description'         => __( 'Post Type Description', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( ),
            'taxonomies'          => array( 'category', 'post_tag' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-palmtree',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'rewrite'             => true,
            'supports'            => array('title', 'editor', 'thumbnail', 'comments', 'slug'),
        );
        register_post_type( 'itinerario', $args );
    
    }
    
    //COMPORBAR SI LAS TABLAS YA ESTÁN PRESENTES
    function instalar_db(){
        global $wpdb;
        $existe = true;
        require RUTA."src/database/database.php";
        $sql="SHOW TABLES;";
        $resultados = $wpdb->get_results($sql, OBJECT);
        $registros = array();
        foreach($resultados as $resultado){
            array_push($registros, $resultado->Tables_in_agencia);
        }
        $newTablas = array_keys($tablas);
        // console_log($newTablas);
        // console_log($registros);
        foreach($newTablas as $tabla){
            $existe = array_search($tabla, $registros);
            if($existe == false){
                // console_log($tabla);
                $wpdb->query($tablas[$tabla], OBJECT);
            }
        }
    }

    function crear_menus(){
        require RUTA."src/init/add-menu.php";
        add_action( 'admin_menu', 'pdm_add_menu_page' );
    }
 

}
if(class_exists('PasajerosDelMundo')){
    $pasajeroDelMundo = new PasajerosDelMundo();
}

//activación
// register_activation_hook( __FILE__, array( $pasajeroDelMundo , 'activation' ) );