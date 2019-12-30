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