(function($){
	$( document ).ready(function() {
		var qb_notsubmitted = true;

		function init(){
			$("#quizbook").show();
			$("#single_case").hide();
			$("#evidencia-container").hide();
			$("#diagnostico").hide();
			$("#results").hide();
			$("#cargando").hide();
		}
			
		$(".mostrarEvidencia").on('click', function() {
			$("#single_case").hide();
			$("#evidencia-container").show();
			$("#diagnostico").hide();
		});

		$("#mostrarCaso").on('click', function(){
			$("#quizbook").hide();
			$("#single_case").show();
			$("#evidencia-container").hide();
		});

		$("#mostrarDiagnostico").on('click', function(){
			$("#evidencia-container").hide();
			$("#diagnostico").show();
		});

		$(".respuesta").on('click', function() {
			$(this).siblings().removeAttr('data-seleccionada');
			$(this).attr('data-seleccionada', true);
			$(this).siblings().removeClass('seleccionada');
			$(this).addClass('seleccionada');
			$.each(this.className.split(" "), function(llave, valor) {
				if(valor.search("respuesta") != -1 && valor.length > 9){
					console.log(valor);
					console.log($("." + valor));
				}
			});
		});

		$("#quizbook_enviar").on('submit', function(e){
			e.preventDefault();
			var tp = $(".qb_p").length;
			var respuestas = $('[data-seleccionada]');
			if(respuestas.length < 1){
				alert("Seleccione una respuesta por favor");
				return;
			}
			var id_respuestas = [];
			var cont = 1;

			$.each(respuestas, function(llave, valor) {
				id_respuestas.push(valor.id);
			});

			var datos = {
				action: 'quizbook_resultados',
				data: id_respuestas
			};
			
			$.ajax({
				url: admin_url.ajax_url,
				type: 'POST',
				data: datos,
				beforeSend: function() {
					$("#quizbook").hide();
					$("#single_case").hide();
					$("#evidencia-container").hide();
					$("#diagnostico").hide();
					$("#results").hide();
					$("#cargando").show();
				}
			}).done(function(respuesta) {
				$("#results").show();
				var inform;
				$("#quizbook_enviar").hide();
				$.each(respuesta["totResp"], function(llave, valor) {
					inform = valor.split(":");
					if(inform[0] != "u"){
						$("#result-"+inform[0]).text(inform[0] + " " + $(".respuesta"+cont).html() + " " + inform[1]);
						cont++;
					}else{
						if(respuesta["total"] == 1)
							$("#result-u").text(inform[2] + " (correcta)");
						else
							$("#result-u").text(inform[2] + " (incorrecta)");
					}
				});
				$("#cargando").hide();
			});

			
		});

		$(".quiz_a_mostrar").on('submit', function(e) {
			e.preventDefault();
			var cont = 1;
			var postID = [];
			postID.push($(this).attr('id').split("_")[1]+"");
			var algo = {
				action: 'quizbook_show_one',
				data: postID
			};
			
			$.ajax({
				url: admin_url.ajax_url,
				type: 'POST',
				data: algo,
				beforeSend: function() {
					$("#quizbook").hide();
					$("#single_case").hide();
					$("#evidencia-container").hide();
					$("#diagnostico").hide();
					$("#results").hide();
					$("#cargando").show();
				}
			}).done(function(respuesta) {
				$("#quizbook").hide();
				$("#single_case").show();
				$("#quiz_title").text(respuesta["quiz_title"]);
				$("#quiz_content").text(respuesta["quiz_content"]);
				$("#meta_author").text(respuesta["meta_author"]);
				$("#meta_title").text(respuesta["meta_title"]);
				if(respuesta['urls'].length > 0){
					$.each(respuesta["urls"], function(llave, valor) {
						$('#evidencia').prepend('<img id="theImg" src="'+ valor +'" />');
					});
				} else {
					$('#evidencia').text("no hay imágenes disponibles para este caso");
				}
				$.each(respuesta['meta'], function(llave, valor) {
					$(".respuesta"+cont).attr("id", valor);
					cont++;
				});
				cont = 1;
				$.each(respuesta['meta_options'], function(llave, valor) {
					$(".respuesta"+cont).text(valor);
					cont++;
				});
				$("#cargando").hide();
			});
			
		});
		
		init();
	});
})(jQuery);