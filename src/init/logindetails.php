<?php
function my_login_logo(){ 
    $logo = site_url()."/wp-content/plugins/ohana-sdg/recursos/logo.png"; ?>
    <style type="text/css">
        #login h1 a, .login h1 a{
        background-image: url(<?php echo $logo ?>);
        height:150px;
		width:150px;
		background-size: 150px 150px;
		background-repeat: no-repeat;
        	padding-bottom: 0px;
        }
    </style>
<?php 
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return get_site_url()."/";
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    $site_name = get_bloginfo('name');
    return 'Creado por Daniel Boggiano para '.get_bloginfo('name');
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

?>