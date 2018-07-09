<?php 
if(!defined('ABSPATH'))
	exit;

function quizbook_post_type() {
	$labels = array(
		'name'                  => _x( 'Reto', 'Post type general name', 'quizbook' ),
		'singular_name'         => _x( 'Reto', 'Post type singular name', 'quizbook' ),
		'menu_name'             => _x( 'Retos', 'Admin Menu text', 'quizbook' ),
		'name_admin_bar'        => _x( 'Reto', 'Add New on Toolbar', 'quizbook' ),
		'add_new'               => __( 'Add New', 'quizbook' ),
		'add_new_item'          => __( 'Add New Reto', 'quizbook' ),
		'new_item'              => __( 'New Reto', 'quizbook' ),
		'edit_item'             => __( 'Editar Reto', 'quizbook' ),
		'view_item'             => __( 'Ver Reto', 'quizbook' ),
		'all_items'             => __( 'Todos Retos', 'quizbook' ),
		'search_items'          => __( 'Buscar Retos', 'quizbook' ),
		'parent_item_colon'     => __( 'Padre Retos:', 'quizbook' ),
		'not_found'             => __( 'No encontrados.', 'quizbook' ),
		'not_found_in_trash'    => __( 'No encontrados.', 'quizbook' ),
		'featured_image'        => _x( 'Imagen Destacada', '', 'quizbook' ),
		'set_featured_image'    => _x( 'Añadir imagen destacada', '', 'quizbook' ),
		'remove_featured_image' => _x( 'Borrar imagen', '', 'quizbook' ),
		'use_featured_image'    => _x( 'Usar como imagen', '', 'quizbook' ),
		'archives'              => _x( 'Retos Archivo', '', 'quizbook' ),
		'insert_into_item'      => _x( 'Insertar en Reto', '', 'quizbook' ),
		'uploaded_to_this_item' => _x( 'Cargado en este Reto', '', 'quizbook' ),
		'filter_items_list'     => _x( 'Filtrar Retos por lista', '”. Added in 4.4', 'quizbook' ),
		'items_list_navigation' => _x( 'Navegación de Retos', '', 'quizbook' ),
		'items_list'            => _x( 'Lista de Retos', '', 'quizbook' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'quizes' ),
		'capability_type'    => array('quiz', 'quizes'),
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-welcome-learn-more',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor'),
		'map_meta_cap'       => true
	);

	register_post_type( 'quizes', $args );
}

add_action( 'init', 'quizbook_post_type' );

function quizbook_examenes_post_type() {
	$labels = array(
		'name'               => _x( 'Examenes', 'post type general name', '' ),
		'singular_name'      => _x( 'Examen', 'post type singular name', '' ),
		'menu_name'          => _x( 'Examenes', 'admin menu', '' ),
		'name_admin_bar'     => _x( 'Examen', 'add new on admin bar', '' ),
		'add_new'            => _x( 'Agregar Nuevo', 'book', '' ),
		'add_new_item'       => __( 'Agregar New Examen', '' ),
		'new_item'           => __( 'Nuevo Examen', '' ),
		'edit_item'          => __( 'Editar Examen', '' ),
		'view_item'          => __( 'Ver Examen', '' ),
		'all_items'          => __( 'Todos Examenes', '' ),
		'search_items'       => __( 'Buscar Examenes', '' ),
		'parent_item_colon'  => __( 'Padre Examenes:', '' ),
		'not_found'          => __( 'No hay examenes aún.', '' ),
		'not_found_in_trash' => __( 'No hay examenes en el basurero.', '' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Añade la posibilidad de crear examenes a tus Quizes', '' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'examenes' ),
		'capability_type'    => array('quiz', 'quizes'),
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-welcome-write-blog',
		'has_archive'        => true,
		'hierarchical'       => false,
        'supports'           => array( 'title' ),
        'map_meta_cap'       => true,
	);

	register_post_type( 'examenes', $args );
}

add_action( 'init', 'quizbook_examenes_post_type' );

/**
 * Flush rewrite rules on activation.
 */
function quizbook_examenes_rewrite_flush() {
	quizbook_examenes_post_type();
	flush_rewrite_rules();
}

/*
*	Flush Rewrite
*/

function quizbook_rewrite_flush(){
	quizbook_post_type();
	flush_rewrite_rules();
}

?>