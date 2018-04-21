
function lista_ja_existe( nome_lista ) {
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = "lista_ja_existe=" + nome_lista;
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_lista_ja_existe, true );
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
				xmlTagsName = xmlDoc.getElementsByTagName( "lista_existe" );
				
				// Obtem o status do criar nova lista
				lista_existe = xmlTagsName[0].getElementsByTagName( "resposta" )[0].firstChild.nodeValue;
					
				if( lista_existe == "sim" ) {
					
					return true;
					
				}
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
			}
			
		}
		
	}
	
	return false;
	
}
