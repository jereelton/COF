
function acessar_lista_salva( nome_lista ) {
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = "acessar_lista_salva=" + nome_lista;
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_acessar_lista_salva, true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( params );
	
	// Obtendo o retorno do processamento PHP tipo XML
	xmlhttp.onreadystatechange = function () {
		
		// verifica se o objeto xmlhttprequest esta pronto e correto
		if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) {
			
			if ( xmlhttp.status == 200 ) {
				
				// Guarda o retorno do xml
				xmlResponse = xmlhttp.responseText;
					
				if( xmlResponse == "sucesso" ) {
					
					window.location = "lista_compra.php";
					
				} else{
					
					mensagem = "<h2>" + xmlResponse + ": Nao foi possivel criar a sessao para " + nome_lista + " !</h2>";
					mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
					
				}
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
			}
			
		}
		
	}
	
	return false;
	
}
