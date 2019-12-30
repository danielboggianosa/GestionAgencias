<?php
add_action('admin_menu', 'pdm_remove_menus');
add_action( 'admin_head', 'pdm_remove_menus', 1 );

function pdm_remove_menus(){
  remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'jetpack' );                    //Jetpack* 
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  //remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  remove_action( 'admin_notices', 'update_nag', 3 ); //Update Message
    
/*** QUITAR PÁGINAS CREADAS POR DEFECTO ***/
    wp_delete_post(1);
    $postid = get_page_by_title('Página de ejemplo')->ID;
    wp_delete_post($postid);
}

add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'site-name' );    
    $wp_admin_bar->remove_node( 'comments' );    
    $wp_admin_bar->remove_node( 'new-post' );
    $wp_admin_bar->remove_node( 'new-media' );
    $wp_admin_bar->remove_node( 'new-page' );    
}
?>