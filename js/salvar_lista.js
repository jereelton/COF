
function salvar_lista( opcao ) {
			
	if( validar_campo_vazio( "input_cria_nova_lista" ) == true  && opcao ==  "nova_lista" ) {
		
		mensagem = "<h2>Faltou informar o nome da lista !</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
		
		return false;
		
	}
	
	var checa_qtde_itens  = document.getElementById( "input_hidden_qtde_itens" ).value;
	var checa_session_php = document.getElementById( "input_hidden_nome_lista" ).value;
	
	/*if( checa_qtde_itens == 0 || checa_qtde_itens == "Nenhum Item" ) {

		mensagem = "<h2>A lista esta vazia !</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
		return false;
	}*/
	
	if( checa_session_php == "" || ! checa_session_php ) {
		
		mensagem = "<h2>Ocorreu um erro na sessao ativa PHP !</h2></h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
		
		return false;
		
	}
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params     = configurar_parametros( opcao );
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_salvar_lista, true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( params );
	
	// Obtendo o retorno do processamento PHP tipo XML
	xmlhttp.onreadystatechange = function () {
		
		// verifica se o objeto xmlhttprequest esta pronto e correto
		if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) { 
			
			if ( xmlhttp.status == 200 ) {
				
				// Guarda o retorno do xml
				xmlDoc      = xmlhttp.responseXML;
				
				// Obtem as tags que abrem e fecham o xml <resposta_salvar></resposta_salvar>
				xmlTagsName = xmlDoc.getElementsByTagName( "lista_salva" );
				
				// Obtem o status do salvar lista
				salvou_lista = xmlTagsName[0].getElementsByTagName( "resposta" )[0].firstChild.nodeValue;
				
				if( salvou_lista == "SIM" ) {
					
					mensagem = "<h2>Lista salva com sucesso !</h2>";
					mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
					
				} else{
					
					mensagem = "<h2>Nao foi possivel salvar a lista !</h2>";
					mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
					
				}
					
				fechar_elemento( "div_salvar_lista" );
				
			} else { 
				
				mensagem = "<h2>XmlHttpRequest falhou !</h2>";
				mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
				
			}
			
		}
		
	}
	
	return false;
	
}
