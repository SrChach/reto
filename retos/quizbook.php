<?php 
/*
	Plugin Name: Reto Diagnostico
	Plugin URI:
	Description: Plugin para añadir retos
	Version: 1.0
	Author: AdAcosta
	Author URI: 
	License: GPL2
	License URI: https://www.gnu.org/licences/gpl-2.0.html
	Text Domain: quizbook
*/
if(!defined('ABSPATH'))
	exit;

//Añade los Post Type del plugin
require_once plugin_dir_path(__FILE__) . 'includes/posttypes.php';

//	Regenera las reglas de las URLS al activar
register_activation_hook(__FILE__, 'quizbook_rewrite_flush');

//	Añade Metaboxes a los Quizes
require_once plugin_dir_path(__FILE__) . 'includes/metaboxes.php';

//	Añade roles y Capabilities a los Quizes
require_once plugin_dir_path(__FILE__) . 'includes/roles.php';
register_activation_hook(__FILE__, 'quizbook_crear_role');
register_deactivation_hook(__FILE__, 'quizbook_remover_role');

//	Añade Capabilities a los Quizes
register_activation_hook(__FILE__, 'quizbook_agregar_capabilities');
register_deactivation_hook(__FILE__, 'quizbook_remover_capabilities');

//	Añade un Shortcode
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

//	Funciones
require_once plugin_dir_path(__FILE__) . 'includes/funciones.php';

//	Añade CSS's y JS
require_once plugin_dir_path(__FILE__) . 'includes/scripts.php';

//	Da los resultados del exámen
require_once plugin_dir_path(__FILE__) . 'includes/resultados.php';

//Añade nuevos posttypes y capabilities a Premium
register_activation_hook(__FILE__, 'quizbook_examenes_rewrite_flush');

?>