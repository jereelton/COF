
function excluir_confirmado( elemento ) {
	
	var nome_arquivo = document.getElementById( "input_hidden_excluir_lista" ).value;
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = "deletar_arquivo=" + nome_arquivo;
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_deletar_arquivo, true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( params );
	
	// Obtendo o retorno do processamento PHP tipo XML
	xmlhttp.onreadystatechange = function () {
		
		// verifica se o objeto xmlhttprequest esta pronto e correto
		if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) {
			
			if ( xmlhttp.status == 200 ) {
				
				// Guarda o retorno do xml
				xmlDoc      = xmlhttp.responseXML;
				
				// Obtem as tags que abrem e fecham o xml
				xmlTagsName = xmlDoc.getElementsByTagName( "arquivo_deletado" );
				
				// Obtem o status do criar nova lista
				deletou_arquivo = xmlTagsName[0].getElementsByTagName( "resposta" )[0].firstChild.nodeValue;
					
				if( deletou_arquivo == "sucesso" ) {
					
					mensagem = "<h2>Arquivo " + nome_arquivo + " deletado com sucesso !</h2>";
					mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
					
					fechar_elemento_simples( elemento );
					
					if(verificar_tag_criada("div", "div_mostra_listas_salvas")) {
						
						carregar_listas_salvas( "div_mostra_listas_salvas" );
						
					} else {
						
						carregar_listas_salvas( "div_mostra_abrir_listas_salvas" );
						
					}
					
				} else{
					
					mensagem = "<h2>Nao foi possivel deletar o arquivo " + nome_arquivo + " !</h2>";
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
