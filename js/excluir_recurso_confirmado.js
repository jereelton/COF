
function excluir_recurso_confirmado( elemento ) {
	
	// Recurso para excluir
	var nome_recurso       = document.getElementById( "input_hidden_excluir_recurso" ).value;
	var valor_recurso      = document.getElementById( "input_hidden_valor_recurso"   ).value;
	
	// Valores para atualizar
	var total_recursos     = document.getElementById( "input_dinheiro_compra"        ).value;
	var total_compra       = document.getElementById( "input_total_compra"           ).value;
	var saldo_atual        = document.getElementById( "input_saldo_compra"           ).value;
	var recursos_guardados = document.getElementById( "input_hidden_guarda_recursos" ).value;
	
	// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
	iniciar_xmlhttp();
	
	// Variaveis para processar
	var retornoXml = "";
	var params = "";
	params += "deletar_recurso="     + nome_recurso;
	params += "&valor_recurso="      + valor_recurso;
	params += "&total_recursos="     + total_recursos;
	params += "&total_compra="       + total_compra;
	params += "&saldo_atual="        + saldo_atual;
	params += "&recursos_guardados=" + recursos_guardados;
	
	// Configurando envio dos parametros para processamento
	xmlhttp.open( 'POST', url_excluir_recurso_confirmado, true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( params );
	
	// Obtendo o retorno do processamento PHP tipo XML
	xmlhttp.onreadystatechange = function () {
		
		// verifica se o objeto xmlhttprequest esta pronto e correto
		if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) {
			
			if ( xmlhttp.status == 200 ) {
				
				/* Exemplo de resposta
				<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
				<recurso_deletado>\n";
					<resposta>sucesso</resposta>\n";
					<novo_saldo_compra>"       . $novo_saldo_compra       . "</novo_saldo_compra>\n";
					<novo_recurso_total>"      . $novo_recurso_total      . "</novo_recurso_total>\n";
					<novo_recursos_guardados>" . $novo_recursos_guardados . "</novo_recursos_guardados>\n";
				</recurso_deletado>\n";
				*/
				
				// Guarda o retorno do xml
				xmlDoc = xmlhttp.responseXML;
				
				// Obtem as tags que abrem e fecham o xml
				xmlTagsName = xmlDoc.getElementsByTagName( "recurso_deletado" );
				
				// Obtem o status do criar nova lista
				deletou_recurso = xmlTagsName[0].getElementsByTagName( "resposta" )[0].firstChild.nodeValue;
				
				if( deletou_recurso == "sucesso" ) {
					
					/* Tem que atualizar os saldos e recursos da lista atual */
					
					// Obtem o novo saldo para a compra
					novo_saldo_compra = xmlTagsName[0].getElementsByTagName( "novo_saldo_compra"  )[0].firstChild.nodeValue;
					
					// Obtem o Recurso total + Recurso aplicado
					novo_recurso_total = xmlTagsName[0].getElementsByTagName( "novo_recurso_total"  )[0].firstChild.nodeValue;
					
					// Obtem a lista de recursos atuais menos o recurso excluido
					try  {
						
						novo_recursos_guardados = xmlTagsName[0].getElementsByTagName( "novo_recursos_guardados" )[0].firstChild.nodeValue;
						
					} catch(e) {
						
						novo_recursos_guardados = "";
						
					}
					
					// Mostra o novo saldo
					document.getElementById( "input_saldo_compra"           ).value = novo_saldo_compra;
					
					// Atribui o valor do total de recurso aplicado
					document.getElementById( "input_dinheiro_compra"        ).value = novo_recurso_total;
					
					// Atualiza o valor de input_hidden_guarda_recursos com o novo recurso
					document.getElementById( "input_hidden_guarda_recursos" ).value = novo_recursos_guardados;
					
					verificar_saldo_atual();
					
					salvar_lista_automaticamente();
					
					fechar_elemento_simples( elemento );
					
					carregar_recursos_aplicados( "div_mostra_recursos_aplicados" );
					
					abrir_elemento( "div_ver_recursos" );
					
					document.getElementById( "input_hidden_excluir_recurso" ).value = "";
					document.getElementById( "input_hidden_valor_recurso"   ).value = "";
					
					mensagem = "<h2>Recurso " + nome_recurso + " deletado com sucesso !</h2>";
					mostra_mensagem( "div_mensagens_sucesso", mensagem, tempo );
					
				} else {
					
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
