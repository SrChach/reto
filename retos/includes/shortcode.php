<?php 
	if(!defined('ABSPATH'))
		exit;

	//	Crea un Shortcode, uso: [quizbook preguntas="" orden=""]
	function quizbook_shortcode( $atts ){
		$args = array(
			'post_type' => 'quizes',
			'posts_per_page' => -1
		);
		$quizbook = get_posts($args);
		if(!$quizbook){
			echo "comienza por agregar preguntas en Quiz";
		} else {
?>
			<div>
				<div id="quizbook" class="quizbook">
					<ul>
						<h2>Casos Clínicos</h2>
						<?php 
							$casos = 0;
							foreach ($quizbook as $key => $value) {
							$datosCaso = get_post_meta( $value->ID );
							//echo "<pre>" . var_dump($value) . "</pre>";
						?>
								<form name="quiz_a_mostrar" id="postID_<?php echo trim($value->ID); ?>" class="quiz_a_mostrar">
									<span class=""><?php echo $value->post_title; ?></span>
									<br><span class="">Reto presentado por</span>
									<span class=""><?php echo $datosCaso["qb_nombre_autor"][0]; ?></span>
									<br><input type='submit' value='VER CASO' id='quiz_mostrar_submit'>
								</form>
						<?php
							}
						?>
					</ul>
				</div>

				<div id="single_case" class="single_case">
					<span class="">Caso presentado por:</span>
					<br><span class="" id="meta_author"></span>
					<br><span id="meta_title"></span>
					
					<br><span class="">CASO</span>
					<br><span id="quiz_content"></span><br>
					<button class="mostrarEvidencia">Continuar</button>
				</div>

				<div id="evidencia-container">
					<span class="">EVIDENCIA</span>
				<div id="evidencia" class="evidencia"></div>
				<button id="mostrarCaso">REGRESAR</button><button id="mostrarDiagnostico">CONTINUAR</button>
				</div>

				<form name="quizbook_enviar" id="quizbook_enviar">
					<div id="diagnostico">
						<div id="diagnostico-content">
							<div class="respuesta respuesta1"></div>
							<input type="radio" class="respuesta1">
							<div class="respuesta respuesta2"></div>
							<input type="radio" class="respuesta2">
							<div class="respuesta respuesta3"></div>
							<input type="radio" class="respuesta3">
							<div class="respuesta respuesta4"></div>
							<input type="radio" class="respuesta4">
						</div>
						<button type="button" class="mostrarEvidencia">REGRESAR</button>
						<button type="submit" value="enviar" id="quizbook_btn_submit">CONTINUAR</button>
					</div>
				</form>	

				<div id="results">
					<div>
						<span>Tu diagnóstico ha sido</span><br>
						<span id="result-u"></span><br>
						<span>Sus colegas opinan:</span><br>
					</div>
					<div id="result-a"></div>
					<div id="result-b"></div>
					<div id="result-c"></div>
					<div id="result-d"></div>
				</div>

				<div id="cargando">
					<i class="fa fa-refresh fa-spin"></i>
				</div>

			</div>

<?php 
		}
	}
	add_shortcode( 'retos_diagnostico', 'quizbook_shortcode' ); 
?>