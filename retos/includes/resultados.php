<?php 
	if(!defined('ABSPATH'))
		exit;

	//	Recibe paràmetros desde quizbook.js y devuelve un resultado AJAX
	function quizbook_resultados(){
		if (isset($_POST['data'])) {
			$respuestas = $_POST['data'];
		}
		$resultado = 0;
		$totalPreguntas = 0;
		$others = array();
		$tmp = 0;
		foreach($respuestas as $resp){
			$pregunta = explode(':', $resp);
			/*
				$pregunta[0] = post_id
				$pregunta[1] = respuesta del usuario
			*/

			//	Recibe la cantidad total de preguntas en el cuestionario con índice -1

			array_push($others,  "a:".get_post_meta( $pregunta[0], 'qb_cantidad_a', true ) );
			array_push($others,  "b:".get_post_meta( $pregunta[0], 'qb_cantidad_b', true ) );
			array_push($others,  "c:".get_post_meta( $pregunta[0], 'qb_cantidad_c', true ) );
			array_push($others,  "d:".get_post_meta( $pregunta[0], 'qb_cantidad_d', true ) );
			array_push($others,  "u:" . $pregunta[1] .":" . get_post_meta( $pregunta[0], 'qb_respuesta_d', true ) );

			$tmp = get_post_meta( $pregunta[0], 'qb_cantidad_'.$pregunta[1], true );
			$tmp++;
			update_post_meta( $pregunta[0], 'qb_cantidad_'.$pregunta[1], $tmp );
			
			$correcta = get_post_meta( $pregunta[0], 'quizbook_correcta', true );

			/*
				$letra_correcta[0] = qb_correcta
				$letra_correcta[1] = letra correcta :V
			*/

			$letra_correcta = explode(':', $correcta);

			if($letra_correcta[1] === $pregunta[1] ){
				$resultado += 1;
			}
		}

		$total_examen = array(
			'total' => $resultado,
			'totResp' => $others
		);

		header('Content-type: application/json');
		echo json_encode($total_examen);
		die();
	}
	add_action('wp_ajax_nopriv_quizbook_resultados', 'quizbook_resultados');
	add_action('wp_ajax_quizbook_resultados', 'quizbook_resultados');


	function quizbook_show_one(){
		if (isset($_POST['data'])) {
			$respuestas = $_POST['data'];
		}

		$args = array(
			'post_type' => 'quizes',
			'p' => $respuestas[0]
		);

		$quizbook = get_posts($args)[0];
		$nuevo = explode('src=', $quizbook->post_content);
		$urls = array();
		foreach ($nuevo as $key => $value) {
			if($value[0] == '"'){
				array_push($urls, explode('"', $value)[1]);
			}
		}

		$opciones = get_post_meta($quizbook->ID);
		$meta = array();
		$meta_options = array();
		$meta_author = array();
		foreach ($opciones as $llave => $opcion) {
			$resultado = quizbook_filter_preguntas($llave, 'qb_respuesta');
			if($resultado === 0){
				$numero = explode('_', $llave);
				array_push($meta, $quizbook->ID .':'. $numero[2]);
				array_push($meta_options, $opcion[0]);
			}
		}
		//array_push($meta_author, );

		$rspta = array (
			'quiz_title' => $quizbook->post_title,
			'quiz_content' => strip_tags($quizbook->post_content),
			'urls' => $urls,
			'meta' => $meta,
			'meta_options' => $meta_options,
			'meta_author' => $opciones["qb_nombre_autor"][0],
			'meta_title' => $opciones["qb_titulo_autor"][0]
		);
		//strip_tags($quizbook->post_content)

		header('Content-type: application/json');
		echo json_encode($rspta);
		die();
	}
	add_action('wp_ajax_nopriv_quizbook_show_one', 'quizbook_show_one');
	add_action('wp_ajax_quizbook_show_one', 'quizbook_show_one');





?>