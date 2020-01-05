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

global $wpdb;
$pdm_db_version = '2.0';

defined( 'ABSPATH' ) or die('Go Away');
$site = ABSPATH;
define('RUTA', "$site/wp-content/plugins/pdm-admin/");

/*** LLAMADO A TODOS LOS ARCHIVOS DE CONFIGURACIÓN  ***/

require RUTA."src/init/logindetails.php";
//require RUTA."src/init/remove-menu.php";
require RUTA."src/init/add-menu.php";
require RUTA."src/init/funciones.php";
require RUTA."src/database/database.php";

//COMPORBAR SI LAS TABLAS YA ESTÁN PRESENTES
$sql="DESCRIBE ".DB_NAME.".pdm_pasajero";
$resultado = $wpdb->get_results($sql, OBJECT);
if(sizeof($resultado)==0){
    register_activation_hook( __FILE__, 'pdm_db_install' );
}

class PasajerosDelMundo {
    function __construct(){
        add_action('init', array($this, 'itinerario_post_type'), 0);
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
 

}
if(class_exists('PasajerosDelMundo')){
    $pasajeroDelMundo = new PasajerosDelMundo();
}