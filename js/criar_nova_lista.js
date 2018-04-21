
function criar_nova_lista() {
	
	if( validar_campo_vazio( "input_nome_nova_lista" ) == true ) {
		
		mensagem = "<h2>O campo de nome para a lista nao pode estar vazio !</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
		return false;
		
	}
	
	var nome_lista = document.getElementById( "input_nome_nova_lista" ).value;
	
	if( lista_ja_existe( nome_lista ) == true ) {
		
		mensagem = "<h2>A lista " + nome_lista + " ja existe!</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
		return false;
		
	}
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = "criar_nova_lista=" + nome_lista;
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_criar_nova_lista, true );
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
				xmlTagsName = xmlDoc.getElementsByTagName( "lista_criada" );
				
				// Obtem o status do criar nova lista
				criou_lista = xmlTagsName[0].getElementsByTagName( "resposta" )[0].firstChild.nodeValue;
					
				if( criou_lista == "sucesso" ) {
				
					abrir_elemento( 'div_ver_lista_criada' );
					fechar_elemento( 'div_nova_lista' );
					
					document.getElementById( "input_nome_nova_lista" ).value = "";
					
				} else{
					
					mensagem = "<h2>Nao foi possivel criar a lista !</h2>";
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
