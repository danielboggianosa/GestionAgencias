<?php
add_action( 'admin_menu', 'pdm_add_menu_page' );
//add_action( 'admin_menu', 'pdm_add_submenu_page' );

function pdm_add_menu_page() {
    $usuario = array( 'suscriptor' => 'read', 'colaborador' => 'edit_posts', 'autor' => 'upload_files', 'editor' => 'manage_categories', 'administrador' => 'manage_options' );
    add_menu_page(
        'Inicio',
        'Inicio',
        $usuario["colaborador"], 
        'pdm-index', 
        'pdm_index',
        'dashicons-admin-home',
        6
    );
    add_menu_page(
        'Pasajeros',
        'Pasajeros',
        $usuario["colaborador"], 
        'pdm-pasajeros', 
        'pdm_pasajeros',
        'dashicons-groups',
        8
    );
    add_menu_page(
        'Cotizaciones',
        'Cotizaciones',
        $usuario["colaborador"], 
        'pdm-cotizaciones', 
        'pdm_cotizaciones',
        'dashicons-twitter',
        9
    );
    // add_menu_page(
    //     'Productos',
    //     'Productos',
    //     $usuario["colaborador"], 
    //     'pdm-productos', 
    //     'pdm_productos',
    //     'dashicons-products',
    //     10
    // );
    // add_menu_page(
    //     'Proveedores',
    //     'Proveedores',
    //     $usuario["colaborador"], 
    //     'pdm-proveedores', 
    //     'pdm_proveedores',
    //     'dashicons-businessman',
    //     12
    // );
    // add_menu_page(
    //     'Ventas',
    //     'Ventas',
    //     $usuario["colaborador"], 
    //     'pdm-ventas', 
    //     'pdm_ventas',
    //     'dashicons-cart',
    //     13
    // );
    // add_menu_page(
    //     'Compras',
    //     'Compras',
    //     $usuario["colaborador"], 
    //     'pdm-compras', 
    //     'pdm_compras',
    //     'dashicons-screenoptions',
    //     14
    // );
    // add_menu_page(
    //     'Inventario',
    //     'Inventario',
    //     $usuario["colaborador"], 
    //     'pdm-inventario', 
    //     'pdm_inventario',
    //     'dashicons-clipboard',
    //     15
    // );
    // add_menu_page(
    //     'Contabilidad',
    //     'Contabilidad',
    //     $usuario["administrador"], 
    //     'pdm_contabilidad', 
    //     'pdm_contabilidad',
    //     'dashicons-chart-bar',
    //     16
    // );
    // add_menu_page(
    //     'Colaboradores',
    //     'Colaboradores',
    //     $usuario["administrador"], 
    //     'pdm_colaboradores', 
    //     'pdm_colaboradores',
    //     'dashicons-networking',
    //     17
    // );
    // add_menu_page(
    //     'Agenda',
    //     'Agenda',
    //     $usuario["administrador"], 
    //     'pdm_agenda', 
    //     'pdm_agenda',
    //     'dashicons-calendar-alt',
    //     18
    // );
}
function pdm_index(){
    include RUTA."src/views/pages/inicio.php";
}
function pdm_cotizaciones(){
    include RUTA."src/views/pages/cotizaciones.php";
}
function pdm_pasajeros(){
    include RUTA."src/views/pages/pasajeros.php";
}
// function pdm_productos(){
//     include RUTA."views/pages/productos.php";
// }
// function pdm_proveedores(){
//     include RUTA."views/pages/proveedores.php";
// }
// function pdm_ventas(){
//     include RUTA."views/pages/ventas.php";
// }
// function pdm_compras(){
//     include RUTA."views/pages/compras.php";
// }
// function pdm_inventario(){
//     include RUTA."views/pages/inventario.php";
// }
// function pdm_contabilidad(){
//     include RUTA."views/pages/contabilidad.php";
// }
// function pdm_colaboradores(){
//     include RUTA."views/pages/colaboradores.php";
// }
// function pdm_agenda(){
//     include RUTA."views/pages/agenda.php";
// }

add_action( 'admin_bar_menu', 'pdm_add_subpage', 999 );

function pdm_add_subpage( $wp_admin_bar ){
    $args = array(
		'id'    => 'print',
		'title' => '<span class="ab-icon dashicons dashicons-media-text"></span><span class="ab-lable">Imprimir</span>',
        'href' => '#',
		'meta'  => array( 
                    'class' => 'ab-item',
                    'onclick' => 'print()',
                        )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
		'id'    => 'send-mail',
		'title' => '<span class="ab-icon dashicons dashicons-email-alt"></span> Enviar por Correo',
        'href' => site_url()."/wp-admin/admin.php?page=pdm-index",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-customer',
		'title' => 'Cliente',
		'href'  => site_url()."/wp-admin/admin.php?page=pdm-clientes&cliente=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-pet',
		'title' => 'Mascota',
		'href'  => site_url()."/wp-admin/admin.php?page=pdm-animales&animal=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-employee',
		'title' => 'Colaborador',
		'href'  => site_url()."/wp-admin/admin.php?page=pdm-colaboradores&colaborador=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-sell',
		'title' => 'Venta',
		'href'  => site_url()."/wp-admin/admin.php?page=pdm-ventas&venta=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-buy',
		'title' => 'Compras',
		'href'  => site_url()."/wp-admin/admin.php?page=pdm-compras&compra=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-supplier',
		'title' => 'Proveedor',
		'href'  => site_url()."/wp-admin/admin.php?page=pdm-proveedores&proveedor=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
    $args = array(
        'parent' => 'new-content',
		'id'    => 'new-product',
		'title' => 'Producto',
		'href'  => site_url()."/wp-admin/admin.php?page=pdm-productos&producto=nuevo",
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
}