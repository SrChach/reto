<?php 
	if(!defined('ABSPATH'))
		exit;

	function quizbook_agregar_metaboxes(){

		//Agrega el Metabox a Quizes
		add_meta_box('quizbook_datos_autor', 'Datos_Autor', 'qb_datos_autor', 'quizes', 'normal', 'high', null);
		add_meta_box('quizbook_meta_box', 'Respuestas', 'quizbook_metaboxes', 'quizes', 'normal', 'high', null);
	}
	add_action( 'add_meta_boxes', 'quizbook_agregar_metaboxes' );


	function qb_datos_autor($post){
		wp_nonce_field( basename(__FILE__), 'quizbook_nonce' );

		?>
			<table class="form-table">
				<tr>
					<th class="row-title"><h2>Datos del autor aquí</h2></th>
				</tr>
				<tr>
					<th class="row-title"><label for="nombre_autor">Nombre del autor</label></th>
					<td>
						<input value="<?php echo esc_attr(get_post_meta( $post->ID, 'qb_nombre_autor', true )); ?>" type="text" id="nombre_autor" name="qb_nombre_autor" class="regular-text">
					</td>
				</tr>
				<tr>
					<th class="row-title"><label for="titulo_autor">Titulo y datos importantes del autor</label></th>
					<td>
						<input value="<?php echo esc_attr(get_post_meta( $post->ID, 'qb_titulo_autor', true ));  ?>" type="text" id="titulo_autor" name="qb_titulo_autor" class="regular-text">
					</td>
				</tr>
			</table>
		<?php
	}

	function qb_guardar_datos_autor($post_id, $post, $update){
		if ( !isset($_POST['quizbook_nonce']) || !wp_verify_nonce($_POST['quizbook_nonce'], basename(__FILE__)) ){
			return $post_id;
		}

		if(!current_user_can('edit_post', $post_id)){
			return $post_id;
		}

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return $post_id;
		}

		$nombre_autor = $titulo_autor = '';

		if( isset($_POST['qb_nombre_autor']) )
			$nombre_autor = sanitize_text_field( $_POST['qb_nombre_autor'] );
		update_post_meta($post_id, 'qb_nombre_autor', $nombre_autor);
		
		if( isset($_POST['qb_titulo_autor']) )
			$titulo_autor = sanitize_text_field( $_POST['qb_titulo_autor'] );
		update_post_meta( $post_id, 'qb_titulo_autor', $titulo_autor );
	}
	add_action('save_post', 'qb_guardar_datos_autor', 10, 3);


	// Muestra el HTML de los metaboxes
	function quizbook_metaboxes($post){
		wp_nonce_field( basename(__FILE__), 'quizbook_nonce' );

?>
		<table class="form-table">
			<tr>
				<th class="row-title"><h2>Añade las respuestas aquí</h2></th>
			</tr>
			<tr>
				<th class="row-title"><label for="respuesta_a">a)</label></th>
				<td>
					<!-- true es "single", si fuera false retornarìa un arreglo -->
					<input value="<?php echo esc_attr(get_post_meta( $post->ID, 'qb_respuesta_a', true )); ?>" type="text" id="respuesta_a" name="qb_respuesta_a" class="regular-text">
					<input value="<?php echo esc_attr( get_post_meta( $post->ID, 'qb_cantidad_a', true )); ?>" type="hidden" id="cantidad_a" name="qb_cantidad_a">
				</td>
			</tr>
			<tr>
				<th class="row-title"><label for="respuesta_b">b)</label></th>
				<td>
					<input value="<?php echo esc_attr(get_post_meta( $post->ID, 'qb_respuesta_b', true ));  ?>" type="text" id="respuesta_b" name="qb_respuesta_b" class="regular-text">
					<input value="<?php echo esc_attr( get_post_meta( $post->ID, 'qb_cantidad_b', true )); ?>" type="hidden" id="cantidad_b" name="qb_cantidad_b">
				</td>
			</tr>
			<tr>
				<th class="row-title"><label for="respuesta_c">c)</label></th>
				<td>
					<input value="<?php echo esc_attr(get_post_meta( $post->ID, 'qb_respuesta_c', true ));  ?>" type="text" id="respuesta_c" name="qb_respuesta_c" class="regular-text">
					<input value="<?php echo esc_attr( get_post_meta( $post->ID, 'qb_cantidad_c', true )); ?>" type="hidden" id="cantidad_c" name="qb_cantidad_c">
				</td>
			</tr>
			<tr>
				<th class="row-title"><label for="respuesta_d">d)</label></th>
				<td>
					<input value="<?php echo esc_attr(get_post_meta( $post->ID, 'qb_respuesta_d', true ));  ?>" type="text" id="respuesta_d" name="qb_respuesta_d" class="regular-text">
					<input value="<?php echo esc_attr( get_post_meta( $post->ID, 'qb_cantidad_d', true )); ?>" type="hidden" id="cantidad_d" name="qb_cantidad_d">
				</td>
			</tr>
			<tr>
				<th class="row-title"><label for="respuesta_correcta">Respuesta Correcta</label></th>
				<td>
					<?php $respuesta = esc_html(get_post_meta( $post->ID, 'quizbook_correcta', true )); ?>
					<select name="quizbook_correcta" id="respuesta_correcta" class="postbox">
						<option value="">Elige la respuesta correcta</option>
						<option <?php selected($respuesta, 'qb_correcta:a'); ?> value="qb_correcta:a">a</option>
						<option <?php selected($respuesta, 'qb_correcta:b'); ?> value="qb_correcta:b">b</option>
						<option <?php selected($respuesta, 'qb_correcta:c'); ?> value="qb_correcta:c">c</option>
						<option <?php selected($respuesta, 'qb_correcta:d'); ?> value="qb_correcta:d">d</option>
					</select>
				</td>
			</tr>
		</table>
<?php 
	}


	function quizbook_guardar_metaboxes($post_id, $post, $update){
		if ( !isset($_POST['quizbook_nonce']) || !wp_verify_nonce($_POST['quizbook_nonce'], basename(__FILE__)) ){
			return $post_id;
		}

		if(!current_user_can('edit_post', $post_id)){
			return $post_id;
		}

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return $post_id;
		}

		$respuesta_1 = $respuesta_2 = $respuesta_3 = $respuesta_4 = $correcta = '';
		$cantidad_1 = $cantidad_2 = $cantidad_3 = $cantidad_4 = 0;

		if( isset($_POST['qb_respuesta_a']) )
			$respuesta_1 = sanitize_text_field( $_POST['qb_respuesta_a'] );
		update_post_meta($post_id, 'qb_respuesta_a', $respuesta_1);
		
		if( !isset($_POST['qb_cantidad_a']) || $_POST['qb_cantidad_a'] == '' )
			update_post_meta( $post_id, 'qb_cantidad_a', 0 );

		if( isset($_POST['qb_respuesta_b']) )
			$respuesta_2 = sanitize_text_field( $_POST['qb_respuesta_b'] );
		update_post_meta($post_id, 'qb_respuesta_b', $respuesta_2);

		if( !isset($_POST['qb_cantidad_b']) || $_POST['qb_cantidad_b'] == '' )
			update_post_meta( $post_id, 'qb_cantidad_b', 0 );

		if( isset($_POST['qb_respuesta_c']) )
			$respuesta_3 = sanitize_text_field( $_POST['qb_respuesta_c'] );
		update_post_meta($post_id, 'qb_respuesta_c', $respuesta_3);

		if( !isset($_POST['qb_cantidad_c']) || $_POST['qb_cantidad_c'] == '' )
			update_post_meta( $post_id, 'qb_cantidad_c', 0 );

		if( isset($_POST['qb_respuesta_d']) )
			$respuesta_4 = sanitize_text_field( $_POST['qb_respuesta_d'] );
		update_post_meta($post_id, 'qb_respuesta_d', $respuesta_4);

		if( !isset($_POST['qb_cantidad_d']) || $_POST['qb_cantidad_d'] == '' )
			update_post_meta( $post_id, 'qb_cantidad_d', 0 );

		if( isset($_POST['quizbook_correcta']) )
			$correcta = sanitize_text_field( $_POST['quizbook_correcta'] );
		update_post_meta($post_id, 'quizbook_correcta', $correcta);
	}
	add_action('save_post', 'quizbook_guardar_metaboxes', 10, 3);


?>