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

    function itinerario_post_type(){
        register_post_type('itinerario', ['public' => true, 'label' => 'Itinerarios', 'menu_icon' => 'dashicons-palmtree']);
    }

    // Register Custom Post Type
    function custom_post_type() {
    
        $labels = array(
            'name'                => _x( 'products', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( 'Products', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'All Items', 'text_domain' ),
            'view_item'           => __( 'View Item', 'text_domain' ),
            'add_new_item'        => __( 'Add New Item', 'text_domain' ),
            'add_new'             => __( 'Add New', 'text_domain' ),
            'edit_item'           => __( 'Edit Item', 'text_domain' ),
            'update_item'         => __( 'Update Item', 'text_domain' ),
            'search_items'        => __( 'Search Item', 'text_domain' ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( 'Products', 'text_domain' ),
            'description'         => __( 'Post Type Description', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( ),
            'taxonomies'          => array( 'category', 'post_tag' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-cart',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type( 'Products', $args );
    
    }
 

}
if(class_exists('PasajerosDelMundo')){
    $pasajeroDelMundo = new PasajerosDelMundo();
}