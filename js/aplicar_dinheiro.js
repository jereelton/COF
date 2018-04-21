
function aplicar_dinheiro() {
	
	// Obtem o novo valor para dinheiro aplicado
	var id_recurso_aplicado    = document.getElementById( "input_id_novo_dinheiro"       ).value;
	var valor_recurso_aplicado = document.getElementById( "input_novo_dinheiro"          ).value;
	var total_recursos_atuais  = document.getElementById( "input_dinheiro_compra"        ).value;
	var total_compra           = document.getElementById( "input_total_compra"           ).value;
	var recursos_guardados     = document.getElementById( "input_hidden_guarda_recursos" ).value;
	
	if( id_recurso_aplicado == "" || ! id_recurso_aplicado ) {
		
		mensagem = "<h2>Informe o nome do recurso !</h2>";
		mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
		
		return false;
		
	}
		
	var recurso_adicionado = id_recurso_aplicado + ":" + valor_recurso_aplicado + ";";
	
	if( valor_recurso_aplicado != "0,00" ) {
		
		// Inicia o objeto XMLHttpRequest e verifica se foi criado corretamente
		iniciar_xmlhttp();
		
		var retornoXml = "";
		var params     = "aplicar_dinheiro=" + total_compra + ":" + valor_recurso_aplicado + ":" + id_recurso_aplicado + ":" + total_recursos_atuais;
			
		xmlhttp.open( 'POST', url_aplicar_dinheiro, true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( params );
		
		// Obtendo o retorno do processamento PHP tipo XML
		xmlhttp.onreadystatechange = function () {
			
			// verifica se o objeto xmlhttprequest esta pronto e correto
			if( xmlhttp.readyState == 4 || xmlhttp.readyState == 0 || xmlhttp.readyState == "complete" ) { 
				
				if ( xmlhttp.status == 200 ) {
					
					// Guarda o retorno do xml
					xmlDoc      = xmlhttp.responseXML;
					
					// Obtem as tags que abrem e fecham o xml <calculando_total></calculando_total>
					xmlTagsName = xmlDoc.getElementsByTagName( "calculos_compra" );
					
					// Obtem o novo saldo para a compra
					novo_saldo_compra = xmlTagsName[0].getElementsByTagName( "saldo_compra"  )[0].firstChild.nodeValue;
					
					// Obtem o Recurso total + Recurso aplicado
					recurso_total = xmlTagsName[0].getElementsByTagName( "recurso_total"  )[0].firstChild.nodeValue;
					
					// Mostra o novo saldo
					document.getElementById( "input_saldo_compra" ).value = novo_saldo_compra;
					
					// Atribui o valor do total de recurso aplicado
					document.getElementById( "input_dinheiro_compra" ).value = recurso_total;
					
					// Reseta o valor dos inputs para aplicar recrusos
					document.getElementById( "input_novo_dinheiro"    ).value = "0,00";
					document.getElementById( "input_id_novo_dinheiro" ).value = "";
					
					// Atualiza o valor de input_hidden_guarda_recursos com o novo recurso
					document.getElementById( "input_hidden_guarda_recursos" ).value = recursos_guardados + recurso_adicionado;
					
					verificar_saldo_atual();
					salvar_lista_automaticamente();
					
				} else {
					
					mensagem = "<h2>XmlHttpRequest falhou !</h2>";
					mostra_mensagem( "div_mensagens_erro", mensagem, tempo );
					
				}
				
			}
			
		}
	
	}
	
	// Fecha a div apos aplicar o novo dinheiro e calcular o novo saldo
	fechar_elemento( "div_aplica_dinheiro" );
	
	return false;
	
}
