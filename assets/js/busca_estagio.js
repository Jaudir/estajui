$(document).ready(function(){
	$('#filtrar').click(function(){
		
	//	var valor = $('#nome_aluno').val();
		
		$.ajax({

			url: "http://localhost/estajui/scripts/controllers/generico/listar-estagios.php",
			/*,
			type: "post",
			dataType:"json",
			data:{				
				aluno: "pau no cu de rodrigo"
			},*/
			dataType:"json"
			 ,statusCode: {
				200: function (resposta) {
				console.log(resposta);
				alert(resposta["nome"]);
				
				
					$('#myTable > tbody:last-child').append("<tr>resposta['nome']</tr>");
			
				}
			 }
		});
	});
});